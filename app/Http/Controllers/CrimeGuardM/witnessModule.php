<?php

namespace App\Http\Controllers\crimeguardm;

use App\Http\Controllers\Controller;
use App\Models\Addresses;
use App\Models\ReportingPerson;
use App\Models\TrailLog;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class witnessModule extends Controller
{
    //Table displays


    public function tableDisplay(Request $request)
    {

        $data = [];

        try {
            /* Table headers */
            $data['table']['headers'] = [
                'id',
                'last name',
                'firstname',
                'email address',
                'phone no.',
                'current address',
                'age',
                'gender',
            ];

            $query = ReportingPerson::leftJoin('addresses', 'reporting-persons.current_address_id', '=', 'addresses.id')->select([
                'reporting-persons.id',
                'reporting-persons.firstname',
                'reporting-persons.lastname',
                'reporting-persons.email',
                'reporting-persons.mobile_phone',
                DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city) AS cur_address'),
                'reporting-persons.age',
                'reporting-persons.gender',
            ])
                ->whereNull('reporting-persons.archived_at')
                ->whereNull('reporting-persons.deleted_by');
    
            /* search */
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($query) use ($search) {
                    $query->orWhere('reporting-persons.id', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.firstname', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.lastname', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.email', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.mobile_phone', 'like', "%{$search}%")
                        ->orWhere(DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city)'), 'like', "%{$search}%")
                        ->orWhere('reporting-persons.age', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.gender', 'like', "%{$search}%");
                });
            }
    
            
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

            $query = ReportingPerson::leftJoin('addresses', 'reporting-persons.current_address_id', '=', 'addresses.id')->select([
                'reporting-persons.id',
                'reporting-persons.firstname',
                'reporting-persons.lastname',
                'reporting-persons.mobile_phone',
            ])
                ->whereNull('reporting-persons.archived_at')
                ->whereNull('reporting-persons.deleted_by');
    
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($query) use ($search) {
                    $query->orWhere('reporting-persons.id', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.firstname', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.lastname', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.email', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.mobile_phone', 'like', "%{$search}%")
                        ->orWhere(DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city)'), 'like', "%{$search}%")
                        ->orWhere('reporting-persons.age', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.gender', 'like', "%{$search}%");
                });
            }
    
            
            $data['data'] = $query->get();
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
        }

        return response()->json($data);
    }

    public function archiveTableDisplay(Request $request)
    {

        $data = [];

        try {
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
            /* table data */
            $witnesses = ReportingPerson::leftJoin('addresses', 'reporting-persons.current_address_id', '=', 'addresses.id')
                ->leftJoin('users', 'reporting-persons.deleted_by', '=', 'users.id')->select([
                    'reporting-persons.id',
                    'reporting-persons.firstname',
                    'reporting-persons.lastname',
                    'reporting-persons.email',
                    'reporting-persons.mobile_phone',
                    DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city) AS cur_address'),
                    'reporting-persons.age',
                    'reporting-persons.gender',
                    'reporting-persons.civil_status',
                    'reporting-persons.archived_at',
                    'users.user_name'
                ])
                ->where('reporting-persons.archived_at', 'IS NOT', NULL)
                ->where('reporting-persons.deleted_by', 'IS NOT', NULL);
                
                
            /* search */
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $witnesses->where(function ($witnesses) use ($search) {
                    $witnesses->orWhere('reporting-persons.id', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.firstname', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.lastname', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.email', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.mobile_phone', 'like', "%{$search}%")
                        ->orWhere(DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city)'), 'like', "%{$search}%")
                        ->orWhere('reporting-persons.age', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.archived_at', 'like', "%{$search}%")
                        ->orWhere('users.user_name', 'like', "%{$search}%")
                        ->orWhere('reporting-persons.gender', 'like', "%{$search}%");
                });
            }
            
            $witnesses = $witnesses->get();

            foreach ($witnesses as $witness) {
                $cleaned = [
                    'id' => $witness['id'],
                    'first_name' => $witness['firstname'],
                    'last_name' => $witness['lastname'],
                    'email' => $witness['email'],
                    'contact' => $witness['mobile_phone'],
                    'age' => $witness['age'],
                    'gender' => $witness['gender'],
                    'civil_status' => $witness['civil_status'],
                    'cur_address' => $witness['cur_address'],
                    'deleted_by' => $witness['user_name'],
                    'date_deleted' => explode(' ', $witness['archived_at'])[0],
                    'time_deleted' => explode(' ', $witness['archived_at'])[1]
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
            ReportingPerson::where('id', $request['id'])->update($archive);
            TrailLog::create(['user_id'=> $request->input('deleted_by'), 'action' => 'deleted', 'item' => 'witness']);
            
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
            ReportingPerson::where('id', $request['id'])->update($archive);
            
            TrailLog::create(['user_id'=> $request->input('user_id'), 'action' => 'restored', 'item' => 'witness']);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }
        return response()->json($data);
    }

    public function viewWitness(Request $request)
    {

        try {
            $witness = ReportingPerson::select([
                'id_card_presented',
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
                'fb_account'
            ]);
            $witness = $witness->find($request['id']);

            $data['data'] = [
                'id_card_presented' => $witness->id_card_presented,
                'last_name' => $witness['lastname'],
                'first_name' => $witness['firstname'],
                'middle_name' => $witness['middlename'],
                'age' => $witness['age'],
                'gender' => $witness['gender'],
                'nick_name' => $witness['nickname'],
                'facebook' => $witness['fb_account'],
                'email' => $witness['email'],
                'telephone' => $witness['home_phone'],
                'contact' => $witness['mobile_phone'],
                'under_influence' => $witness['under_influence_of'],
                'civil_status' => $witness['civil_status'],
                'nationality' => $witness['citizenship']
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
            
            $data['data'] = ReportingPerson::leftJoin('addresses as current', 'reporting-persons.current_address_id', '=', 'current.id')
            ->leftJoin('addresses as other', 'reporting-persons.other_address_id', '=', 'other.id')
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
                // ->where('reporting-persons.archived_at', '=', NULL)
                // ->where('reporting-persons.deleted_by', '=', NULL)
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

            $records = ReportingPerson::join('incident-reporting-persons', 'incident-reporting-persons.reporting_person', '=', 'reporting-persons.id')
                ->join('incidents', 'incident-reporting-persons.incident', '=', 'incidents.id')
                ->join('incident-types', 'incidents.incident_type', '=', 'incident-types.id')
                ->select([
                    'incident-types.incident_name',
                    'incidents.location',
                    'incidents.time_of_incident',
                    'incidents.date_of_incident'
                ])
                // ->where('reporting-persons.archived_at', '=', NULL)
                // ->where('reporting-persons.deleted_by', '=', NULL)
                ->where('incident-reporting-persons.reporting_person', '=', $request['id'])
                ->get();

            foreach($records as $record){
                $r = explode(' ',$record['time_of_incident'])[1] ;
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

    
    public function addWitness(Request $request)
    {
        $data = [];

        $currentAddress = $request['current_address'];
        $otherAddress = $request['other_address'];
        $witness =  $request['witness'];



        try {

            $current_id = $this->insertAddressProcess($currentAddress);
            $other_id = $this->insertAddressProcess($otherAddress);
            if ($current_id != -1) $witness['current_address_id'] = $current_id;
            if ($other_id != -1) $witness['other_address_id'] = $other_id;
            
            $witnessData = $witness;

            ReportingPerson::create($witnessData);
            
            TrailLog::create(['user_id'=> $request->input('id'), 'action' => 'added', 'item' => 'witness']);
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
            $witness = ReportingPerson::select('lastname', 'firstname', 'middlename', 'qualifier', 'nickname', 'citizenship', 'gender', 'civil_status', 'birth_date', 'age', 'place_of_birth', 'home_phone', 'mobile_phone', 'under_influence_of', 'current_address_id', 'other_address_id')->find($request['id']);
            $other_info = ReportingPerson::select('highest_educ_attainment','occupation', 'id_card_presented', 'email', 'fb_account', 'signature')->find($request['id']);
            if(Addresses::select('*')->find($witness['current_address_id']))$current_address = Addresses::select('street', 'village', 'barangay', 'city', 'province')->find($witness['current_address_id']);
            if(Addresses::select('*')->find($witness['other_address_id']))$other_address = Addresses::select('street', 'village', 'barangay', 'city', 'province')->find($witness['other_address_id']);

            
            unset($witness['other_address_id']);
            unset($witness['current_address_id']);
            $data['data']['witness'] = $witness;
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
        $witness =  $request['witness'];

        try {

            $current_id = $this->insertAddressProcess($currentAddress);
            $other_id = $this->insertAddressProcess($otherAddress);
            if ($current_id != -1) $witness['current_address_id'] = $current_id;
            if ($other_id != -1) $witness['other_address_id'] = $other_id;
            
            $witnessData = $witness;

            ReportingPerson::find($witness['id'])->update($witnessData);
            TrailLog::create(['user_id'=> $request->input('id'), 'action' => 'edited', 'item' => 'witness']);

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        // Return a response
        return response()->json($data);
    }

    /* add witness sub functions */
    //address insertion
    private function insertAddressProcess($param){
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
    /* add witness end sub */

}
