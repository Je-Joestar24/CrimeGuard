<?php

namespace App\Http\Controllers\crimeguardm;

use App\Http\Controllers\Controller;
use App\Models\TrailLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class traillogModule extends Controller
{
    //
    public function listDisplay(Request $request)
    {

        $data = [];

        try {
            /* table data */
            $data['list']['data'] = TrailLog::leftJoin('users', 'trail-log.user_id', '=', 'users.id')->select([
                'trail-log.id',
                'users.id',
                'users.user_name',
                'users.email',
                'trail-log.action',
                'trail-log.item',
                'trail-log.created_at'
            ]);

            if ($request->has('search') && !empty($request->input('search'))) {
                $searchTerm = $request->input('search');
                $data['list']['data'] = $data['list']['data']->where(function ($q) use ($searchTerm) {
                    $q->where('users.first_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.last_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.user_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.email', 'like', "%{$searchTerm}%")
                        ->orWhere('trail-log.action', 'like', "%{$searchTerm}%")
                        ->orWhere('trail-log.item', 'like', "%{$searchTerm}%")
                        ->orWhere('users.contact', 'like', "%{$searchTerm}%");
                });
            }
            $data['list']['data'] = $data['list']['data']->orderBy('trail-log.created_at', 'desc')
            ->get();

                
            for($i = 0; $i < count($data['list']['data']) ; $i ++){

                $dates = explode('-', explode(" ",$data['list']['data'][$i]['created_at'])[0]);
                $data['list']['data'][$i]['month'] = (int)$dates[1];
                $data['list']['data'][$i]['date'] = $dates[2].", ".$dates[0];

                $time = $data['list']['data'][$i]['created_at'];

                /* unset para way error */
                unset($data['list']['data'][$i]['created_at']);

                $data['list']['data'][$i]['time'] = explode(" ",Carbon::parse($time)->format('Y-m-d H:i:s'))[1];
            }

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function addLog(Request $request)
    {
        $response = [];
        try {
            TrailLog::create(['user_id' => 2, 'item' => 'suspect', 'action' => 'deleted']);
            $response['response'] = 'success';
        } catch (\Exception $e) {
            $response['response'] = 'error';
        }
        return response()->json($response);
    }
}
