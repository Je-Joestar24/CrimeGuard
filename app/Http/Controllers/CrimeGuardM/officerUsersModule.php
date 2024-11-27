<?php

namespace App\Http\Controllers\CrimeGuardM;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CrimeGuardM\Dynamic\DynamicFunctions;
use App\Models\Addresses;
use App\Models\OfficerCredential;
use App\Models\RankChangedReports;
use App\Models\TrailLog;
use App\Models\TransferReports;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OfficerUsersModule extends Controller
{
    //
    protected $dynamic;

    public function __construct(DynamicFunctions $dynamic)
    {
        $this->dynamic = $dynamic;
    }

    public function tableDisplay(Request $request)
    {

        $data = [];
        /* Table headers */
        $data['table']['headers'] = [
            'id',
            'profile',
            'last name',
            'firstname',
            'user name',
            'email address',
            'phone no.',
            'group',
            'current address',
        ];

        try {

            /* table data */
            $query = User::leftJoin('addresses', 'users.current_address', '=', 'addresses.id')->select([
                'users.id',
                'users.profile', 
                'users.first_name',
                'users.last_name',
                'users.user_name',
                'users.email',
                'users.contact',
                DB::raw('CASE 
                    WHEN users.user_level = 4 THEN "PATROL GROUP"
                    WHEN users.user_level = 2 THEN "OFFICE GROUP"
                    END as group_type'),
                DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city) AS cur_address'),
            ])->where(function($query) {
                $query->where('users.user_level', '=', '2')
                    ->whereNull('users.archived_at')
                    ->whereNull('users.deleted_by')
                    ->orWhere('users.user_level', '=', '4');
            });

            if ($request->has('search') && !empty($request->input('search'))) {
                $searchTerm = $request->input('search');
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('users.first_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.last_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.user_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.email', 'like', "%{$searchTerm}%")
                        ->orWhere('users.contact', 'like', "%{$searchTerm}%")
                        ->orWhere('users.id', 'like', "%{$searchTerm}%")
                        ->orWhere(DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city)'), 'like', "%{$searchTerm}%");
                });
            }
            $data['table']['data'] = $query->get();
            $data['table']['type'] = 1;
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }


    public function addUser(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $data = [];

        $user = $request['user'];
        $user_credentials = $request['officer_credentials'];
        $current_address = $request['current_address'];
        $other_address = $request['other_address'];
        $data['user'] = $user;
        try {
            $user['accepted_at'] = $currentDate->format('Y-m-d H:i:s');

            $current_id = $this->dynamic->nulled($current_address) ? null : $this->dynamic->getId(Addresses::class, $current_address);
            if ($current_id == -1) $current_id = $this->dynamic->addItem(Addresses::class, $current_address);

            $other_id = $this->dynamic->nulled($other_address) ? null : $this->dynamic->getId(Addresses::class, $other_address);
            if ($other_id == -1) $other_id = $this->dynamic->addItem(Addresses::class, $other_address);

            $user['other_address'] = $other_id;
            $user['current_address'] = $current_id;

            $user_id = $this->isUserUnique($user);

            if ($user_id != -1) {
                $data['response'] = 'Error';
                $data['Err'] = "duplacate";
                return response()->json($data);
            } else {
                $user_id = $this->dynamic->addItem(User::class, $user);
                $user_credentials['user_id'] = $user_id;
                $this->dynamic->addItem(OfficerCredential::class, $user_credentials);
            }

            TrailLog::create(['user_id' => $request->input('id'), 'action' => 'added', 'item' => 'officer account']);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['Err'] = $e;
        }
        return response()->json($data);
    }

    public function editDisplayData(Request $request)
    {
        $data = [];
        $current_address = ['street' => NULL, 'village' => NULL, 'barangay' => NULL, 'city' => NULL, 'province' => NULL];
        $other_address = ['street' => NULL, 'village' => NULL, 'barangay' => NULL, 'city' => NULL, 'province' => NULL];

        try {
            $officer = User::select('last_name', 'first_name', 'middle_name', 'gender',  'email', 'contact', 'profile', 'current_address', 'other_address')->find($request['id']);
            $officerCredits = OfficerCredential::select('rank', 'station')->where('user_id', $request['id'])->first();

            if ($officerCredits) {
                $officer = $this->dynamic->insertBeforeKey($officer->toArray(), ['rank' => $officerCredits['rank']], 'profile');
                $officer = $this->dynamic->insertBeforeKey($officer, ['station' => $officerCredits['station']], 'email');
            } else {
                $officer = $this->dynamic->insertBeforeKey($officer->toArray(), ['rank' => NULL], 'profile');
                $officer = $this->dynamic->insertBeforeKey($officer, ['station' => NULL], 'email');
            }

            $account = User::select('user_name')->find($request['id']);
            if ($officer['current_address']) $current_address = Addresses::select('street', 'village', 'barangay', 'city', 'province')->find($officer['current_address']);
            if ($officer['other_address']) $other_address = Addresses::select('street', 'village', 'barangay', 'city', 'province')->find($officer['other_address']);


            unset($officer['other_address']);
            unset($officer['current_address']);
            $data['data']['suspect'] = $officer;
            $data['data']['current_address'] = $current_address;
            $data['data']['other_address'] = $other_address;
            $data['data']['account'] = $account;
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['Err'] = $e;
        }
        return response()->json($data);
    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $defautD = Carbon::now()->toDateString();
        $data = [];

        $user = $request['user'];
        $user_credentials = $request['officer_credentials'];
        $user_credentials['user_id'] = $user['id'];
        $current_address = $request['current_address'];
        $other_address = $request['other_address'];
        try {

            $current_id = $this->dynamic->nulled($current_address) ? null : $this->dynamic->getId(Addresses::class, $current_address);
            if ($current_id == -1) $current_id = $this->dynamic->addItem(Addresses::class, $current_address);

            $other_id = $this->dynamic->nulled($other_address) ? null : $this->dynamic->getId(Addresses::class, $other_address);
            if ($other_id == -1) $other_id = $this->dynamic->addItem(Addresses::class, $other_address);

            $user['other_address'] = $other_id;
            $user['current_address'] = $current_id;

            User::find($user['id'])->update($user);


            $cred = OfficerCredential::where('user_id', $user['id'])->first();
            $rank = OfficerCredential::select('rank')->where('user_id', $user['id'])->first()->toArray()['rank'];
            $station = OfficerCredential::select('station')->where('user_id', $user['id'])->first()->toArray()['station'];

            if ($rank != $user_credentials['rank']) {
                RankChangedReports::create(['officer' => $user['id'], 'change_rank' => $rank . ' ' . $user_credentials['rank'], 'date_changed' => $defautD]);
            }

            if ($station != $user_credentials['station']) {
                TransferReports::create(['officer' => $user['id'], 'transfer' => $station . ' ' . $user_credentials['station'], 'date_transferred' => $defautD]);
            }

            if ($cred) $cred->update($user_credentials);
            else OfficerCredential::create($user_credentials);
            TrailLog::create(['user_id' => $request->input('id'), 'action' => 'edited', 'item' => 'officer account']);
            $data['data'] = $rank;
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['Err'] = $e;
        }
        return response()->json($data);
    }

    private function isUserUnique($param)
    {

        $id = User::where('email', $param['email'])
            ->orWhere('user_name', $param['user_name'])
            ->orWhere('contact', $param['contact'])
            ->value('id');

        if (is_null($id)) return -1;
        else return $id;
    }

    /* ACCOUNT VIEW */


    public function viewMyAccountBasic(Request $request)
    {

        $data = [];

        try {

            $data['data'] = OfficerCredential::join('users', 'officer-credentials.user_id', '=', 'users.id')
                ->where('users.id', $request->input('id'))
                ->select('users.user_name', 'users.email', 'users.contact', 'users.profile', 'officer-credentials.rank', 'officer-credentials.station')
                ->first();

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }


    public function viewMyAccountCred(Request $request)
    {

        $data = [];

        try {

            $data['data'] = User::select('user_name', 'email')
                ->find($request['id']);

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }


    public function viewPersonal(Request $request)
    {

        $data = [];

        try {

            $rnk = OfficerCredential::where('user_id', $request->input('id'))
                ->select('rank')
                ->first();
            $data['data'] = User::select('last_name', 'first_name', 'middle_name')->find($request->input('id'));
            $data['data']['rank'] = $rnk['rank'];

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }


    public function updateBasicData(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $data = [];
        $user = $request->has('data') ? $request->input('data') : [];
        $officer = $request->has('cred') ? $request->input('cred') : [];
        //$user['password'] = 'Sammer';
        try {
            $init = User::find($request->input('id'));
            if ($request->has('password')) {
                $password = $request->input('password');
                if (!Hash::check($password['currentPass'], $init->password)) {
                    $data['response'] = 'Error';
                    $data['Err'] = "Invalid password";
                    return response()->json($data);
                }
                $user['password'] = $password['newPass'];
            }
            $init->update($user);
            if ($request->has('cred')) OfficerCredential::where('user_id', $request->input('id'))->update($officer);

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['Err'] = $e;
        }
        return response()->json($data);
    }

    /* users search */

    public function searchOfficer(Request $request)
    {


        $data = [];
        try {

            $station = $request->has('id') ? $this->dynamic->getUserStation($request->input('id')) : ['response' => false];
            $station = $station['response'] ? $station['station'] : 100;

            $query = User::leftJoin('addresses', 'users.current_address', '=', 'addresses.id')->select([
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.user_name',
                'users.email',
                'users.contact',
            ])->join('officer-credentials', 'users.id', '=', 'officer-credentials.user_id');

            if ($station != 100) $query = $query->where('officer-credentials.station', $station);
            $query = $query->where('users.user_level', '=', '2')
                ->whereNull('users.archived_at')
                ->whereNull('users.deleted_by');

            if ($request->has('search')) {
                $searchTerm = $request->input('search');
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('users.first_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.last_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.user_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.email', 'like', "%{$searchTerm}%")
                        ->orWhere('users.contact', 'like', "%{$searchTerm}%")
                        ->orWhere('users.id', 'like', "%{$searchTerm}%");
                });
            }
            $data['data'] = $query->get();
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['Err'] = $e;
        }
        return response()->json($data);
    }
}
