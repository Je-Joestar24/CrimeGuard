<?php

namespace App\Http\Controllers\crimeGuardm;

use App\Http\Controllers\Controller;
use App\Models\Incidents;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class notificationModule extends Controller
{
    //
    
    public function listDisplay(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();

        $data = [];

        try {
            /* table data */
            $notif = Incidents::leftJoin('users', 'incidents.reported_by_user', '=', 'users.id')
            ->select([
                'incidents.id',
                'users.id',
                'users.user_name',
                'users.email',
                'users.contact',
                'incidents.message',
                'incidents.location',
                'incidents.time_reported'
            ])->where('incidents.date_reported', $currentDate->format('Y-m-d'));

            if ($request->has('search') && !empty($request->input('search'))) {
                $searchTerm = $request->input('search');
                $notif = $notif->where(function ($q) use ($searchTerm) {
                    $q->where('users.first_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.last_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.user_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.email', 'like', "%{$searchTerm}%")
                        ->orWhere('incidents.message', 'like', "%{$searchTerm}%")
                        ->orWhere('incidents.location', 'like', "%{$searchTerm}%")
                        ->orWhere('incidents.time_reported', 'like', "%{$searchTerm}%")
                        ->orWhere('users.contact', 'like', "%{$searchTerm}%");
                });
            }
            $data['list']['data'] = $notif->get();
            for($i = 0; $i < count($data['list']['data']) ; $i ++){

                $dates = explode('-', explode(" ",$data['list']['data'][$i]['time_reported'])[0]);
                $data['list']['data'][$i]['month'] = (int)$dates[1];
                $data['list']['data'][$i]['date'] = $dates[2].", ".$dates[0];

                $time = $data['list']['data'][$i]['time_reported'];

                unset($data['list']['data'][$i]['time_reported']);

                $data['list']['data'][$i]['time'] = explode(" ",Carbon::parse($time)->format('Y-m-d H:i:s'))[1];
            
            }

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }
}
