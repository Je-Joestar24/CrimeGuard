<?php

namespace App\Http\Controllers\CrimeGuardM;

use App\Http\Controllers\Controller;
use App\Models\Logs;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogsModule extends Controller
{
    //

    public function listDisplay(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $currentDate->format('Y-m-d H:i:s');
        $data = [];

        try {
            /* table data */
            $data['list']['data'] = Logs::leftJoin('users', 'logs.officer_id', '=', 'users.id')->select([
                'logs.id',
                'users.id',
                'users.user_name',
                'users.email',
                'logs.login',
                'logs.logout'
            ]);

            if ($request->has('search') && !empty($request->input('search'))) {
                $searchTerm = $request->input('search');
                $data['list']['data'] = $data['list']['data']->where(function ($q) use ($searchTerm) {
                    $q->where('users.first_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.last_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.user_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.email', 'like', "%{$searchTerm}%")
                        ->orWhere('users.contact', 'like', "%{$searchTerm}%")
                        ->orWhere('logs.login', 'like', "%{$searchTerm}%");
                });
            }

            $data['list']['data'] = $data['list']['data'] ->orderBy('logs.login', 'desc')->get();
            for ($i = 0; $i < count($data['list']['data']); $i++) {
                $dates = explode('-', explode(" ", $data['list']['data'][$i]['login'])[0]);

                $data['list']['data'][$i]['month'] = (int)$dates[1];
                $data['list']['data'][$i]['date'] = $dates[2] . ", " . $dates[0];
                $data['list']['data'][$i]['login'] = explode(" ", $data['list']['data'][$i]['login'])[1];
                $data['list']['data'][$i]['logout'] = $data['list']['data'][$i]['logout'] != NULL ? explode(" ", $data['list']['data'][$i]['logout'])[1] : '-';
            }
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
        }

        return response()->json($data);
    }

    public function addLog(Request $request)
    {
        $response = [];
        try {
            Logs::create(['officer_id' => 2, 'login' => date('Y-m-d H:i:s'), 'logout' => date('Y-m-d H:i:s')]);
            $response['response'] = 'success';
        } catch (\Exception $e) {
            $response['response'] = 'error';
        }
        return response()->json($response);
    }
}
