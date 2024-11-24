<?php

namespace App\Http\Controllers\CrimeGuardM;

use App\Http\Controllers\Controller;
use App\Models\Addresses;
use App\Models\Suspects;
use App\Models\TrailLog;
use App\Models\Victims;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuspectsManipulation extends Controller
{



    /* Displayed data on the table */
    public function tableDisplay(Request $request)
    {
        $data = [];

        try {
            $data['table']['headers'] = [
                'id',
                'profile',
                'last name',
                'firstname',
                'email address',
                'phone no.',
                'age',
                'gender',
                'civil status',
                'current address'
            ];

            $query = Suspects::leftJoin('addresses', 'suspects.current_address_id', '=', 'addresses.id')
                ->select([
                    'suspects.id',
                    'suspects.profile',
                    'suspects.firstname',
                    'suspects.lastname',
                    'suspects.email',
                    'suspects.mobile_phone',
                    'suspects.age',
                    'suspects.gender',
                    'suspects.civil_status',
                    DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city) AS cur_address'),
                ])
                ->where('suspects.archived_at', '=', NULL)
                ->where('suspects.deleted_by', '=', NULL);

            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($query) use ($search) {
                    $query->orWhere('suspects.id', 'like', "%{$search}%")
                        ->orWhere('suspects.firstname', 'like', "%{$search}%")
                        ->orWhere('suspects.lastname', 'like', "%{$search}%")
                        ->orWhere('suspects.email', 'like', "%{$search}%")
                        ->orWhere('suspects.mobile_phone', 'like', "%{$search}%")
                        ->orWhere('suspects.age', 'like', "%{$search}%")
                        ->orWhere('suspects.gender', 'like', "%{$search}%")
                        ->orWhere('suspects.civil_status', 'like', "%{$search}%")
                        ->orWhere(DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city)'), 'like', "%{$search}%");
                });
            }
            $data['table']['data']  = $query->get();
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
            $query = Suspects::leftJoin('addresses', 'suspects.current_address_id', '=', 'addresses.id')
                ->select([
                    'suspects.id',
                    'suspects.firstname',
                    'suspects.lastname',
                    'suspects.mobile_phone',
                ])
                ->where('suspects.archived_at', '=', NULL)
                ->where('suspects.deleted_by', '=', NULL);
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($query) use ($search) {
                    $query->orWhere('suspects.id', 'like', "%{$search}%")
                        ->orWhere('suspects.firstname', 'like', "%{$search}%")
                        ->orWhere('suspects.lastname', 'like', "%{$search}%")
                        ->orWhere('suspects.email', 'like', "%{$search}%")
                        ->orWhere('suspects.mobile_phone', 'like', "%{$search}%")
                        ->orWhere('suspects.age', 'like', "%{$search}%")
                        ->orWhere('suspects.gender', 'like', "%{$search}%")
                        ->orWhere('suspects.civil_status', 'like', "%{$search}%")
                        ->orWhere(DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city)'), 'like', "%{$search}%");
                });
            }
            $data['data']  = $query->get();
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
        }

        return response()->json($data);
    }
    /* archive table */
    public function archiveTableDisplay(Request $request)
    {
        $data = [];
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
            $query = Suspects::leftJoin('addresses', 'suspects.current_address_id', '=', 'addresses.id')
                ->leftJoin('users', 'suspects.deleted_by', '=', 'users.id')
                ->select([
                    'suspects.id',
                    'suspects.firstname',
                    'suspects.lastname',
                    'suspects.email',
                    'suspects.mobile_phone',
                    'suspects.age',
                    'suspects.gender',
                    'suspects.civil_status',
                    DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city) AS cur_address'),
                    'suspects.archived_at',
                    'users.user_name'
                ])
                ->whereNotNull('suspects.archived_at')
                ->whereNotNull('suspects.deleted_by');

            // Apply dynamic search
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('suspects.firstname', 'like', "%{$search}%")
                        ->orWhere('suspects.lastname', 'like', "%{$search}%")
                        ->orWhere('suspects.email', 'like', "%{$search}%")
                        ->orWhere('suspects.mobile_phone', 'like', "%{$search}%")
                        ->orWhere('suspects.age', 'like', "%{$search}%")
                        ->orWhere('suspects.gender', 'like', "%{$search}%")
                        ->orWhere('suspects.civil_status', 'like', "%{$search}%")
                        ->orWhere(DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city)'), 'like', "%{$search}%")
                        ->orWhere('suspects.archived_at', 'like', "%{$search}%")
                        ->orWhere('users.user_name', 'like', "%{$search}%")
                        ->orWhere('suspects.id', 'like', "%{$search}%");
                });
            }

            $suspects = $query->get();

            foreach ($suspects as $suspect) {
                $cleaned = [
                    'id' => $suspect['id'],
                    'first_name' => $suspect['firstname'],
                    'last_name' => $suspect['lastname'],
                    'email' => $suspect['email'],
                    'contact' => $suspect['mobile_phone'],
                    'age' => $suspect['age'],
                    'gender' => $suspect['gender'],
                    'civil_status' => $suspect['civil_status'],
                    'cur_address' => $suspect['cur_address'],
                    'deleted_by' => $suspect['user_name'],
                    'date_deleted' => explode(' ', $suspect['archived_at'])[0],
                    'time_deleted' => explode(' ', $suspect['archived_at'])[1]
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
            Suspects::where('id', $request['id'])->update($archive);
            
            TrailLog::create(['user_id'=> $request->input('deleted_by'), 'action' => 'deleted', 'item' => 'suspect']);
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
            Suspects::where('id', $request['id'])->update($archive);
            TrailLog::create(['user_id'=> $request->input('user_id'), 'action' => 'restored', 'item' => 'suspect']);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }
        return response()->json($data);
    }


    public function viewSuspect(Request $request)
    {

        try {
            $suspected = Suspects::select([
                'firstname',
                'lastname',
                'nickname',
                'middlename',
                'citizenship',
                'email',
                'gender',
                'civil_status',
                'birth_date',
                'age',
                'place_of_birth',
                'home_phone',
                'citizenship',
                'under_influence_of',
                'mobile_phone',
                'fb_account',
                'profile'
            ]);
            $suspected = $suspected->find($request['id']);

            $data['data'] = [
                'last_name' => $suspected['lastname'],
                'first_name' => $suspected['firstname'],
                'middle_name' => $suspected['middlename'],
                'age' => $suspected['age'],
                'gender' => $suspected['gender'],
                'nick_name' => $suspected['nickname'],
                'facebook' => $suspected['fb_account'],
                'email' => $suspected['email'],
                'telephone' => $suspected['home_phone'],
                'contact' => $suspected['mobile_phone'],
                'under_influence' => $suspected['under_influence_of'],
                'civil_status' => $suspected['civil_status'],
                'nationality' => $suspected['citizenship'],
                'id_card_presented' => $suspected['profile']
            ];

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function viewPhysical(Request $request)
    {

        try {
            $suspected = Suspects::select([
                'hair_color',
                'hair_description',
                'eyes_color',
                'eyes_description',
                'built',
                'height',
                'weight'
            ]);
            $suspected = $suspected->find(1);

            $data['data'] = $suspected;

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function viewBackgroundInfo(Request $request)
    {

        try {
            $suspected = Suspects::join('addresses', 'suspects.work_address_id', '=', 'addresses.id')
                ->select([
                    'suspects.highest_educ_attainment',
                    'suspects.occupation',
                    'suspects.pnp_rank',
                    'suspects.unit_assignment',
                    'suspects.group_affiliation',
                    'addresses.street',
                    'addresses.village',
                    'addresses.barangay',
                    'addresses.city',
                    'addresses.province'
                ]);
            $suspected = $suspected->find($request['id']);

            $data['data'] = $suspected;

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

            $data['data'] = Suspects::leftJoin('addresses as current', 'suspects.current_address_id', '=', 'current.id')
                ->leftJoin('addresses as other', 'suspects.other_address_id', '=', 'other.id')
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
                // ->where('suspects.archived_at', '=', NULL)
                // ->where('suspects.deleted_by', '=', NULL)
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

            $records = Suspects::join('incident-suspects', 'incident-suspects.suspect', '=', 'suspects.id')
                ->join('incidents', 'incident-suspects.incident', '=', 'incidents.id')
                ->join('incident-types', 'incidents.incident_type', '=', 'incident-types.id')
                ->select([
                    'incident-types.incident_name',
                    'incidents.location',
                    'incidents.time_of_incident',
                    'incidents.date_of_incident'
                ])
                // ->where('suspects.archived_at', '=', NULL)
                // ->where('suspects.deleted_by', '=', NULL)
                ->where('incident-suspects.suspect', '=', $request['id'])
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


    public function viewVictims(Request $request)
    {

        $data = [];

        try {

            $records = Victims::join('incident-victims', 'incident-victims.victim', '=', 'victims.id')
                ->join('incidents', 'incident-victims.incident', '=', 'incidents.id')
                ->join('incident-types', 'incidents.incident_type', '=', 'incident-types.id')
                ->join('incident-suspects', 'incident-suspects.incident', '=', 'incidents.id')

                ->select([
                    'incident-types.incident_name',
                    'victims.lastname',
                    'victims.firstname',
                    'victims.middlename',
                    'victims.age',
                    'victims.gender',
                    'incidents.date_of_incident',
                ])->distinct()
                ->where('victims.archived_at', '=', NULL)
                ->where('victims.deleted_by', '=', NULL)
                ->where('incident-suspects.suspect', '=', $request['id'])
                ->get();

            /* foreach($records as $record){
                $r = explode(' ',$record['time_of_incident'])[1] ;
                $record['time_of_incident'] = $r;
            } */
            $data['data'] = $records;
            $data['response'] = 'Success';
        } catch (\Exception $e) {

            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }


    /* addSuspect */
    public function addSuspect(Request $request)
    {
        $data = [];
        $currentAddress = $request['current_address'];
        $otherAddress = $request['other_address'];
        $workAddress = $request['work_address'];
        $suspect =  $request['suspect'];



        try {
            /* for checking if the address already exists*/
            $current_id = $this->insertAddressProcess($currentAddress);
            $other_id = $this->insertAddressProcess($otherAddress);
            $work_id = $this->insertAddressProcess($workAddress);

            if ($current_id != -1) $suspect['current_address_id'] = $current_id;
            if ($other_id != -1) $suspect['other_address_id'] = $other_id;
            if ($work_id != -1) $suspect['work_address_id'] = $work_id;

            $suspectData = $suspect;

            Suspects::create($suspectData);
            
            TrailLog::create(['user_id'=> $request->input('id'), 'action' => 'added', 'item' => 'suspect']);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        // Return a response
        return response()->json($data);
    }

    public function editDisplayData(Request $request){
        $data = [];
        $current_address = ['street' => NULL, 'village' => NULL, 'barangay' => NULL, 'city' => NULL, 'province' => NULL];
        $other_address = ['street' => NULL, 'village' => NULL, 'barangay' => NULL, 'city' => NULL, 'province' => NULL];
        $work_address  = ['street' => NULL, 'village' => NULL, 'barangay' => NULL, 'city' => NULL, 'province' => NULL];

        try {
            $suspect = Suspects::select('lastname', 'firstname', 'middlename', 'qualifier', 'nickname', 'citizenship', 'gender', 'civil_status', 'birth_date', 'age', 'place_of_birth', 'home_phone', 'mobile_phone', 'under_influence_of', 'relation_to_victim', 'current_address_id', 'other_address_id', 'work_address_id', 'profile')->find($request['id']);
            $physical = Suspects::select('height', 'weight', 'eyes_color', 'eyes_description', 'hair_color', 'hair_description', 'built')->find($request['id']);
            $other_info = Suspects::select('highest_educ_attainment', 'occupation', 'email', 'fb_account', 'pnp_rank', 'unit_assignment', 'group_affiliation', 'has_previous_record', 'status')->find($request['id']);
            $other_info['has_previous_record'] = $other_info['has_previous_record'] == 1 ? 'YES' : 'NO';
            if (Addresses::select('*')->find($suspect['current_address_id'])) $current_address = Addresses::select('street', 'village', 'barangay', 'city', 'province')->find($suspect['current_address_id']);
            if (Addresses::select('*')->find($suspect['other_address_id'])) $other_address = Addresses::select('street', 'village', 'barangay', 'city', 'province')->find($suspect['other_address_id']);
            if (Addresses::select('*')->find($suspect['work_address_id'])) $work_address = Addresses::select('street', 'village', 'barangay', 'city', 'province')->find($suspect['work_address_id']);


            unset($suspect['other_address_id']);
            unset($suspect['current_address_id']);
            unset($suspect['work_address_id']);
            $data['data']['suspect'] = $suspect;
            $data['data']['current_address'] = $current_address;
            $data['data']['other_address'] = $other_address;
            $data['data']['work_address'] = $work_address;
            $data['data']['physical'] = $physical;
            $data['data']['ohter_info'] = $other_info;
            if ($other_info['has_previous_record'] == 'YES') $data['data']['desc'] = Suspects::select('previous_records_details')->find($request['id']);
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
        $workAddress = $request['work_address'];
        $suspect =  $request['suspect'];

        try {
            /* for checking if the address already exists*/
            $current_id = $this->insertAddressProcess($currentAddress);
            $other_id = $this->insertAddressProcess($otherAddress);
            $work_id = $this->insertAddressProcess($workAddress);

            if ($current_id != -1) $suspect['current_address_id'] = $current_id;
            if ($other_id != -1) $suspect['other_address_id'] = $other_id;
            if ($work_id != -1) $suspect['work_address_id'] = $work_id;

            $suspectData = $suspect;

            Suspects::find($suspectData['id'])->update($suspectData);
            
            TrailLog::create(['user_id'=> $request->input('id'), 'action' => 'edited', 'item' => 'suspect']);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        // Return a response
        return response()->json($data);
    }
    /* add suspect sub functions */
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
