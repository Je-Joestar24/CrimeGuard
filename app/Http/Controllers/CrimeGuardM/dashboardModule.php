<?php

namespace App\Http\Controllers\CrimeGuardM;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CrimeGuardM\Dynamic\DynamicFunctions;
use App\Models\Addresses;
use App\Models\Incidents;
use App\Models\IncidentSuspects;
use App\Models\IncidentVictims;
use App\Models\OfficerCredential;
use App\Models\RankChangedReports;
use App\Models\Suspects;
use App\Models\TransferReports;
use App\Models\User;
use App\Models\Victims;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardModule extends Controller
{

    protected $dynamic;

    public function __construct(DynamicFunctions $dynamic)
    {
        $this->dynamic = $dynamic;
    }
    //
    public function generateLine(Request $request)
    {

        date_default_timezone_set('Asia/Manila');


        $defautlD = Carbon::now();
        $defaultDate = $defautlD->subDays((29))->toDateString();
        $data = [];

        /* For Line Graph data */
        $dates = [];

        $station = $request->has('id') ? $this->dynamic->getUserStation($request->input('id')) : ['response' => false];
        $station = $station['response'] ? $station['station'] : 100;

        if ($request->has('date_start')) {
            $start = $request->input('date_start') != "" ? $request->input('date_start') : $defaultDate;
        } else {
            $start = $defaultDate;
        }

        if ($request->has('date_end')) {
            $end = $request->input('date_end') != "" ? $request->input('date_end') : Carbon::now()->toDateString();
        } else {
            $end = Carbon::now()->toDateString();
        }



        $startC = Carbon::parse($start);
        $endC = Carbon::parse($end);
        $data['date'] = [$request->input('date_start'), $request->input('date_end')];
        $difference = $endC->diffInDays($startC);


        for ($i = $difference; $i >= 0; $i--) {
            $date = $endC->copy()->subDays($i);
            $temporary['date'] = $date->toDateString();
            $temporary['count'] = Incidents::where('date_reported', '=', $date->format('Y-m-d'));
            if ($station != 100) {
                $temporary['count'] = $temporary['count']->where('incidents.station', $station);
            }
            $temporary['count'] = $temporary['count']->whereNull('incidents.archived_at')
                ->whereNull('incidents.archived_by');

            if ($request->has('barangay') && !empty($request->input('barangay'))) {
                $temporary['count'] = $temporary['count']->where('barangay', '=', $request->input('barangay'));
            }

            if ($request->has('incident_type') && $request->input('incident_type') != -1) {
                $temporary['count'] = $temporary['count']->where('incidents.incident_type', $request->input('incident_type'));
            }
            if ($request->has('status') && $request->input('status') != '') {
                $temporary['count'] = $temporary['count']
                    ->where('status', '=', $request->input('status'))
                    ->count();
            } else {
                $temporary['count'] = $temporary['count']->where('status', '!=', 'respond')
                    ->where('status', '!=', 'report')->count();
            }

            array_push($dates, $temporary);
        }

        $data['data']['linegraph'] = $dates;
        $data['response'] = 'Success';
        $data['station'] = $station;

        return response()->json($data);
    }



    /* victims */
    public function victimsPieGender(Request $request)
    {
        $data = [];
        try {
            // Get user station
            $station = $request->has('id') ? $this->dynamic->getUserStation($request->input('id')) : ['response' => false];
            $station = $station['response'] ? $station['station'] : 100;

            // Male count with station filter through incident_victims and incidents
            $male = Victims::query()
                ->join('incident-victims', 'victims.id', '=', 'incident-victims.victim')
                ->join('incidents', 'incident-victims.incident', '=', 'incidents.id')
                ->where('victims.gender', 'male')
                ->when($station != 100, fn($q) => $q->where('incidents.station', $station))
                ->count();

            // Female count with station filter through incident_victims and incidents
            $female = Victims::query()
                ->join('incident-victims', 'victims.id', '=', 'incident-victims.victim')
                ->join('incidents', 'incident-victims.incident', '=', 'incidents.id')
                ->where('victims.gender', 'female')
                ->when($station != 100, fn($q) => $q->where('incidents.station', $station))
                ->count();

            $data['data'] = [
                'male' => $male,
                'female' => $female
            ];
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function victimsAge(Request $request)
    {
        $data = [];
        try {
            // Get user station
            $station = $request->has('id') ? $this->dynamic->getUserStation($request->input('id')) : ['response' => false];
            $station = $station['response'] ? $station['station'] : 100;

            // Children count (age <= 19) with station filter through incident_victims and incidents
            $children = Victims::query()
                ->join('incident-victims', 'victims.id', '=', 'incident-victims.victim')
                ->join('incidents', 'incident-victims.incident', '=', 'incidents.id')
                ->where('victims.age', '<=', '19')
                ->when($station != 100, fn($q) => $q->where('incidents.station', $station))
                ->count();

            // Adult count (20 <= age <= 59) with station filter through incident_victims and incidents
            $adult = Victims::query()
                ->join('incident-victims', 'victims.id', '=', 'incident-victims.victim')
                ->join('incidents', 'incident-victims.incident', '=', 'incidents.id')
                ->whereBetween('victims.age', [20, 59])
                ->when($station != 100, fn($q) => $q->where('incidents.station', $station))
                ->count();

            // Old count (age >= 60) with station filter through incident_victims and incidents
            $old = Victims::query()
                ->join('incident-victims', 'victims.id', '=', 'incident-victims.victim')
                ->join('incidents', 'incident-victims.incident', '=', 'incidents.id')
                ->where('victims.age', '>=', '60')
                ->when($station != 100, fn($q) => $q->where('incidents.station', $station))
                ->count();


            $data['data'] = [
                'children' => $children,
                'adult' => $adult,
                'old' => $old
            ];
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }
    /* victims */
    public function suspectsPieGender(Request $request)
    {
        $data = [];
        try {
            // Get user station
            $station = $request->has('id') ? $this->dynamic->getUserStation($request->input('id')) : ['response' => false];
            $station = $station['response'] ? $station['station'] : 100;

            // Male count with station filter through incident_suspects and incidents
            $male = Suspects::query()
                ->join('incident-suspects', 'suspects.id', '=', 'incident-suspects.suspect')
                ->join('incidents', 'incident-suspects.incident', '=', 'incidents.id')
                ->where('suspects.gender', 'male')
                ->when($station != 100, fn($q) => $q->where('incidents.station', $station))
                ->count();

            // Female count with station filter through incident_suspects and incidents
            $female = Suspects::query()
                ->join('incident-suspects', 'suspects.id', '=', 'incident-suspects.suspect')
                ->join('incidents', 'incident-suspects.incident', '=', 'incidents.id')
                ->where('suspects.gender', 'female')
                ->when($station != 100, fn($q) => $q->where('incidents.station', $station))
                ->count();

            $data['data'] = [
                'male' => $male,
                'female' => $female
            ];
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function suspectsAge(Request $request)
    {
        $data = [];
        try {
            // Get user station
            $station = $request->has('id') ? $this->dynamic->getUserStation($request->input('id')) : ['response' => false];
            $station = $station['response'] ? $station['station'] : 100;

            // Children count (age <= 19) with station filter through incident_suspects and incidents
            $children = Suspects::query()
                ->join('incident-suspects', 'suspects.id', '=', 'incident-suspects.suspect')
                ->join('incidents', 'incident-suspects.incident', '=', 'incidents.id')
                ->where('suspects.age', '<=', '19')
                ->when($station != 100, fn($q) => $q->where('incidents.station', $station))
                ->count();

            // Adult count (20 <= age <= 59) with station filter through incident_suspects and incidents
            $adult = Suspects::query()
                ->join('incident-suspects', 'suspects.id', '=', 'incident-suspects.suspect')
                ->join('incidents', 'incident-suspects.incident', '=', 'incidents.id')
                ->whereBetween('suspects.age', [20, 59])
                ->when($station != 100, fn($q) => $q->where('incidents.station', $station))
                ->count();

            // Old count (age >= 60) with station filter through incident_suspects and incidents
            $old = Suspects::query()
                ->join('incident-suspects', 'suspects.id', '=', 'incident-suspects.suspect')
                ->join('incidents', 'incident-suspects.incident', '=', 'incidents.id')
                ->where('suspects.age', '>=', '60')
                ->when($station != 100, fn($q) => $q->where('incidents.station', $station))
                ->count();




            $data['data'] = [
                'children' => $children,
                'adult' => $adult,
                'old' => $old
            ];
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    /* filter Area */
    public function victimsAgeArea(Request $request)
    {
        $data = [];
        try {

            $station = $request->has('id') ? $this->dynamic->getUserStation($request->input('id')) : ['response' => false];
            $station = $station['response'] ? $station['station'] : 100;

            $initial = IncidentVictims::join('incidents', 'incident-victims.incident', '=', 'incidents.id')
                ->join('victims', 'incident-victims.victim', '=', 'victims.id')
                ->select('victims.id', 'victims.firstname', 'victims.lastname', 'victims.mobile_phone')
                ->whereNull('victims.archived_at')
                ->whereNull('victims.deleted_by')
                ->whereNull('incidents.archived_at')
                ->whereNull('incidents.archived_by');
            if ($station != 100) {
                $initial = $initial->where('incidents.station', $station);
            }
            if ($request->has('barangay')) {
                $initial = $initial->where('incidents.barangay', $request->input('barangay'));
            }
            if ($request->has('village')) {
                $initial = $initial->where('incidents.village', $request->input('village'));
            }
            if ($request->has('street')) {
                $initial = $initial->where('incidents.street', $request->input('street'));
            }
            if ($request->has('city')) {
                $initial = $initial->where('incidents.city', $request->input('city'));
            }

            $childrenQuery = clone $initial;
            $adultQuery = clone $initial;
            $oldQuery = clone $initial;

            $children = $childrenQuery->where('victims.age', '<=', 20)->get();
            $adult = $adultQuery->whereBetween('victims.age', [21, 59])->get();
            $old = $oldQuery->where('victims.age', '>=', 60)->get();

            $data['data'] = [
                'children' => $children,
                'adult' => $adult,
                'old' => $old
            ];

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    /* incidents */
    public function topBarangays(Request $request)
    {
        $data = [];
        try {


            $barangay = Addresses::select('barangay')->where('barangay', '!=', NULL)->distinct()->orderBy('barangay', 'ASC')->get()->toArray();

            for ($i = 0; $i < count($barangay); $i++) {
                $barangay[$i]['count'] = Incidents::where('barangay', $barangay[$i]['barangay']);
                if ($request->has('date_start') && $request->input('date_start') != '') $barangay[$i]['count'] = $barangay[$i]['count']->where('date_of_incident', '>=', $request->input('date_start'));
                if ($request->has('date_end') && $request->input('date_end') != '') $barangay[$i]['count'] = $barangay[$i]['count']->where('date_of_incident', '<=', $request->input('date_end'));

                if ($request->has('incident_type') && $request->input('incident_type') != -1) {
                    $barangay[$i]['count'] = $barangay[$i]['count']->where('incidents.incident_type', $request->input('incident_type'));
                }
                if ($request->has('status') && $request->input('status') != '') {
                    $barangay[$i]['count'] = $barangay[$i]['count']
                        ->where('status', '=', $request->input('status'));
                } else {
                    $barangay[$i]['count'] = $barangay[$i]['count']->where('status', '!=', 'respond')
                        ->where('status', '!=', 'report');
                }
                $barangay[$i]['count'] = $barangay[$i]['count']->count();
            }

            $newB = [];
            for ($i = 0; $i < 4/* sort limit */; $i++) {
                $index = $i;
                for ($j = $i; $j < count($barangay); $j++)
                    if ($barangay[$index]['count'] < $barangay[$j]['count'])
                        $index = $j;

                $temp = $barangay[$index];
                $barangay[$index] = $barangay[$i];
                $barangay[$i] = $temp;
                array_push($newB, $barangay[$i]);
            }
            $data['data'] = $newB;
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function findBarangay(Request $request)
    {


        $data = [];
        try {
            $barangay = Addresses::select('barangay')->where('barangay', '!=', NULL)->distinct()->where('barangay', $request->input('barangay'))->get()->toArray();

            if (count($barangay) >= 1) {
                $data['response'] = 'Success';
            } else {
                $data['response'] = 'Error';
            }
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function displayCount(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        // Define date ranges
        $currentDate = new DateTime();
        $firstDayOfMonth = new DateTime('first day of this month');
        $lastDayOfMonth = new DateTime('last day of this month');
        $lastMonthStart = (clone $firstDayOfMonth)->modify('-1 month');
        $lastMonthEnd = (clone $lastDayOfMonth)->modify('-1 month');

        $data = ['data' => ['upper' => []]];

        // Define statuses with their filter types and values
        $statuses = [
            'incidentCount' => ['!=', ['report', 'reject', 'respond']],
            'clearedCount' => ['=', 'clear'],
            'solvedCount' => ['=', 'solve'],
            'underICount' => ['in', ['pending', 'under investigation']],
            'rejectCount' => ['=', 'reject'],
            'reportCount' => ['=', 'report'],
            'respondCount' => ['=', 'respond']
        ];

        // Get user station
        $station = $request->has('id') ? $this->dynamic->getUserStation($request->input('id')) : ['response' => false];
        $station = $station['response'] ? $station['station'] : 100;

        foreach ($statuses as $key => $status) {
            // Build query with station filter applied at each step
            $query = Incidents::query();
            if ($station != 100) {
                $query->where('incidents.station', $station);
            }

            // Apply status condition
            if ($status[0] == '!=') {
                foreach ($status[1] as $s) {
                    $query->where('status', '!=', $s);
                }
            } elseif ($status[0] == 'in') {
                $query->whereIn('status', $status[1]);
            } else {
                $query->where('status', $status[1]);
            }

            // Total count with station filter
            $totalCount = $query->count();

            // Current month count with station and date filter
            $currentMonthCount = Incidents::query()
                ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
                ->when($station != 100, fn($q) => $q->where('incidents.station', $station))
                ->where(function ($q) use ($status) {
                    if ($status[0] == '!=') {
                        foreach ($status[1] as $s) {
                            $q->where('status', '!=', $s);
                        }
                    } elseif ($status[0] == 'in') {
                        $q->whereIn('status', $status[1]);
                    } else {
                        $q->where('status', $status[1]);
                    }
                })
                ->count();

            // Last month count with station and date filter
            $lastMonthCount = Incidents::query()
                ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                ->when($station != 100, fn($q) => $q->where('incidents.station', $station))
                ->where(function ($q) use ($status) {
                    if ($status[0] == '!=') {
                        foreach ($status[1] as $s) {
                            $q->where('status', '!=', $s);
                        }
                    } elseif ($status[0] == 'in') {
                        $q->whereIn('status', $status[1]);
                    } else {
                        $q->where('status', $status[1]);
                    }
                })
                ->count();

            // Calculate growth
            $growth = $lastMonthCount > 0
                ? (($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100
                : ($currentMonthCount > 0 ? 100 : 0);

            // Store the data
            $data['data']['upper'][$key] = [
                'totalCount' => $totalCount,
                'currentMonthCount' => $currentMonthCount,
                'growth' => round($growth, 2)
            ];
        }

        // Calculate total incidents with station filter
        $incidentQuery = Incidents::query();
        if ($station != 100) {
            $incidentQuery->where('station', $station);
        }
        $totalIncidents = $incidentQuery->count();

        $currentMonthTotalIncidents = Incidents::query()
            ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->when($station != 100, fn($q) => $q->where('station', $station))
            ->count();

        $lastMonthTotalIncidents = Incidents::query()
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->when($station != 100, fn($q) => $q->where('station', $station))
            ->count();

        $totalGrowth = $lastMonthTotalIncidents > 0
            ? (($currentMonthTotalIncidents - $lastMonthTotalIncidents) / $lastMonthTotalIncidents) * 100
            : ($currentMonthTotalIncidents > 0 ? 100 : 0);

        // Store total incidents data
        $data['data']['upper']['totalIncidents'] = [
            'totalCount' => $totalIncidents,
            'currentMonthCount' => $currentMonthTotalIncidents,
            'growth' => round($totalGrowth, 2)
        ];
        $data['response'] = 'Success';

        return response()->json($data);
    }


    public function displayReports(Request $request)
    {


        date_default_timezone_set('Asia/Manila');

        $station = $request->has('id') ? $this->dynamic->getUserStation($request->input('id')) : ['response' => false];
        $station = $station['response'] ? $station['station'] : 100;
        $currentDate = new DateTime();
        $data = [];
        $inc = Incidents::whereDate('date_reported',  $currentDate->format('Y-m-d'))
            ->select('id', 'time_reported', 'status', 'message', 'location', 'landmark', 'latitude', 'longitude');
        if ($station != 100) $inc = $inc->where('incidents.station', $station);
        $inc = $inc->get();

        $send = [];

        foreach ($inc->toArray() as $val) {
            $temp = [
                'id' => $val['id'],
                'time_reported' => $val['time_reported'],
                'status' => $val['status'],
                'message' => $val['message'],
                'location' => $val['location'],
                'landmark' => $val['landmark'],
                'pos' => [
                    'lat' => $val['latitude'],
                    'lng' => $val['longitude']
                ]
            ];
            array_push($send, $temp);
        }
        $data['data']['reportedIncidents'] = $send;
        $data['response'] = 'Success';

        return response()->json($data);
    }

    public function emergencyReports(Request $request)
    {


        date_default_timezone_set('Asia/Manila');
    
        $station = $request->has('id') ? $this->dynamic->getUserStation($request->input('id')) : ['response' => false];
        $station = $station['response'] ? $station['station'] : 100;

        

        $currentDate = new DateTime();
        $data = [];

        $init = Incidents::where('status', '=', 'report');

        if ($station != 100) $init = $init->where('incidents.station', $station);

        if ($request->has('ind')  || !$request->has('id')) $init = $init->where('report_type', 1);
        else $init = $init->where('assigned_to', $request->input('id'));

        $init = $init->whereDate('date_reported',  $currentDate->format('Y-m-d'))
            ->select('id', 'time_reported', 'status', 'message', 'location', 'landmark')
            ->get();

        $data['data']['reportedIncidents'] = $init;
        $data['response'] = 'Success';

        return response()->json($data);
    }

    public function emergencyReports0(Request $request)
    {
        // Set the headers for SSE
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        // Prevent script timeout, so the connection stays open
        set_time_limit(0);

        date_default_timezone_set('Asia/Manila');
        $currentDate = new DateTime();

        while (true) {
            // Fetch the incidents based on query parameters
            $init = Incidents::where('status', '=', 'report');

            if (!$request->has('id')) {
                $init = $init->where('report_type', 1);
            } else {
                $init = $init->where('assigned_to', $request->input('id'));
            }

            $init = $init->whereDate('date_reported', $currentDate->format('Y-m-d'))
                ->select('id', 'time_reported', 'status', 'message', 'location', 'landmark')
                ->get();

            if ($init->isNotEmpty()) {
                $data['data']['reportedIncidents'] = $init;
                $data['response'] = 'Success';

                // Send data in the correct SSE format
                echo "data: " . json_encode($data) . "\n\n";

                // Flush the buffer to send the response to the client immediately
                ob_flush();
                flush();
            }

            // Sleep for 5 seconds before checking again
            sleep(5);
        }
    }


    public function heatMap(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();

        $data['data'] = [];
// Get user station
$station = $request->has('id') ? $this->dynamic->getUserStation($request->input('id')) : ['response' => false];
$station = $station['response'] ? $station['station'] : 100;


        try {
            $reports = Incidents::leftJoin('users', 'incidents.reported_by_user', '=', 'users.id')
                ->leftJoin('incident-types', 'incidents.incident_type', '=', 'incident-types.id')
                ->leftJoin('incident-sub-types', 'incident-types.sub_type_id', '=', 'incident-sub-types.id')
                ->select(
                    'incidents.id',
                    'incidents.message',
                    'incidents.landmark',
                    'incidents.location',
                    'incidents.time_reported',
                    'users.user_name',
                    'users.email',
                    'users.first_name',
                    'users.last_name',
                    'users.contact',
                    'incidents.longitude',
                    'incidents.latitude',
                    'incidents.report_type',
                    'incident-types.incident_name',
                    'incident-sub-types.sub_type',
                    'incidents.status'
                )->where('incidents.incident_type', '!=', NULL)
                ->when($station != 100, fn($q) => $q->where('incidents.station', $station));
            if ($request->has('filter')) {
                $filter = $request->input('filter');
                if ($filter['date_start'] != '') {
                    $reports = $reports->whereDate('incidents.date_reported', '>=', $filter['date_start']);
                }
                if ($filter['date_end'] != '') {
                    $reports = $reports->whereDate('incidents.date_reported', '<=', $filter['date_end']);
                }
                if ($filter['barangay'] != '') {
                    $reports = $reports->where('incidents.barangay', '=', $filter['barangay']);
                }
                if ($filter['incident'] != '') {
                    $reports = $reports->where('incident-types.incident_name', 'like', '%' . $filter['incident'] . '%');
                }
            };

            if ($request->has('searchQuery') && $request->input('searchQuery') != '') {
                $reports = $reports->where('incidents.message', 'like', '%' . $request->input('searchQuery') . '%');
                $reports = $reports->orWhere('incidents.location', 'like', '%' . $request->input('searchQuery') . '%');
                $reports = $reports->orWhere('incidents.landmark', 'like', '%' . $request->input('searchQuery') . '%');
                $reports = $reports->orWhere('users.user_name', 'like', '%' . $request->input('searchQuery') . '%');
                $reports = $reports->orWhere('users.first_name', 'like', '%' . $request->input('searchQuery') . '%');
                $reports = $reports->orWhere('users.last_name', 'like', '%' . $request->input('searchQuery') . '%');
                $reports = $reports->orWhere('incident-types.incident_name', 'like', '%' . $request->input('searchQuery') . '%');
                $reports = $reports->orWhere('incident-sub-types.sub_type', 'like', '%' . $request->input('searchQuery') . '%');
                $reports = $reports->orWhere('users.contact', 'like', '%' . $request->input('searchQuery') . '%');
            }

            $reports = $reports->where('incidents.status', '!=', 'report')
                ->where('incidents.latitude', '>', 0)
                ->where('incidents.longitude', '>', 0)
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
                    'status' => $report['status'],
                    'pos' => [
                        'lat' => $report['latitude'],
                        'lng' => $report['longitude']
                    ],
                    'time' => explode(' ', $report['time_reported'])[1],
                    'month' => explode('-', explode(' ', $report['time_reported'])[0])[1],
                    'date' => explode('-', explode(' ', $report['time_reported'])[0])[2] . ", " . explode('-', explode(' ', $report['time_reported'])[0])[0],
                    'report_type' => $report['report_type'],
                    'incident_type' => $report['sub_type'] != NULL ? ($report['incident_name'] . "( " . $report['sub_type'] . " )") : $report['incident_name'],
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

    public function citizenHeatMap(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();

        $data['data'] = [];


        try {
            $reports = Incidents::leftJoin('users', 'incidents.reported_by_user', '=', 'users.id')
                ->join('incident-types', 'incidents.incident_type', '=', 'incident-types.id')
                ->select(
                    'incidents.id',
                    'incidents.message',
                    'incidents.landmark',
                    'incidents.location',
                    'incidents.time_reported',
                    'users.user_name',
                    'users.email',
                    'users.first_name',
                    'users.last_name',
                    'users.contact',
                    'incidents.longitude',
                    'incidents.latitude',
                    'incidents.report_type',
                    //DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city) AS cur_address'),
                    'incident-types.incident_name'
                )
                ->where('incidents.status', '!=', 'report')
                ->where('incidents.status', '!=', 'reject')
                ->where('incidents.incident_type', '!=', NULL)
                ->where('incidents.latitude', '>', 0)
                ->where('incidents.longitude', '>', 0)
                ->get();

            foreach ($reports as $report) {
                $suspect = IncidentSuspects::join('suspects', 'incident-suspects.suspect', '=', 'suspects.id')
                    ->where('incident-suspects.incident', $report['id'])
                    ->whereNull('suspects.archived_at')
                    ->whereNull('suspects.deleted_by')->count();

                $victims = IncidentVictims::join('victims', 'incident-victims.victim', '=', 'victims.id')
                    ->whereNull('victims.archived_at')
                    ->whereNull('victims.deleted_by')
                    ->where('incident-victims.incident', $report['id'])->count();

                $cleaned = [
                    'id' => $report['id'],
                    'user_name' => $report['user_name'],
                    'name' => $report['incident_name'],
                    'email' => $report['email'],
                    'message' => $report['message'],
                    'location' => $report['location'],
                    'contact' => $report['contact'],
                    'pos' => [
                        'lat' => $report['latitude'],
                        'lng' => $report['longitude']
                    ],
                    'suspects' => $suspect,
                    'victims' => $victims,
                    'time' => explode(' ', $report['time_reported'])[1],
                    'month' => explode('-', explode(' ', $report['time_reported'])[0])[1],
                    'date' => explode('-', explode(' ', $report['time_reported'])[0])[2] . ", " . explode('-', explode(' ', $report['time_reported'])[0])[0],
                    'report_type' => $report['report_type']
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


    public function rankChangeReports(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $data = [];

        $defaultDate = '0000-00-00 00:00:00';

        $data = [];

        try {
            /* table data */
            $query = RankChangedReports::leftJoin('users', 'rank-changed-reports.officer', '=', 'users.id')->select([
                'users.id',
                'users.last_name',
                'users.first_name',
                'users.user_name',
                'users.email',
                'rank-changed-reports.change_rank',
                'rank-changed-reports.date_changed',
            ])->orderBy(
                'rank-changed-reports.date_changed',
                'desc'
            );
            $data['table']['headers'] = [
                'ID',
                'LASTNAME',
                'FIRSTNAME',
                'USERNAME',
                'EMAIL',
                'RANK CHANGES',
                'DATE'
            ];
            if ($request->has('date_start') && $request->input('date_start')) {
                $query = $query->where('rank-changed-reports.created_at', '>=', $request->input('date_start') . (" " . ($request->input('time_start') ? $request->input('time_start') . ":00" : explode(' ', $defaultDate)[1])));
            }

            if ($request->has('date_end') && $request->input('date_end')) {
                $query = $query->where('rank-changed-reports.created_at', '<=', $request->input('date_end') . (" " . ($request->input('time_end') ? $request->input('time_end') . ":00" : explode(' ', $defaultDate)[1])));
            }
            $stationInfo = OfficerCredential::join('police-station', 'officer-credentials.station', 'police-station.id')
                ->select('police-station.name', 'police-station.location')
                ->where('officer-credentials.user_id', $request->id)
                ->first();

            $data['station'] = $stationInfo;
            /* Execute query and fetch data */
            $data['table']['data'] = $query->get();

            $tableBody = $query->orderBy('rank-changed-reports.created_at', 'desc')
                ->get();
            for ($i = 0; $i < count($tableBody); $i++) {
                $tmp = explode(' ', $tableBody[$i]['change_rank']);
                $tableBody[$i]['change_rank'] = 'from ' . $tmp[0] . ' to ' . $tmp[1];
            }
            $data['table']['data'] = $tableBody;


            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }


    public function areaTransferReports(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $data = [];

        $defaultDate = '0000-00-00 00:00:00';

        $data = [];

        try {
            /* table data */
            $query = TransferReports::leftJoin('users', 'transfer-reports.officer', '=', 'users.id')->select([
                'users.id',
                'users.last_name',
                'users.first_name',
                'users.user_name',
                'users.email',
                'transfer-reports.transfer',
                'transfer-reports.date_transferred',
            ])->orderBy(
                'transfer-reports.date_transferred',
                'desc'
            );
            $data['table']['headers'] = [
                'ID',
                'LASTNAME',
                'FIRSTNAME',
                'USERNAME',
                'EMAIL',
                'STATION CHANGES',
                'DATE'
            ];
            if ($request->has('date_start') && $request->input('date_start')) {
                $query = $query->where('transfer-reports.created_at', '>=', $request->input('date_start') . (" " . ($request->input('time_start') ? $request->input('time_start') . ":00" : explode(' ', $defaultDate)[1])));
            }

            if ($request->has('date_end') && $request->input('date_end')) {
                $query = $query->where('transfer-reports.created_at', '<=', $request->input('date_end') . (" " . ($request->input('time_end') ? $request->input('time_end') . ":00" : explode(' ', $defaultDate)[1])));
            }
            $stationInfo = OfficerCredential::join('police-station', 'officer-credentials.station', 'police-station.id')
                ->select('police-station.name', 'police-station.location')
                ->where('officer-credentials.user_id', $request->id)
                ->first();

            $data['station'] = $stationInfo;
            /* Execute query and fetch data */
            $data['table']['data'] = $query->get();

            $tableBody = $query->orderBy('transfer-reports.created_at', 'desc')
                ->get();
            for ($i = 0; $i < count($tableBody); $i++) {
                $tmp = explode(' ', $tableBody[$i]['transfer']);
                $tableBody[$i]['transfer'] = 'from PP' . $tmp[0] . ' to PP' . $tmp[1];
            }
            $data['table']['data'] = $tableBody;


            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }


    public function generateOfficerAccounts(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $data = [];

        /* Table headers */
        $data['table']['headers'] = [
            'last name',
            'firstname',
            'user name',
            'email address',
            'phone no.'
        ];

        $defaultDate = '0000-00-00 00:00:00';
        try {


            $stationInfo = OfficerCredential::join('police-station', 'officer-credentials.station', 'police-station.id')
                ->select('police-station.name', 'police-station.location', 'officer-credentials.station')
                ->where('officer-credentials.user_id', $request->id)
                ->first();

            /* table data */
            $query = User::join('officer-credentials', 'officer-credentials.user_id', 'users.id')->select([
                'users.first_name',
                'users.last_name',
                'users.user_name',
                'users.email',
                'users.contact',
            ])
                ->where('users.user_level', '=', '2')
                ->where('officer-credentials.station', '=', $stationInfo['station']);

            if ($request->has('date_start') && $request->input('date_start')) {
                $query = $query->where('users.created_at', '>=', $request->input('date_start') . (" " . ($request->input('time_start') ? $request->input('time_start') . ":00" : explode(' ', $defaultDate)[1])));
            }

            if ($request->has('date_end') && $request->input('date_end')) {
                $query = $query->where('users.created_at', '<=', $request->input('date_end') . (" " . ($request->input('time_end') ? $request->input('time_end') . ":00" : explode(' ', $defaultDate)[1])));
            }
            $stationInfo2 = OfficerCredential::join('police-station', 'officer-credentials.station', 'police-station.id')
                ->select('police-station.name', 'police-station.location')
                ->where('officer-credentials.user_id', $request->id)
                ->first();

            $data['station'] = $stationInfo2;
            /* Execute query and fetch data */
            $data['table']['data'] = $query->get()->toArray();
            $data['response'] = 'Success';
            $data['table']['type'] = 1;
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }
}
