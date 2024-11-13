<?php

namespace App\Http\Controllers\crimeguardm;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CrimeGUardM\Dynamic\DynamicFunctions;
use App\Mail\AccountAcceptedMail;
use App\Mail\AccountRejectedMail;
use App\Models\Addresses;
use App\Models\CitizenCredentials;
use App\Models\Logs;
use App\Models\OfficerCredential;
use App\Models\TrailLog;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\throwException;

class citizenUsersModule extends Controller
{

    //

    protected $dynamic;

    public function __construct(DynamicFunctions $dynamic)
    {
        $this->dynamic = $dynamic;
    }

    /* Table Management Display */
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
            'current address',
        ];

        try {

            /* table data */
            $query = User::leftJoin('addresses', 'users.current_address', '=', 'addresses.id')
                ->leftJoin('citizen-credentials as cc', 'cc.user_id', '=', 'users.id')
                ->select([
                    'users.id',
                    'users.profile',
                    'users.first_name',
                    'users.last_name',
                    'users.user_name',
                    'users.email',
                    'users.contact',
                    DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city) AS cur_address'),
                ])
                ->where('users.user_level', '=', '3')
                ->where('users.accepted_by', '!=', NULL)
                ->whereNull('users.archived_at')
                ->whereNull('cc.rejected_by')
                ->whereNull('users.deleted_by');

            /* Apply search if provided */
            if ($request->has('search') && !empty($request->input('search'))) {
                $searchTerm = $request->input('search');
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('users.first_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.last_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.user_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.email', 'like', "%{$searchTerm}%")
                        ->orWhere('users.contact', 'like', "%{$searchTerm}%")
                        ->orWhere(DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city)'), 'like', "%{$searchTerm}%");
                });
            }

            /* Execute query and fetch data */
            $data['table']['data'] = $query->get();
            $data['response'] = 'Success';
            $data['table']['type'] = 1;
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function accountRequestDisplay(Request $request)
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

            /* table data */
            $query = User::leftJoin('citizen-credentials as cc', 'cc.user_id', '=', 'users.id')
                ->select([
                    'users.first_name',
                    'users.last_name',
                    'users.user_name',
                    'users.email',
                    'users.contact',
                ])
                ->where('users.user_level', '=', '3');
            if ($request->has('status')) {
                $status = $request->input('status');
                if ($status == 'accepted') {
                    $query = $query->whereNull('users.archived_at')
                        ->whereNull('users.deleted_by')
                        ->where('users.accepted_at', '!=', NULL)
                        ->where('users.accepted_by', '!=', NULL);
                } else if ($status == 'rejected') {
                    $query = $query->where('users.archived_at', '!=', NULL)
                        ->where('users.deleted_by', '!=', NULL)
                        ->whereNull('users.accepted_by')
                        ->whereNull('users.accepted_at');
                } else if ($status == 'request') {
                    $query = $query->whereNull('users.archived_at')
                        ->whereNull('users.deleted_by')
                        ->whereNull('users.accepted_by')
                        ->whereNull('users.accepted_at');
                }
            }
            if ($request->has('date_start') && $request->input('date_start')) {
                $query = $query->where('users.created_at', '>=', $request->input('date_start') . (" " . ($request->input('time_start') ? $request->input('time_start') . ":00" : explode(' ', $defaultDate)[1])));
            }

            if ($request->has('date_end') && $request->input('date_end')) {
                $query = $query->where('users.created_at', '<=', $request->input('date_end') . (" " . ($request->input('time_end') ? $request->input('time_end') . ":00" : explode(' ', $defaultDate)[1])));
            }
            $stationInfo = OfficerCredential::join('police-station', 'officer-credentials.station', 'police-station.id')
                ->select('police-station.name', 'police-station.location')
                ->where('officer-credentials.user_id', $request->id)
                ->first();

            $data['station'] = $stationInfo;
            /* Execute query and fetch data */
            $data['table']['data'] = $query->get();
            $data['response'] = 'Success';
            $data['table']['type'] = 1;
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function displayAddress(Request $request)
    {
        $data = [];

        try {
            // Validate the 'selected' parameter
            $selected = $request->input('selected');
            if (!is_array($selected)) {
                throw new \Exception('Invalid "selected" parameter.');
            }

            /* table data */
            $query = Addresses::select($selected)->distinct();

            if ($this->dynamic->doestKeyExists($request, 'search')) {
                $searchTerm = $request['search'];
                $query->where(function ($q) use ($searchTerm, $selected) {
                    $q->where('province', 'like', "%{$searchTerm['province']}%");
                    if ($searchTerm['city'] || in_array('city', $selected)) {
                        $q->where('city', 'like', "%{$searchTerm['city']}%");
                    }
                    if ($searchTerm['block'] || in_array('block', $selected)) {
                        $q->where('block', 'like', "%{$searchTerm['block']}%");
                    }
                    if ($searchTerm['street'] || in_array('street', $selected)) {
                        $q->where('street', 'like', "%{$searchTerm['street']}%");
                    }
                    if ($searchTerm['house_number'] || in_array('house_number', $selected)) {
                        $q->where('house_number', 'like', "%{$searchTerm['house_number']}%");
                    }
                    if ($searchTerm['village'] || in_array('village', $selected)) {
                        $q->where('village', 'like', "%{$searchTerm['village']}%");
                    }
                    if ($searchTerm['barangay'] || in_array('barangay', $selected)) {
                        $q->where('barangay', 'like', "%{$searchTerm['barangay']}%");
                    }
                    if ($searchTerm['sitio'] || in_array('sitio', $selected)) {
                        $q->where('sitio', 'like', "%{$searchTerm['sitio']}%");
                    }
                });
            }

            /* Execute query and fetch data */
            $tempo = $this->dynamic->removeNuls($query->get()->toArray(), $selected[0]);
            $data['data'] = $this->dynamic->convertArrayByKey($tempo, $selected[0]);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e->getMessage();
        }

        return response()->json($data);
    }

    public function displayBarangay(Request $request)
    {
        $data = [];

        try {
            // Validate the 'selected' parameter
            if ($request->has('search')) {
                $search = $request->input('search');
                $query = Addresses::select(['barangay'])->distinct()->where('barangay', 'like', "%{$search}%");
            }

            $tempo = $this->dynamic->removeNuls($query->get()->toArray(), 'barangay');
            $data['data'] = $this->dynamic->convertArrayByKey($tempo, 'barangay');
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e->getMessage();
        }

        return response()->json($data);
    }
    /* For requesting account */
    public function requestAccount(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $data = [];

        $currentAddress = $request['current_address'];
        $otherAddress = $request['other_address'];


        $citizenCredentials = [
            'valid_id' => $request['valid_id'],
            'fb_name' => $request['fb_name'],
            'date_request' => $currentDate->format('Y-m-d')
        ];

        /* F */
        $user = [
            'email' => $request['email'],
            'user_name' => $request['user_name'],
            'gender' => $request['gender'],
            'contact' => $request['contact'],
            'last_name' => $request['last_name'],
            'first_name' => $request['first_name'],
            'middle_name' => $request['middle_name'],
            'password' => $request['password'],
            'user_level' => 3,
            'profile' => $request['profile']
        ];

        try {
            $current_id = $this->dynamic->nulled($currentAddress) ? null : $this->dynamic->getId(Addresses::class, $currentAddress);
            if ($current_id == -1) $current_id = $this->dynamic->addItem(Addresses::class, $currentAddress);

            $other_id = $this->dynamic->nulled($otherAddress) ? null : $this->dynamic->getId(Addresses::class, $otherAddress);
            if ($other_id == -1) $other_id = $this->dynamic->addItem(Addresses::class, $otherAddress);

            $user['current_address'] = $current_id;
            $user['other_address'] = $other_id;


            /* for checking the user's email, contact or user_name already exists */
            $user_id = $this->isUserUnique($user);


            if ($user_id != -1) {
                $data['response'] = 'Error';
                $data['err'] = 'User Already Exists';
                return response()->json($data);
            } else {
                User::create($user);
                $user_id = $this->isUserUnique($user);
                $citizenCredentials['user_id'] = $user_id;
                $citizenCredentials['valid_id'] = $request['valid_id'];
                CitizenCredentials::create($citizenCredentials);
                $data['response'] = 'Success';
            }
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function addCitizen(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $data = [];
        $user = $request['user'];
        $user['user_level'] = 3;
        $user_credentials = $request['citizen_credentials'];
        $current_address = $request['current_address'];
        $other_address = $request['other_address'];
        try {
            $user['accepted_at'] = $currentDate->format('Y-m-d H:i:s');

            $user_credentials['date_request'] = $currentDate->format('Y-m-d');
            $user_credentials['accepted_date'] = $this->dynamic->doestKeyExists($user_credentials, 'accepted_by') ? $currentDate->format('Y-m-d') : NULL;

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
                $this->dynamic->addItem(CitizenCredentials::class, $user_credentials);
            }

            TrailLog::create(['user_id' => $request->input('id'), 'action' => 'added', 'item' => 'citizen account']);
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
            $citizen = User::select('last_name', 'first_name', 'middle_name', 'gender',  'email', 'contact', 'profile', 'current_address', 'other_address')->find($request['id']);
            $citizenCredits = CitizenCredentials::select('fb_name', 'valid_id')->where('user_id', $request['id'])->first();

            if ($citizenCredits) {
                $citizen = $this->dynamic->insertBeforeKey($citizen->toArray(), ['fb_name' => $citizenCredits['fb_name']], 'email');
                $citizen = $this->dynamic->insertBeforeKey($citizen, ['valid_id' => $citizenCredits['valid_id']], 'profile');
            } else {
                $citizen = $this->dynamic->insertBeforeKey($citizen->toArray(), ['fb_name' => NULL], 'email');
                $citizen = $this->dynamic->insertBeforeKey($citizen, ['valid_id' => NULL], 'profile');
            }

            $account = User::select('user_name')->find($request['id']);
            if ($citizen['current_address']) $current_address = Addresses::select('street', 'village', 'barangay', 'city', 'province')->find($citizen['current_address']);
            if ($citizen['other_address']) $other_address = Addresses::select('street', 'village', 'barangay', 'city', 'province')->find($citizen['other_address']);


            unset($citizen['other_address']);
            unset($citizen['current_address']);
            $data['data']['suspect'] = $citizen;
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

        $data = [];
        $user = $request['user'];
        $user['user_level'] = 3;
        $user_credentials = $request['citizen_credentials'];
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
            $user_credentials['user_id'] = $user['id'];
            $credC = CitizenCredentials::where('user_id', $user['id'])->first();
            if ($credC) $credC->update($user_credentials);
            else CitizenCredentials::create($user_credentials);

            TrailLog::create(['user_id' => $request->input('id'), 'action' => 'edited', 'item' => 'citizen account']);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['Err'] = $e;
        }
        return response()->json($data);
    }

    private function addressInsert($param)
    {
        Addresses::create($param);
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

    /* Account Registration Request */
    public function registrationRequests(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();

        $data['data'] = [];
        try {
            $citizens = User::leftJoin('addresses', 'users.current_address', '=', 'addresses.id')
                ->select(
                    'users.id',
                    'users.first_name',
                    'users.last_name',
                    'users.email',
                    'users.created_at',
                    'users.profile',
                    DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city) AS cur_address'),
                )

                ->where('users.accepted_at', '=', NULL)
                ->where('users.accepted_by', '=', NULL)
                ->whereNull('users.archived_at')
                ->whereNull('users.deleted_by')
                ->where('users.user_level', '=', '3');

            if ($request->has('search') && !empty($request->input('search'))) {
                $searchTerm = $request->input('search');
                $citizens = $citizens->where(function ($q) use ($searchTerm) {
                    $q->where('users.first_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.last_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.user_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.email', 'like', "%{$searchTerm}%")
                        ->orWhere('users.contact', 'like', "%{$searchTerm}%")
                        ->orWhere(DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city)'), 'like', "%{$searchTerm}%");
                });
            }

            $citizens = $citizens->get();
            foreach ($citizens as $citizen) {
                $cleaned = [
                    'id' => $citizen['id'],
                    'profile' => $citizen['profile'],
                    'first_name' => $citizen['first_name'],
                    'last_name' => $citizen['last_name'],
                    'email' => $citizen['email'],
                    'address' => $citizen['cur_address'],
                    'time' => explode(' ', $citizen['created_at'])[1],
                    'month' => explode('-', explode(' ', $citizen['created_at'])[0])[1],
                    'date' => explode('-', explode(' ', $citizen['created_at'])[0])[2] . ', ' . explode('-', explode(' ', $citizen['created_at'])[0])[0],
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

    /* Archived Accounts Display */
    public function archiveTableDisplay(Request $request)
    {

        $data = [];
        /* Table headers */
        $data['table']['headers'] = [
            'id',
            'last name',
            'firstname',
            'user name',
            'email address',
            'phone no.',
            'current address',
            'deleted by',
            'date deleted',
            'time deleted'
        ];
        $data['table']['data'] = [];

        try {
            /* table data */
            $users = User::leftJoin('addresses', 'users.current_address', '=', 'addresses.id')
                ->leftJoin('users as user', 'users.deleted_by', '=', 'user.id')->select([
                    'users.id',
                    'users.first_name',
                    'users.last_name',
                    'users.user_name',
                    'users.email',
                    'users.contact',
                    'user.user_name as un',
                    'users.archived_at',
                    DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city) AS cur_address'),
                ])
                ->where('users.user_level', '!=', '1')
                ->where('users.archived_at', 'IS NOT', NULL)
                ->where('users.deleted_by', 'IS NOT', NULL);


            if ($request->has('search') && !empty($request->input('search'))) {
                $searchTerm = $request->input('search');
                $users->where(function ($q) use ($searchTerm) {
                    $q->where('users.first_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.last_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.user_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users.email', 'like', "%{$searchTerm}%")
                        ->orWhere('users.contact', 'like', "%{$searchTerm}%")
                        ->orWhere('users.id', 'like', "%{$searchTerm}%")
                        ->orWhere(DB::raw('CONCAT(addresses.street, ", ", addresses.barangay, ", ", addresses.city)'), 'like', "%{$searchTerm}%");
                });
            }
            $users = $users->get();


            foreach ($users as $user) {
                $cleaned = [
                    'id' => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'user_name' => $user['user_name'],
                    'email' => $user['email'],
                    'contact' => $user['contact'],
                    'un' => $user['un'],
                    'cur_address' => $user['cur_address'],
                    'date_deleted' => explode(' ', $user['archived_at'])[0],
                    'time_deleted' => explode(' ', $user['archived_at'])[1]

                ];
                array_push($data['table']['data'], $cleaned);
            }

            $data['response'] = 'Success';
            $data['table']['type'] = 0;
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function viewBasic(Request $request)
    {

        try {
            $users = User::select([
                'profile',
                'first_name',
                'last_name',
                'user_name',
                'middle_name',
                'gender',
                'email',
                'contact',
            ])->find($request['id']);

            $user_credentials = CitizenCredentials::select('fb_name', 'valid_id')->where('user_id', $request['id'])->first();
            if ($this->dynamic->doestKeyExists($user_credentials, 'fb_name')) $users['fb_name'] = $user_credentials['fb_name'];
            if ($this->dynamic->doestKeyExists($user_credentials, 'valid_id')) $users['valid_id'] = $user_credentials['valid_id'];
            $officer_credentials = OfficerCredential::join('police-station', 'officer-credentials.station', '=', 'police-station.id')
                ->select('officer-credentials.rank', 'police-station.name')
                ->where('officer-credentials.user_id', $request['id'])
                ->first();

            if ($this->dynamic->doestKeyExists($officer_credentials, 'rank')) {
                $users['rank'] = $officer_credentials['rank'];
            }
            $data['data'] = $users;

            /* 
            $data['data'] = [
                'last_name' => $users['lastname'],
                'first_name' => $users['firstname'],
                'middle_name' => $users['middlename'],
                'age' => $users['age'],
                'gender' => $users['gender'],
                'nick_name' => $users['nickname'],
                'facebook' => $users['fb_account'],
                'email' => $users['email'],
                'telephone' => $users['home_phone'],
                'contact' => $users['mobile_phone'],
                'under_influence' => $users['under_influence_of'],
                'civil_status' => $users['civil_status']
            ]; */

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    public function archive(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $currentDate = new DateTime();
        $data = [];

        try {
            $user = User::find($request['id']);

            $archive = [
                'archived_at' => $currentDate->format('Y-m-d H:i:s'),
                'deleted_by' => $request['archived_by']
            ];
            $user->update($archive);

            if ($request->input('user_id') != null && $request->has('user_id')) {
                TrailLog::create([
                    'user_id' => $request->input('archived_by'),
                    'action' => 'deleted',
                    'item' => 'account'
                ]);
            }

            if (is_null($user->accepted_at) || is_null($user->accepted_by)) {
                Mail::to($user->email)->send(new AccountRejectedMail($user));

                $data['response'] = 'Success';
            } else {
                $data['response'] = 'Success';
            }
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e->getMessage();
        }

        return response()->json($data);
    }

    /* Restore archived data */
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
            User::where('id', $request['id'])->update($archive);
            TrailLog::create(['user_id' => $request->input('user_id'), 'action' => 'restored', 'item' => 'account']);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }
        return response()->json($data);
    }


    /* Restore archived data */
    public function acceptAccount(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $data = [];

        try {
            $user = User::findOrFail($request['id']);

            $user->update([
                'accepted_at' => $currentDate->format('Y-m-d H:i:s'),
                'accepted_by' => $request['accepted_by']
            ]);

            Mail::to($user->email)->send(new AccountAcceptedMail($user));
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

            $data['data'] = User::leftJoin('addresses as current', 'users.current_address', '=', 'current.id')
                ->leftJoin('addresses as other', 'users.other_address', '=', 'other.id')
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
                // ->where('users.archived_at', '=', NULL)
                // ->where('users.deleted_by', '=', NULL)
                ->find($request['id']);

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }

    /* citizen's account viewer */

    public function viewMyAccountBasic(Request $request)
    {

        $data = [];

        try {

            $data['data'] = User::select('user_name', 'email', 'contact', 'profile')
                ->find($request['id']);

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e;
        }

        return response()->json($data);
    }


    public function viewMyAccountPersonal(Request $request)
    {

        $data = [];

        try {

            $data['data'] = User::select('first_name', 'last_name', 'email', 'contact')
                ->find($request['id']);

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


    public function basicUpdate(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $data = [];
        $user = $request->input('data');
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

            $cred = CitizenCredentials::where('user_id', $request->input('id'))->first();
            if ($cred) $cred->update(['edited_by' => $request->input('id')]);

            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['Err'] = $e;
        }
        return response()->json($data);
    }
    /* Fix */

    public function temporaryLogin(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $data = [];
        $data = [];
        try {
            $user = $request->input('user');
            $password = $request->input('password');

            $init = User::where('user_name', $user)
                ->orWhere('email', $user)
                ->first(['id', 'user_level', 'password']);
            $initClone = clone $init;

            if ($initClone['user_level'] == 3) {
                $user = User::select('accepted_at', 'accepted_by')
                    ->find($initClone->id);
                if (($user['accepted_at'] == NULL) || ($user['accepted_by'] == NULL)) {
                    $data['ambot'] = $user;
                    $data['response'] = 'Error';
                    $data['Err'] = 'User not found';
                    return response()->json($data);
                }
            }
            if (!$init) {
                $data['response'] = 'Error';
                $data['Err'] = 'User not found';
                return response()->json($data);
            }

            if ($request->has('password')) {
                if (!Hash::check($password, $init->password)) {
                    $data['response'] = 'Error';
                    $data['Err'] = 'No match found!';
                    return response()->json($data);
                }
                $data['data'] = $init->only(['id', 'user_level']);
                $data['response'] = 'Success';
                /* new */

                if ($data['data']['user_level'] < 3) Logs::create(['officer_id' => $data['data']['id'], 'login' => $currentDate->format('Y-m-d H:i:s')]);
                return response()->json($data);
            } else {
                $data['response'] = 'Error';
                $data['Err'] = 'Password is required';
                return response()->json($data);
            }
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['Err'] = $e->getMessage();
            return response()->json($data);
        }
    }
}
