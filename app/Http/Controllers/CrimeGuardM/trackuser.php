<?php

namespace App\Http\Controllers\CrimeGuardM;

use App\Http\Controllers\Controller;
use App\Models\UserTrack;
use DateTime;
use Illuminate\Http\Request;

class trackuser extends Controller
{
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
                    'user_track.id',
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
                ->whereDate('user_track.created_at', $currentDate->format('Y-m-d'))
                ->orderBy('user_track.created_at', 'asc')
                ->orderBy('user_track.user', 'asc')  // Order by created_at from oldest to newest
                ->get();

            foreach ($reports as $report) {
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
                array_push($data['data'], $cleaned);
            }
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }
}
