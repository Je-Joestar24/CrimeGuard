<?php

namespace App\Http\Controllers\CrimeGuardM;

use App\Http\Controllers\Controller;
use App\Models\Addresses;
use App\Models\TrailLog;
use App\Models\Victims;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class victimsModule extends Controller
{
    //table display

    public function tableDisplay(Request $request)
    {

        $data = [];

        try {
            /* Table headers */
            $data['table']['headers'] = [
                'id',
                'profile',
                'last name',
                'firstname',
                'email address',
                'phone no.',
                'current address',
                'age',
                'gender',
                'civil status',
            ];

            /* table data */

            /* Build the initial query */
            $query = Victims::leftJoin('addresses', 'victims.current_address_id', '=', 'addresses.id')->select([

                'victims.id',
                'victims.id_card_presented as profile',
                'victims.firstname',
                'victims.lastname',
                'victims.email',
                'victims.mobile_phone',
                DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city) AS cur_address'),
                'victims.age',
                'victims.gender',
                'victims.civil_status',

            ])
                ->whereNull('victims.archived_at')
                ->whereNull('victims.deleted_by');

            /* Apply search if the search term is provided */
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($query) use ($search) {
                    $query->orWhere('victims.id', 'like', "%{$search}%")
                        ->orWhere('victims.firstname', 'like', "%{$search}%")
                        ->orWhere('victims.lastname', 'like', "%{$search}%")
                        ->orWhere('victims.email', 'like', "%{$search}%")
                        ->orWhere('victims.mobile_phone', 'like', "%{$search}%")
                        ->orWhere(DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city)'), 'like', "%{$search}%")
                        ->orWhere('victims.age', 'like', "%{$search}%")
                        ->orWhere('victims.gender', 'like', "%{$search}%")
                        ->orWhere('victims.civil_status', 'like', "%{$search}%");
                });
            }

            /* Execute the query */
            $data['table']['data'] = $query->get();
            $data['table']['type'] = 1;
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
        }

        return response()->json($data);
    }

    public function search(Request $request)
    {

        $data = [];

        try {
            $query = Victims::leftJoin('addresses', 'victims.current_address_id', '=', 'addresses.id')->select([
                'victims.id',
                'victims.firstname',
                'victims.lastname',
                'victims.mobile_phone',
            ])
                ->whereNull('victims.archived_at')
                ->whereNull('victims.deleted_by');

            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($query) use ($search) {
                    $query->orWhere('victims.id', 'like', "%{$search}%")
                        ->orWhere('victims.firstname', 'like', "%{$search}%")
                        ->orWhere('victims.lastname', 'like', "%{$search}%")
                        ->orWhere('victims.email', 'like', "%{$search}%")
                        ->orWhere('victims.mobile_phone', 'like', "%{$search}%")
                        ->orWhere(DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city)'), 'like', "%{$search}%")
                        ->orWhere('victims.age', 'like', "%{$search}%")
                        ->orWhere('victims.gender', 'like', "%{$search}%")
                        ->orWhere('victims.civil_status', 'like', "%{$search}%");
                });
            }

            $data['data'] = $query->get();
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
        }

        return response()->json($data);
    }

    /* Archive table display */
    public function archiveTableDisplay(Request $request)
    {

        $data = [];
        /* Table headers */
        $data['table']['headers'] = [
            'id',
            'last name',
            'firstname',
            'email address',
            'phone no.',
            'age',
            'gender',
            'civil status',
            'current address',
            'deleted by',
            'date deleted',
            'time deleted'
        ];

        $data['table']['data'] = [];

        try {
            /* table data */
            $victims = Victims::leftJoin('addresses', 'victims.current_address_id', '=', 'addresses.id')
                ->leftJoin('users', 'victims.deleted_by', '=', 'users.id')
                ->select([
                    'victims.id',
                    'victims.firstname',
                    'victims.lastname',
                    'victims.email',
                    'victims.mobile_phone',
                    DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city) AS cur_address'),
                    'victims.age',
                    'victims.gender',
                    'victims.civil_status',
                    'victims.archived_at',
                    'users.user_name'
                ])
                ->where('victims.archived_at', 'IS NOT', NULL)
                ->where('victims.deleted_by', 'IS NOT', NULL);
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $victims->where(function ($victims) use ($search) {
                    $victims->orWhere('victims.id', 'like', "%{$search}%")
                        ->orWhere('victims.firstname', 'like', "%{$search}%")
                        ->orWhere('victims.lastname', 'like', "%{$search}%")
                        ->orWhere('victims.email', 'like', "%{$search}%")
                        ->orWhere('victims.mobile_phone', 'like', "%{$search}%")
                        ->orWhere(DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city)'), 'like', "%{$search}%")
                        ->orWhere('victims.age', 'like', "%{$search}%")
                        ->orWhere('victims.gender', 'like', "%{$search}%")
                        ->orWhere('victims.archived_at', 'like', "%{$search}%")
                        ->orWhere('users.user_name', 'like', "%{$search}%")
                        ->orWhere('victims.civil_status', 'like', "%{$search}%");
                });
            }

            /* Execute the query */
            $victims = $victims->get();

            foreach ($victims as $victim) {
                $cleaned = [
                    'id' => $victim['id'],
                    'first_name' => $victim['firstname'],
                    'last_name' => $victim['lastname'],
                    'email' => $victim['email'],
                    'contact' => $victim['mobile_phone'],
                    'age' => $victim['age'],
                    'gender' => $victim['gender'],
                    'civil_status' => $victim['civil_status'],
                    'cur_address' => $victim['cur_address'],
                    'deleted_by' => $victim['user_name'],
                    'date_deleted' => explode(' ', $victim['archived_at'])[0],
                    'time_deleted' => explode(' ', $victim['archived_at'])[1]
                ];
                array_push($data['table']['data'], $cleaned);
            }

            $data['table']['type'] = 0;
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
        }

        return response()->json($data);
    }

    /* Archiving data */
    public function archive(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $data = [];

        try {
            $archive = [
                'archived_at' => $currentDate->format('Y-m-d H:i:s'),
                'deleted_by' => $request['archived_by']
            ];
            Victims::where('id', $request['id'])->update($archive);

            TrailLog::create(['user_id' => $request->input('deleted_by'), 'action' => 'deleted', 'item' => 'victim']);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }
        return response()->json($data);
    }

    public function restore(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $data = [];

        try {
            $archive = [
                'archived_at' => NULL,
                'deleted_by' => NULL
            ];
            Victims::where('id', $request['id'])->update($archive);
            TrailLog::create(['user_id' => $request->input('user_id'), 'action' => 'restored', 'item' => 'victim']);

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }
        return response()->json($data);
    }


    public function viewVictim(Request $request)
    {

        try {
            $victim = Victims::select([
                'firstname',
                'lastname',
                'nickname',
                'middlename',
                'citizenship',
                'gender',
                'email',
                'civil_status',
                'birth_date',
                'age',
                'place_of_birth',
                'home_phone',
                'citizenship',
                'under_influence_of',
                'mobile_phone',
                'fb_account',
                'id_card_presented'
            ]);
            $victim = $victim->find($request['id']);

            $data['data'] = [
                'id_card_presented' => $victim->id_card_presented,
                'last_name' => $victim['lastname'],
                'first_name' => $victim['firstname'],
                'middle_name' => $victim['middlename'],
                'age' => $victim['age'],
                'gender' => $victim['gender'],
                'nick_name' => $victim['nickname'],
                'facebook' => $victim['fb_account'],
                'email' => $victim['email'],
                'telephone' => $victim['home_phone'],
                'contact' => $victim['mobile_phone'],
                'under_influence' => $victim['under_influence_of'],
                'civil_status' => $victim['civil_status'],
                'nationality' => $victim['citizenship']
            ];

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function viewAddresses(Request $request)
    {

        $data = [];

        try {

            $data['data'] = Victims::leftJoin('addresses as current', 'victims.current_address_id', '=', 'current.id')
                ->leftJoin('addresses as other', 'victims.other_address_id', '=', 'other.id')
                ->select([
                    'current.street as current_street',
                    'current.house_number as current_house_number',
                    'current.village as current_village',
                    'current.barangay as current_barangay',
                    'current.city as current_city',
                    'current.province as current_province',
                    'other.street as other_street',
                    'other.house_number as other_house_number',
                    'other.village as other_village',
                    'other.barangay as other_barangay',
                    'other.city as other_city',
                    'other.province as other_province',
                ])
                // ->where('victims.archived_at', '=', NULL)
                // ->where('victims.deleted_by', '=', NULL)
                ->find($request['id']);

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }


    public function viewRecords(Request $request)
    {

        $data = [];

        try {

            $records = Victims::join('incident-victims', 'incident-victims.victim', '=', 'victims.id')
                ->join('incidents', 'incident-victims.incident', '=', 'incidents.id')
                ->join('incident-types', 'incidents.incident_type', '=', 'incident-types.id')
                ->select([
                    'incident-types.incident_name',
                    'incidents.location',
                    'incidents.time_of_incident',
                    'incidents.date_of_incident'
                ])
                // ->where('victims.archived_at', '=', NULL)
                // ->where('victims.deleted_by', '=', NULL)
                ->where('incident-victims.victim', '=', $request['id'])
                ->get();

            foreach ($records as $record) {
                $r = explode(' ', $record['time_of_incident'])[1];
                $record['time_of_incident'] = $r;
            }
            $data['data'] = $records;
            $data['response'] = 'Success';
        } catch (\Exception $e) {

            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    /* addVictim */
    public function addVictim(Request $request)
    {
        $data = [];

        $currentAddress = $request['current_address'];
        $otherAddress = $request['other_address'];
        $victim =  $request['victim'];


        try {
            $current_id = $this->insertAddressProcess($currentAddress);
            $other_id = $this->insertAddressProcess($otherAddress);

            if ($current_id != -1) $victim['current_address_id'] = $current_id;
            if ($other_id != -1) $victim['other_address_id'] = $other_id;

            $victimData = $victim;
            TrailLog::create(['user_id' => $request->input('id'), 'action' => 'added', 'item' => 'victim']);
            Victims::create($victimData);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        // Return a response
        return response()->json($data);
    }


    public function editDisplayData(Request $request)
    {
        $data = [];
        $current_address = ['street' => NULL, 'village' => NULL, 'barangay' => NULL, 'city' => NULL, 'province' => NULL];
        $other_address = ['street' => NULL, 'village' => NULL, 'barangay' => NULL, 'city' => NULL, 'province' => NULL];

        try {
            $victim = Victims::select('lastname', 'firstname', 'middlename', 'qualifier', 'nickname', 'citizenship', 'gender', 'civil_status', 'birth_date', 'age', 'place_of_birth', 'home_phone', 'mobile_phone', 'under_influence_of', 'current_address_id', 'other_address_id')->find($request['id']);
            $other_info = Victims::select('highest_educ_attainment', 'occupation', 'id_card_presented', 'email', 'fb_account')->find($request['id']);
            if (Addresses::select('*')->find($victim['current_address_id'])) $current_address = Addresses::select('street', 'village', 'barangay', 'city', 'province')->find($victim['current_address_id']);
            if (Addresses::select('*')->find($victim['other_address_id'])) $other_address = Addresses::select('street', 'village', 'barangay', 'city', 'province')->find($victim['other_address_id']);


            unset($victim['other_address_id']);
            unset($victim['current_address_id']);
            $data['data']['victim'] = $victim;
            $data['data']['current_address'] = $current_address;
            $data['data']['other_address'] = $other_address;
            $data['data']['ohter_info'] = $other_info;
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['Err'] = $e;
        }
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $data = [];

        $currentAddress = $request['current_address'];
        $otherAddress = $request['other_address'];
        $victim =  $request['victim'];


        try {
            $current_id = $this->insertAddressProcess($currentAddress);
            $other_id = $this->insertAddressProcess($otherAddress);

            if ($current_id != -1) $victim['current_address_id'] = $current_id;
            if ($other_id != -1) $victim['other_address_id'] = $other_id;

            $victimData = $victim;

            Victims::find($victim['id'])->update($victimData);
            TrailLog::create(['user_id' => $request->input('id'), 'action' => 'edited', 'item' => 'victim']);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        // Return a response
        return response()->json($data);
    }

    /* add victim sub functions */
    //address insertion
    private function insertAddressProcess($param)
    {
        $address_id = -1;
        $address = $param;
        $address_n = $this->isObjNull($address);

        if ($address_n) $address_id = $this->addressId($address);
        if ($address_n && $address_id == -1) $this->addressInsert($address);
        $address_id = $this->addressId($address);

        return $address_id;
    }

    private function addressInsert($param)
    {
        Addresses::create($param);
    }
    // for  geeting the address id
    private function addressId($param)
    {
        try {
            if (is_null($param['barangay'])) $id = Addresses::where('barangay', '=', NULL);
            else $id = Addresses::where('barangay', $param['barangay']);

            if (is_null($param['city'])) $id = $id->where('city', '=', NULL);
            else $id = $id->where('city', $param['city']);

            if (is_null($param['house_number'])) $id = $id->where('house_number', '=', NULL);
            else $id = $id->where('house_number', $param['house_number']);

            if (is_null($param['province'])) $id = $id->where('province', '=', NULL);
            else $id = $id->where('province', $param['province']);

            if (is_null($param['street'])) $id = $id->where('street', '=', NULL);
            else $id = $id->where('street', $param['street']);

            if (is_null($param['village'])) $id = $id->where('village', '=', NULL);
            else $id = $id->where('village', $param['village']);

            $id = $id->select('id')->first()['id'];
        } catch (\Exception $e) {
            $id = -1;
        }
        return $id;
    }
    // for checking if object null 
    private function isObjNull($param)
    {
        $indicator = FALSE;
        foreach ($param as $key => $value) {
            if ($value != NULL || $value != '') {
                $indicator = TRUE;
                break;
            }
        }
        return $indicator;
    }
    /* add victim end sub */
}
