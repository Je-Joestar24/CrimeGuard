<?php

namespace App\Http\Controllers\CrimeGuardM;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CrimeGuardM\Dynamic\DynamicFunctions;
use App\Models\Incidents;
use App\Models\UserTrack;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackUser extends Controller
{
    protected $dynamic;

    public function __construct(DynamicFunctions $dynamic)
    {
        $this->dynamic = $dynamic;
    }

    //
    public function add(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $data = [];

        $track = $request->has('data') ? $request->input('data') : NULL;
        try {

            UserTrack::create($track);

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = "Error";
            $data['err'] = $e;
        }
        return response()->json($data);
    }


    public function usermarker(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();

        $data['data'] = [];


        try {
            $reports = UserTrack::leftJoin('users', 'user_track.user', '=', 'users.id')
                ->select(
                    'users.id',
                    'user_track.created_at',
                    'users.profile',
                    'users.user_name',
                    'users.email',
                    'users.first_name',
                    'users.last_name',
                    'users.contact',
                    'user_track.longitude',
                    'user_track.latitude',
                    'users.user_level'
                )
                ->where('user_track.latitude', '!=', 0.0)
                ->where('user_track.longitude', '!=', 0.0)
                ->whereDate('user_track.created_at', $currentDate->format('Y-m-d'))
                ->orderBy('user_track.created_at', 'desc')
                ->orderBy('user_track.user', 'desc')  // Order by created_at from oldest to newest
                ->get();



            $userNames = [];
            foreach ($reports as $report) {
                if (!in_array($report->user_name, $userNames)) {
                    $cleaned = [
                        'id' => $report['id'],
                        'user_name' => $report['user_name'],
                        'name' => $report['first_name'] . " " . $report["last_name"],
                        'email' => $report['email'],
                        'contact' => $report['contact'],
                        'pos' => [
                            'lat' => $report['latitude'],
                            'lng' => $report['longitude']
                        ],
                        'time' => explode(' ', $report['created_at'])[1],
                        'month' => explode('-', explode(' ', $report['created_at'])[0])[1],
                        'date' => explode('-', explode(' ', $report['created_at'])[0])[2] . ", " . explode('-', explode(' ', $report['created_at'])[0])[0],
                        'profile' => $report['profile'],
                        'user_level' => $report['user_level']
                    ];
                    $station = $request->has('id') ? $this->dynamic->getUserStation($request->input('id')) : ['response' => false];
                    $station = $station['response'] ? $station['station'] : 100;

                    // Check if user exists in incident-secured table
                    $isSecured = DB::table('incident-secured')
                        ->where('citizen', $cleaned['id'])
                        ->whereDate('created_at', $currentDate->format('Y-m-d'))
                        ->exists();

                    $stationC = null;
                    if ($cleaned['user_level'] == 3) {
                        $stationC = DB::table('incidents')
                            ->where('reported_by_user', $cleaned['id'])
                            ->whereDate('created_at', $currentDate->format('Y-m-d'))
                            ->value('station');
                    } else {
                        $stationC = $this->dynamic->getUserStation($cleaned['id']);
                        $stationC = $stationC['response'] ? $stationC['station'] : 100;
                    }

                    // Only add to data if incident is not secured
                    if (!$isSecured) {
                        // For station 100, add all unsecured incidents
                        // For other stations, only add if it matches their station
                        if ($station == 100 || ($stationC != null)) {
                            array_push($data['data'], $cleaned);
                            array_push($userNames, $report->user_name);
                        }
                    }
                }
            }
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }
}
