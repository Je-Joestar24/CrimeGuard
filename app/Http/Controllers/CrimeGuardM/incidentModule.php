<?php

namespace App\Http\Controllers\CrimeGuardM;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CrimeGuardM\Dynamic\DynamicFunctions;
use App\Http\Controllers\CrimeGuardM\Dynamic\IncidentFunctions;
use App\Mail\IncidentResponseMail;
use App\Models\Addresses;
use App\Models\IncidentNarative;
use App\Models\IncidentReportingPerson;
use App\Models\Incidents;
use App\Models\IncidentSuspects;
use App\Models\IncidentVictims;
use App\Models\OfficerCredential;
use App\Models\Rejections;
use App\Models\ReportingPerson;
use App\Models\Suspects;
use App\Models\TrailLog;
use App\Models\User;
use App\Models\Victims;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\IncidentAssignedMail;
use App\Models\PoliceStation;

use function PHPUnit\Framework\isNull;

class IncidentModule extends Controller
{
    protected $dynamic;
    protected $incidentFun;

    public function __construct(DynamicFunctions $dynamic, IncidentFunctions $incident)
    {
        $this->dynamic = $dynamic;
        $this->incidentFun = $incident;
    }
    //displaying data to the table
    public function displayIncidents(Request $request)
    {
        $data = [
            'table' => [
                'headers' => ['id', 'incident name', 'location', 'date', 'time', 'status', '# of suspects', '# of victims'],
                'type' => 1,
                'data' => []
            ],
            'response' => 'Error'
        ];

        try {
            $query = Incidents::leftJoin('incident-suspects', 'incidents.id', '=', 'incident-suspects.incident')
                ->leftJoin('suspects', 'incident-suspects.suspect', '=', 'suspects.id')
                ->leftJoin('incident-types', 'incidents.incident_type', '=', 'incident-types.id')
                ->leftJoin('incident-victims', 'incident-victims.incident', '=', 'incidents.id')
                ->leftJoin('victims', 'incident-victims.victim', '=', 'victims.id')
                ->select('incidents.id', 'incident-types.incident_name', 'incidents.location', 'incidents.time_of_incident', 'incidents.status')
                ->where('incidents.status', '!=', 'report')
                ->where('incidents.status', '!=', 'reject')
                ->where('incidents.status', '!=', 'respond')
                ->whereNull('incidents.archived_at')
                ->whereNull('incidents.archived_by')
                ->distinct();

            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('incidents.id', 'like', "%{$search}%")
                        ->orWhere('incident-types.incident_name', 'like', "%{$search}%")
                        ->orWhere('incidents.location', 'like', "%{$search}%")
                        ->orWhere('incidents.status', 'like', "%{$search}%");
                });
            }

            $incidents = $query->get();

            foreach ($incidents as $value) {
                $value['no_of_suspects'] = IncidentSuspects::join('suspects', 'incident-suspects.suspect', '=', 'suspects.id')
                    ->where('incident-suspects.incident', $value['id'])
                    ->whereNull('suspects.archived_at')
                    ->whereNull('suspects.deleted_by')->count();

                $value['no_of_victims'] = IncidentVictims::join('victims', 'incident-victims.victim', '=', 'victims.id')
                    ->whereNull('victims.archived_at')
                    ->whereNull('victims.deleted_by')
                    ->where('incident-victims.incident', $value['id'])->count();
                if ($value['time_of_incident']) {
                    $dateTime = explode(' ', $value['time_of_incident']);
                    $value['date'] = $dateTime[0];
                    $value['time'] = $dateTime[1];
                }
                $data['table']['data'][] = [
                    'id' => $value['id'],
                    'incident_name' => $value['incident_name'],
                    'location' => $value['location'],
                    'date' => $value['date'],
                    'time' => $value['time'],
                    'status' => $value['status'],
                    'no_of_suspects' => $value['no_of_suspects'],
                    'no_of_victims' => $value['no_of_victims']
                ];
            }

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            // Optionally log the error
            // Log::error($e);
        }

        return response()->json($data);
    }

    /* mod */
    public function generateReport(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();

        $data = [
            'table' => [
                'headers' => ['Entry #', 'incident name', 'location', 'date', 'time'],
                'type' => 1,
                'data' => []
            ],
            'response' => 'Error',
        ];
        $defaultDate = '0000-00-00 00:00:00';

        try {
            $query = Incidents::leftJoin('incident-suspects', 'incidents.id', '=', 'incident-suspects.incident')
                ->leftJoin('suspects', 'incident-suspects.suspect', '=', 'suspects.id')
                ->leftJoin('incident-types', 'incidents.incident_type', '=', 'incident-types.id')
                ->leftJoin('incident-victims', 'incident-victims.incident', '=', 'incidents.id')
                ->leftJoin('victims', 'incident-victims.victim', '=', 'victims.id')
                ->select('incidents.IRF_Entry_no', 'incidents.id', 'incident-types.incident_name', 'incidents.location', 'incidents.time_of_incident', 'incidents.status');
            if (!$request->input('status')) $query = $query->where('incidents.status', '!=', 'report')
                ->where('incidents.status', '!=', 'reject')
                ->where('incidents.status', '!=', 'respond');
            else $query = $query->where('incidents.status', $request->input('status'));
            $query = $query->whereNull('incidents.archived_at')
                ->whereNull('incidents.archived_by')
                ->distinct();

            if ($request->has('incident_type') && $request->input('incident_type') != -1) $query = $query->where('incidents.incident_type', $request->input('incident_type'));

            if ($request->has('date_start') && $request->input('date_start')) {
                $query = $query->where('incidents.time_of_incident', '>=', $request->input('date_start') . (" " . ($request->input('time_start') ? $request->input('time_start') . ":00" : explode(' ', $defaultDate)[1])));
            }

            if ($request->has('date_end') && $request->input('date_end')) {
                $query = $query->where('incidents.time_of_incident', '<=', $request->input('date_end') . (" " . ($request->input('time_end') ? $request->input('time_end') . ":00" : explode(' ', $defaultDate)[1])));
            }

            if ($request->has('barangay')) {
                $barangay = $request->input('barangay');
                $query = $query->where('incidents.barangay', 'like', "%{$barangay}%");
            }

            $incidents = $query->get();

            foreach ($incidents as $value) {
                $value['no_of_suspects'] = IncidentSuspects::join('suspects', 'incident-suspects.suspect', '=', 'suspects.id')
                    ->where('incident-suspects.incident', $value['id'])
                    ->whereNull('suspects.archived_at')
                    ->whereNull('suspects.deleted_by')->count();

                $value['no_of_victims'] = IncidentVictims::join('victims', 'incident-victims.victim', '=', 'victims.id')
                    ->whereNull('victims.archived_at')
                    ->whereNull('victims.deleted_by')
                    ->where('incident-victims.incident', $value['id'])->count();
                if ($value['time_of_incident']) {
                    $dateTime = explode(' ', $value['time_of_incident']);
                    $value['date'] = $dateTime[0];
                    $value['time'] = $dateTime[1];
                }
                $data['table']['data'][] = [
                    'IRF_Entry_no' => $value['IRF_Entry_no'],
                    'incident_name' => $value['incident_name'],
                    'location' => $value['location'],
                    'date' => $value['date'],
                    'time' => $value['time'],
                ];
            }

            $stationInfo = OfficerCredential::join('police-station', 'officer-credentials.station', 'police-station.id')
                ->select('police-station.name', 'police-station.location')
                ->where('officer-credentials.user_id', $request->id)
                ->first();

            $data['station'] = $stationInfo;
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            // Optionally log the error
            // Log::error($e);
        }

        return response()->json($data);
    }

    /* Map markers */
    public function incidentReportMarkers(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();

        $data['data'] = [];

        $station = $this->dynamic->getUserStation($request['id']);
        $station = $station['response'] ? $station['station']: null;
        try {
            $reports = Incidents::leftJoin('users', 'incidents.reported_by_user', '=', 'users.id')
                ->select(
                    'incidents.id',
                    'incidents.message',
                    'incidents.landmark',
                    'incidents.location',
                    'incidents.time_reported',
                    'users.profile',
                    'users.user_name',
                    'users.email',
                    'users.first_name',
                    'users.last_name',
                    'users.contact',
                    'incidents.longitude',
                    'incidents.latitude',
                    'incidents.report_type'
                );

            if ($station != 100) $reports = $reports->where('incidents.station', $station);
            $reports = $reports->where(function ($query) use ($currentDate) {
                $query->where('incidents.status', '=', 'report')
                    ->orWhere('incidents.status', '=', 'respond');
            })
                ->whereDate('incidents.date_reported',  $currentDate->format('Y-m-d'))
                ->get();

            foreach ($reports as $report) {
                $cleaned = [
                    'id' => $report['id'],
                    'user_name' => $report['user_name'],
                    'name' => $report['first_name'] . " " . $report["last_name"],
                    'email' => $report['email'],
                    'message' => $report['message'],
                    'location' => $report['location'],
                    'contact' => $report['contact'],
                    'pos' => [
                        'lat' => $report['latitude'],
                        'lng' => $report['longitude']
                    ],
                    'time' => explode(' ', $report['time_reported'])[1],
                    'month' => explode('-', explode(' ', $report['time_reported'])[0])[1],
                    'date' => explode('-', explode(' ', $report['time_reported'])[0])[2] . ", " . explode('-', explode(' ', $report['time_reported'])[0])[0],
                    'report_type' => $report['report_type'],
                    'profile' => $report['profile']
                ];
                array_push($data['data'], $cleaned);
            }
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    /* archive display */
    public function displayArchiveIncidents(Request $request)
    {
        $data = [];
        $data['table'] = [];
        $data['table']['headers'] = ['id', 'incident name', 'location', 'date', 'time', 'status', '# of suspects', '# of victims', 'deleted by', 'time deleted', 'date deleted'];
        $data['table']['data'] = [];
        $data['table']['type'] = 0;

        try {
            $query = Incidents::leftJoin('incident-suspects', 'incidents.id', '=', 'incident-suspects.incident')
                ->leftJoin('suspects', 'incident-suspects.suspect', '=', 'suspects.id')
                ->leftJoin('incident-types', 'incidents.incident_type', '=', 'incident-types.id')
                ->leftJoin('incident-victims', 'incident-victims.incident', '=', 'incidents.id')
                ->leftJoin('victims', 'incident-victims.victim', '=', 'victims.id')
                ->leftJoin('users', 'incidents.archived_by', '=', 'users.id')
                ->select([
                    'incidents.id',
                    'incident-types.incident_name',
                    'incidents.location',
                    'incidents.time_of_incident',
                    'incidents.status',
                    'users.user_name',
                    'incidents.archived_at'
                ])
                ->distinct()
                ->where('incidents.status', '!=', 'report')
                ->whereNotNull('incidents.archived_at')
                ->whereNotNull('incidents.archived_by');

            // Apply search if the search term is provided
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->orWhere('incident-types.incident_name', 'like', "%{$search}%")
                        ->orWhere('incidents.location', 'like', "%{$search}%")
                        ->orWhere('users.user_name', 'like', "%{$search}%")
                        ->orWhere('incidents.status', 'like', "%{$search}%")
                        ->orWhere('incidents.id', 'like', "%{$search}%");
                });
            }

            $incidents = $query->get();

            foreach ($incidents as $value) {
                $value['no_of_suspects'] = IncidentSuspects::where('incident', $value['id'])->count();
                $value['no_of_victims'] = IncidentVictims::where('incident', $value['id'])->count();
                $dateTime = explode(' ', $value['time_of_incident']);
                $value['date'] = $dateTime[0];
                $value['time'] = $dateTime[1];

                $data['table']['data'][] = [
                    'id' => $value['id'],
                    'incident_name' => $value['incident_name'],
                    'location' => $value['location'],
                    'date' => $value['date'],
                    'time' => $value['time'],
                    'status' => $value['status'],
                    'no_of_suspects' => $value['no_of_suspects'],
                    'no_of_victims' => $value['no_of_victims'],
                    'deleted_by' => $value['user_name'],
                    'time_deleted' => explode(' ', $value['archived_at'])[1],
                    'date_deleted' => explode(' ', $value['archived_at'])[0]
                ];
            }

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'error';
        }
        return response()->json($data);
    }

    public function archive(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $data = [];

        try {
            $archive = [
                'archived_at' => $currentDate->format('Y-m-d H:i:s'),
                'archived_by' => $request['deleted_by'],
                'deleted_by' => $request['archived_by']
            ];
            Incidents::where('id', $request['id'])->update($archive);
            $data['response'] = 'Success';

            TrailLog::create(['user_id' => $request->input('archived_by'), 'action' => 'deleted', 'item' => 'incident']);
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }
        return response()->json($data);
    }

    public function restore(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $data = [];

        try {
            $archive = [
                'archived_at' => NULL,
                'archived_by' => NULL,
                'deleted_by' => NULL
            ];
            Incidents::where('id', $request['id'])->update($archive);

            TrailLog::create(['user_id' => $request->input('user_id'), 'action' => 'restored', 'item' => 'incident']);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }
        return response()->json($data);
    }

    /* respond incident */
    public function respond(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $data = [];

        try {
            $archive = [
                'status' => 'respond',
                'edited_by' => $request['edited_by'],
                'rej_message' => null
            ];

            $incident = Incidents::findOrFail($request['id']);
            $incident->update($archive);

            $user = User::findOrFail($incident->reported_by_user);

            // Fixed message
            $message = "Wait for the police. Your report has already been noticed and police are now on the way to your location.";

            // Send email
            Mail::to($user->email)->send(new IncidentResponseMail($message));

            TrailLog::create(['user_id' => $user->id, 'item' => 'notify']);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e->getMessage();
        }
        return response()->json($data);
    }

    /* respond incident */
    public function reject(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $data = [];

        try {
            $archive = [
                'status' => 'reject',
                'assigned_to' => null,
                'edited_by' => $request['edited_by'],
                'rej_message' => $request->input('rej_message')
            ];

            Rejections::create(['reject_message' => $archive['rej_message'], 'incident_id' => $request->input('id'), 'user_id' => $request->input('edited_by')]);
            Incidents::where('id', $request['id'])->update($archive);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }
        return response()->json($data);
    }


    public function rejectMessages(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $currentDate = \Carbon\Carbon::now();

        $data = [];

        try {
            $reports = Rejections::leftJoin('users', 'rejections.user_id', '=', 'users.id')
                ->leftJoin('incidents', 'rejections.incident_id', '=', 'incidents.id') // Ensure incidents table is joined
                ->select(
                    'users.id',
                    'users.profile',
                    'rejections.reject_message',
                    'rejections.incident_id',
                    'users.user_name',
                    'users.first_name',
                    'users.last_name',
                    'users.email'
                )
                ->whereDate('incidents.created_at', $currentDate->toDateString()); // Compare only the date part

            $data['data'] = $reports->get()->toArray();
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e->getMessage();
        }

        return response()->json($data);
    }

    /* Citizen Side methods */


    public function incidentReportList(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();

        $data['data'] = [];


        try {
            $reports = Incidents::leftJoin('users', 'incidents.reported_by_user', '=', 'users.id')
                ->leftJoin('users as assign', 'incidents.assigned_to', '=', 'assign.id')
                ->select(
                    'incidents.id',
                    'incidents.message',
                    'incidents.landmark',
                    'incidents.location',
                    'incidents.time_reported',
                    'users.user_name',
                    'incidents.status',
                    'users.email',
                    'users.profile',
                    DB::raw("CONCAT(assign.first_name, ' ', assign.last_name) AS assigned_to"),
                    'incidents.rej_message'
                )->where('incidents.reported_by_user', '!=', NULL);
            if ($request->has('id')) $reports = $reports->where('incidents.assigned_to', $request->input('id'));
            if ($request->has('status')) $reports = $reports->where('incidents.status', 'respond');
            else {
                /* $reports = $reports->where(function ($query) use ($currentDate) {
                    $query->where('incidents.status', '=', 'report')
                    ->orWhere('incidents.status', '=', 'respond')
                        ->orWhere('incidents.status', '=', 'respond')
                        ->orWhere('incidents.status', '=', 'reject');
                }); */
            }


            if ($request->has('search') && !empty($request->input('search'))) {
                $searchTerm = $request->input('search');
                $reports = $reports->where(function ($q) use ($searchTerm) {
                    $q->where('users.first_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.last_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.user_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.email', 'like', "%{$searchTerm}%")
                        ->orWhere('users.contact', 'like', "%{$searchTerm}%")
                        ->orWhere('incidents.message', 'like', "%{$searchTerm}%")
                        ->orWhere('incidents.location', 'like', "%{$searchTerm}%")
                        ->orWhere('incidents.time_reported', 'like', "%{$searchTerm}%")
                        ->orWhere('incidents.status', 'like', "%{$searchTerm}%")
                        ->orWhere('incidents.rej_message', 'like', "%{$searchTerm}%");
                });
            }
            $reports = $reports->whereDate('incidents.date_reported',  $currentDate->format('Y-m-d'))
                ->get();
            foreach ($reports as $report) {
                $cleaned = [
                    'id' => $report['id'],
                    'user_name' => $report['user_name'],
                    'first_name' => $report['first_name'],
                    'last_name' => $report["last_name"],
                    'email' => $report['email'],
                    'message' => $report['message'],
                    'location' => $report['location'],
                    'time' => explode(' ', $report['time_reported'])[1],
                    'month' => explode('-', explode(' ', $report['time_reported'])[0])[1],
                    'date' => explode('-', explode(' ', $report['time_reported'])[0])[2] . ", " . explode('-', explode(' ', $report['time_reported'])[0])[0],
                    'status' => $report['status'],
                    'assigned_to' => $report['assigned_to'],
                    'rej_message' => $report['rej_message'],
                    'profile' => $report['profile']
                ];
                array_push($data['data'], $cleaned);
            }
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function incidentsCitizenDisplay(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $thirtyDaysAgo = (new DateTime())->modify('-30 days')->format('Y-m-d');

        $data['data'] = [];

        try {
            $incidents = Incidents::leftJoin('incident-types', 'incidents.incident_type', '=', 'incident-types.id');

            if (isset($request) && isset($request['id'])) $incidents = $incidents->join('incident-reporting-persons', 'incident-reporting-persons.incident', '=', 'incidents.id');

            $incidents = $incidents->where('incidents.status', '!=', 'report')
                ->where('incidents.status', '!=', 'reject')
                ->where('incidents.incident_type', '!=', NULL)

                /* 
                ->where('incidents.date_reported', '>=', $thirtyDaysAgo) */;
            if (isset($request) && isset($request['id'])) $incidents = $incidents->where('incidents.reported_by_user', $request['id']);


            $incidents = $incidents->orderBy('incidents.date_reported', 'desc')
                ->select('incidents.id', 'incident-types.incident_name', 'incidents.message', 'incidents.time_reported', 'incidents.landmark', 'incidents.location', 'incidents.status')
                ->get();

            foreach ($incidents as $incident) {
                $cleaned = [
                    'id' => $incident['id'],
                    'incident' => $incident['incident_name'],
                    'message' => $incident['message'],
                    'landmark' => $incident['landmark'],
                    'location' => $incident['location'],
                    'status' => $incident['status'],
                    'time' => explode(' ', $incident['time_reported'])[1],
                    'month' => explode('-', explode(' ', $incident['time_reported'])[0])[1],
                    'date' => explode('-', explode(' ', $incident['time_reported'])[0])[2] . ", " . explode('-', explode(' ', $incident['time_reported'])[0])[0],
                ];

                array_push($data['data'], $cleaned);
            }
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function reportIncident(Request $request)
    {


        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $data = [];

        try {
            // Validate request
            // Retrieve user data
            $user = User::with('citizenCredentials')->find($request->id);
            $closestStationId = $this->getClosestStationId($request->latitude, $request->longitude);
            // Map user data to reporting person data
            $reportingPersonData = [
                'firstname' => $user->first_name,
                'lastname' => $user->last_name,
                'middlename' => $user->middle_name,
                'gender' => $user->gender,
                'mobile_phone' => $user->contact,
                'current_address_id' => $user->current_address,
                'other_address_id' => $user->other_address,
                'email' => $user->email,
                'fb_account' => $user->citizenCredentials->fb_name ?? null,
                'id_card_presented' => $user->citizenCredentials->valid_id ?? null
                // Add other mappings as necessary
            ];

            // Create new reporting person record
            $id = $this->dynamic->getId(ReportingPerson::class, $reportingPersonData);
            if ($id == -1) $id = $this->dynamic->addItem(ReportingPerson::class, $reportingPersonData);

            $trp = $currentDate->format('Y-m-d H:i:s');
            $drp = $currentDate->format('Y-m-d');
            $ti = $currentDate->format('Y-m-d H:i:s');
            $di = $currentDate->format('Y-m-d');

            $incid = Incidents::create([
                'time_reported' => $trp,
                'date_reported' => $drp,
                'time_of_incident' => $ti,
                'date_of_incident' => $di,
                'status' => 'report',
                'location' => $request['location'],
                'message' => $request['message'],
                'landmark' => $request['landmark'],
                'reported_by_user' => $request['id'],
                'latitude' => $request['latitude'],
                'longitude' => $request['longitude'],
                'village' => $request['address']['village'],
                'street' => $request['address']['street'],
                'city' => $request['address']['city'],
                'province' => $request['address']['province'],
                'report_type' => $request['report_type'],
                'station' => $closestStationId
            ]);

            $inc_id = $incid->id;
            $data['data'] = [$id, $inc_id];
            IncidentReportingPerson::create(['reporting_person' => $id, 'incident' => $inc_id]);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }
        return response()->json($data);
    }
    /**
     * Private function to get the closest police station ID based on latitude and longitude
     */
    private function getClosestStationId($latitude, $longitude)
    {
        $stations = PoliceStation::where('id', '!=', 100)->get();
        $closestStation = null;
        $minDistance = PHP_FLOAT_MAX;

        foreach ($stations as $station) {
            $distance = $this->calculateDistance($latitude, $longitude, $station->latitude, $station->longitude);
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $closestStation = $station;
            }
        }

        return $closestStation->id ?? null;
    }

    /**
     * Calculate the Haversine distance between two points in kilometers.
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Radius of the Earth in kilometers

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $latDifference = $lat2 - $lat1;
        $lonDifference = $lon2 - $lon1;

        $a = sin($latDifference / 2) * sin($latDifference / 2) +
            cos($lat1) * cos($lat2) * sin($lonDifference / 2) * sin($lonDifference / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // Distance in kilometers
    }
    /* View */

    public function viewBasic(Request $request)
    {
        /* $request['id'] = 6; */

        try {
            $incident = Incidents::join('incident-types', "incidents.incident_type", "=", 'incident-types.id')
                ->select([
                    'incident-types.incident_name',
                    'incidents.time_of_incident',
                    'incidents.date_of_incident',
                    'incidents.time_reported',
                    'incidents.date_reported',
                    'incidents.location',
                ]);
            $incident = $incident->find($request['id']);

            $data['data'] = $incident;

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function viewNarative(Request $request)
    {

        try {
            $incident = Incidents::join('incident-narative', "incidents.incident_narrative", "=", 'incident-narative.id')
                ->select([
                    'incident-narative.details',
                ]);

            $incident = $incident->find($request['id']);

            $data['data'] = $incident;
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function viewSuspects(Request $request)
    {

        $data = [];
        try {

            $data['data'] = $this->incidentFun->IncidentSuspects($request);
            $data['response'] = "Success";
        } catch (\Exception $e) {
            $data['response'] = "Error";
            $data["err"] = $e;
        }
        return response()->json($data);
    }

    public function viewWitness(Request $request)
    {
        $data = [];
        try {

            $data['data'] = $this->incidentFun->incidentWitness($request);
            $data['response'] = "Success";
        } catch (\Exception $e) {
            $data['response'] = "Error";
            $data["err"] = $e;
        }
        return response()->json($data);
    }


    public function viewVictims(Request $request)
    {
        $data = [];
        try {
            $data['data'] = $this->incidentFun->IncidentVictims($request);

            $data['response'] = "Success";
        } catch (\Exception $e) {
            $data['response'] = "Error";
            $data["err"] = $e;
        }
        return response()->json($data);
    }
    public function assignTo(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $data = [];
        try {
            $incident = Incidents::find($request->input('id'));
            if (!$incident) {
                throw new \Exception("No query results for model [App\\Models\\Incidents].");
            }

            $assignedUser = User::find($request->input('assigned_to'));
            if (!$assignedUser) {
                throw new \Exception("No query results for model [App\\Models\\User].");
            }

            $incident->update([
                'assigned_to' => $request->input('assigned_to'),
                'rej_message' => null
            ]);

            // Send email to the assigned user
            Mail::to($assignedUser->email)->send(new IncidentAssignedMail($assignedUser, $incident));

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e->getMessage();
        }
        return response()->json($data);
    }

    private function isIncidentArchive($id)
    {

        return Incidents::where('id', $id)
            ->whereNotNull('archived_at')
            ->whereNotNull('archived_by')
            ->count();
    }


    /* refactor */

    /* ADD */

    public function addIncident(Request $request)
    {


        try {
            $incident = $request['incident'];
            $incident['time_reported'] = $incident['date_reported'] . ' ' . $incident['time_reported'] . ':00';
            $incident['time_of_incident'] = $incident['date_of_incident'] . ' ' . $incident['time_of_incident'] . ':00';


            $victims = $this->doesItExists($request['victims'], 'victim') ? $this->addByKey($request['victims'], 'victim') : [];
            $suspects = $this->doesItExists($request['suspects'], 'suspect') ? $this->addByKey($request['suspects'], 'suspect') : [];
            $witnesses = $this->doesItExists($request['witness'], 'witness') ? $this->addByKey($request['witness'], 'witness') : [];

            $victimIDS = $this->dynamic->cleanInsertId($victims)['id'];
            $suspectIDS = $this->dynamic->cleanInsertId($suspects)['id'];
            $witnessIDS = $this->dynamic->cleanInsertId($witnesses)['id'];

            $victims = $this->dynamic->cleanInsertId($victims)['no_id'];
            $suspects =  $this->dynamic->cleanInsertId($suspects)['no_id'];
            $witnesses =  $this->dynamic->cleanInsertId($witnesses)['no_id'];

            $rawVictims = $this->dynamic->deepCleanInsertId($request['victims'], 'victim')['no_id'];
            $rawSuspects =  $this->dynamic->deepCleanInsertId($request['suspects'], 'suspect')['no_id'];
            $rawWitnesses =  $this->dynamic->deepCleanInsertId($request['witness'], 'witness')['no_id'];

            /* victims */
            $victimCurrent = count($victims) > 0 ? $this->addByKey($rawVictims, 'current_address') : [];
            $victimOther = count($victims) > 0 ? $this->addByKey($rawVictims, 'other_address') : [];
            $victims = $this->addAddress($victims, $victimCurrent, 'current_address_id');
            $victims = $this->addAddress($victims, $victimOther, 'other_address_id');
            /* Suspects */
            $suspectCurrent = count($suspects) > 0 ? $this->addByKey($rawSuspects, 'current_address') : [];
            $suspectOther = count($suspects) > 0 ? $this->addByKey($rawSuspects, 'other_address') : [];
            $suspectWork = count($suspects) > 0 ? $this->addByKey($rawSuspects, 'work_address') : [];
            $suspects = $this->addAddress($suspects, $suspectCurrent, 'current_address_id');
            $suspects = $this->addAddress($suspects, $suspectOther, 'other_address_id');
            $suspects = $this->addAddress($suspects, $suspectWork, 'work_address_id');
            /* witness */
            $witnessCurrent = count($witnesses) > 0 ? $this->addByKey($rawWitnesses, 'current_address') : [];
            $witnessOther = count($witnesses) > 0 ? $this->addByKey($rawWitnesses, 'other_address') : [];
            $witnesses = $this->addAddress($witnesses, $witnessCurrent, 'current_address_id');
            $witnesses = $this->addAddress($witnesses, $witnessOther, 'other_address_id');

            $victimIDS = count($victims) > 0 ? array_merge($victimIDS, $this->massAddItem(Victims::class, $victims)) : $victimIDS;
            $suspectIDS = count($suspects) > 0 ?  array_merge($suspectIDS, $this->massAddItem(Suspects::class, $suspects)) : $suspectIDS;
            $witnessIDS = count($witnesses) > 0 ?  array_merge($witnessIDS, $this->massAddItem(ReportingPerson::class, $witnesses)) : $witnessIDS;

            $narrativeID = $this->addItem(IncidentNarative::class, $request['incident_narrative']);

            if ($narrativeID != -1) $incident['incident_narrative'] = $narrativeID;
            $incidentID = Incidents::create($incident)->id;

            if ($incidentID != -1 && $incidentID != null) {
                foreach ($victimIDS as $id) $this->addByKeyValue(IncidentVictims::class, 'incident', 'victim', $incidentID, $id);
                foreach ($suspectIDS as $id) $this->addByKeyValue(IncidentSuspects::class, 'incident', 'suspect', $incidentID, $id);
                foreach ($witnessIDS as $id) $this->addByKeyValue(IncidentReportingPerson::class, 'incident', 'reporting_person', $incidentID, $id);
            }

            TrailLog::create(['user_id' => $request->input('id'), 'action' => 'added', 'item' => 'incident']);
            $data['data'] = [$incident, $incidentID];
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function editDisplayData(Request $request)
    {
        $data = [];

        try {
            $incident = Incidents::select(
                "IRF_Entry_no",
                "copy_for",
                "date_reported",
                "time_reported",
                "date_of_incident",
                "time_of_incident",
                "location",
                'incident_narrative',
                'status',
                'barangay'
            )->find($request['id'])->toArray();

            if ($incident['barangay'] == NULL) $incident['barangay'] = "";

            $incidentTypes = Incidents::join('incident-types as it', "incidents.incident_type", "=", 'it.id')
                ->select('it.incident_name')->find($request['id']);
            $incidentTypes = $incidentTypes ? $incidentTypes : ['incident_name' => NULL];
            $incidentNarrative = Incidents::join('incident-narative', "incidents.incident_narrative", "=", 'incident-narative.id')
                ->select([
                    'incident-narative.details',
                ])->find($request['id']);
            $incidentNarrative = $incidentNarrative ? $incidentNarrative : ['details' => NULL];

            $Suspects = $this->incidentFun->IncidentSuspects($request);
            $Victims = $this->incidentFun->IncidentVictims($request);
            $Witnesses = $this->incidentFun->incidentWitness($request);
            $incident['time_reported'] = explode(' ', $incident['time_reported'])[1];
            $incident['time_of_incident'] = explode(' ', $incident['time_of_incident'])[1];

            $data['data'] = [
                'incident' =>  $incident,
                'incident_types' => $incidentTypes,
                'incident_narrative' => $incidentNarrative,
                'suspects' => $Suspects,
                'victims' => $Victims,
                'witness' => $Witnesses
            ];

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['Err'] = $e;
        }
        return response()->json($data);
    }

    public function update(Request $request)
    {

        $incident = $request['incident'];
        $incident['time_reported'] = $incident['date_reported'] . ' ' . $incident['time_reported'];
        $incident['time_of_incident'] = $incident['date_of_incident'] . ' ' . $incident['time_of_incident'];

        try {
            $victims = $this->doesItExists($request['victims'], 'victim') ? $this->addByKey($request['victims'], 'victim') : [];
            $suspects = $this->doesItExists($request['suspects'], 'suspect') ? $this->addByKey($request['suspects'], 'suspect') : [];
            $witnesses = $this->doesItExists($request['witness'], 'witness') ? $this->addByKey($request['witness'], 'witness') : [];

            $victimIDS = $this->dynamic->cleanInsertId($victims)['id'];
            $suspectIDS = $this->dynamic->cleanInsertId($suspects)['id'];
            $witnessIDS = $this->dynamic->cleanInsertId($witnesses)['id'];

            $victims = $this->dynamic->cleanInsertId($victims)['no_id'];
            $suspects =  $this->dynamic->cleanInsertId($suspects)['no_id'];
            $witnesses =  $this->dynamic->cleanInsertId($witnesses)['no_id'];

            $rawVictims = $this->dynamic->deepCleanInsertId($request['victims'], 'victim')['no_id'];
            $rawSuspects =  $this->dynamic->deepCleanInsertId($request['suspects'], 'suspect')['no_id'];
            $rawWitnesses =  $this->dynamic->deepCleanInsertId($request['witness'], 'witness')['no_id'];

            /* victims */
            $victimCurrent = count($victims) > 0 ? $this->addByKey($rawVictims, 'current_address') : [];
            $victimOther = count($victims) > 0 ? $this->addByKey($rawVictims, 'other_address') : [];
            $victims = $this->addAddress($victims, $victimCurrent, 'current_address_id');
            $victims = $this->addAddress($victims, $victimOther, 'other_address_id');
            /* Suspects */
            $suspectCurrent = count($suspects) > 0 ? $this->addByKey($rawSuspects, 'current_address') : [];
            $suspectOther = count($suspects) > 0 ? $this->addByKey($rawSuspects, 'other_address') : [];
            $suspectWork = count($suspects) > 0 ? $this->addByKey($rawSuspects, 'work_address') : [];
            $suspects = $this->addAddress($suspects, $suspectCurrent, 'current_address_id');
            $suspects = $this->addAddress($suspects, $suspectOther, 'other_address_id');
            $suspects = $this->addAddress($suspects, $suspectWork, 'work_address_id');
            /* witness */
            $witnessCurrent = count($witnesses) > 0 ? $this->addByKey($rawWitnesses, 'current_address') : [];
            $witnessOther = count($witnesses) > 0 ? $this->addByKey($rawWitnesses, 'other_address') : [];
            $witnesses = $this->addAddress($witnesses, $witnessCurrent, 'current_address_id');
            $witnesses = $this->addAddress($witnesses, $witnessOther, 'other_address_id');

            $victimIDS = count($victims) > 0 ? array_merge($victimIDS, $this->massAddItem(Victims::class, $victims)) : $victimIDS;
            $suspectIDS = count($suspects) > 0 ?  array_merge($suspectIDS, $this->massAddItem(Suspects::class, $suspects)) : $suspectIDS;
            $witnessIDS = count($witnesses) > 0 ?  array_merge($witnessIDS, $this->massAddItem(ReportingPerson::class, $witnesses)) : $witnessIDS;

            if ($incident['incident_narrative']) IncidentNarative::find($incident['incident_narrative'])->update($request['incident_narrative']);
            else {
                $incident['incident_narrative'] = $this->dynamic->addItem(IncidentNarative::class, $request->input('incident_narrative'));
            }


            $incidentID = $incident['id'];

            IncidentVictims::where('incident', $incidentID)->delete();
            IncidentSuspects::where('incident', $incidentID)->delete();
            IncidentReportingPerson::where('incident', $incidentID)->delete();

            if ($incidentID != -1 && $incidentID != null) {
                foreach ($victimIDS as $id) $this->addByKeyValue(IncidentVictims::class, 'incident', 'victim', $incidentID, $id);
                foreach ($suspectIDS as $id) $this->addByKeyValue(IncidentSuspects::class, 'incident', 'suspect', $incidentID, $id);
                foreach ($witnessIDS as $id) $this->addByKeyValue(IncidentReportingPerson::class, 'incident', 'reporting_person', $incidentID, $id);
            }

            Incidents::find($incidentID)->update($incident);

            TrailLog::create(['user_id' => $request->input('id'), 'action' => 'edited', 'item' => 'incident']);
            $data['data'] = [$incidentID, $victimIDS, $suspectIDS, $witnessIDS];
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    /* use for pure foreign key */
    private function addByKeyValue($model, $k1, $k2, $v1, $v2)
    {
        $model::create([$k1 => $v1, $k2 => $v2]);
    }

    /* use to add address id in every element of a lsit and using a specific key to hold the value in each item */
    private function addAddress($items, $address, $key)
    {
        $result = $items;
        for ($i = 0; $i < count($result); $i++) {
            $id = null;
            if (!$this->nulled($address[$i])) {
                $tempID = $this->getId(Addresses::class, $address[$i]);
                $id = $tempID == -1 ? $this->addItem(Addresses::class, $address[$i]) : $tempID;
            }
            $result[$i][$key] = $id;
        }
        return $result;
    }

    private function nulled($param)
    {
        foreach ($param as $key => $value) if ($value != null) return false;

        return true;
    }
    /* use to check if it really exists */
    private function doesItExists($param, $key)
    {
        try {
            $param[0][$key];
            return true;
        } catch (\Exception) {
            return false;
        }
    }
    /* add by key, use to extract array from array by its key */
    private function addByKey($param, $key)
    {
        $transferred = [];
        foreach ($param as $item) array_push($transferred, $item[$key]);
        return $transferred;
    }
    /* mass add item dynamically but only works on adding persons */
    private function massAddItem($model, $items)
    {
        $ids = [];
        foreach ($items as $item) {
            $itemId = $this->getId($model, $item);
            if ($itemId == -1) $itemId = $this->addItem($model, $item);

            if (($itemId != null && $itemId != -1) && !in_array($itemId, $ids)) array_push($ids, $itemId);
        }
        return $ids;
    }
    /* add item dynamic */
    private function addItem($model, $param)
    {
        try {
            $model::create($param);
            $id = $this->getId($model, $param);

            return $id;
        } catch (\Exception) {
            return null;
        }
    }
    /* get id dynamically */
    private function getId($model, $param)
    {
        try {
            $query = $model::query();

            foreach ($param as $key => $value) {
                $query->where($key, $value);
            }

            $result = $query->select('id')->first();

            return $result ? $result->id : -1;
        } catch (\Exception $e) {
            return -1;
        }
    }
}
