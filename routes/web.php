<?php


use App\Http\Controllers\CrimeGuardM\CitizenUsersModule;
use App\Http\Controllers\CrimeGuardM\DashboardModule;
use App\Http\Controllers\CrimeGuardM\IncidentModule;
use App\Http\Controllers\CrimeGuardM\LogsModule;
use App\Http\Controllers\CrimeGuardM\NotificationModule;
use App\Http\Controllers\CrimeGuardM\OfficerUsersModule;
use App\Http\Controllers\CrimeGuardM\Requests;
use App\Http\Controllers\CrimeGuardM\TrackUser;
use App\Http\Controllers\CrimeGuardM\TrailLogModule;
use App\Http\Controllers\CrimeGuardM\UserAuths;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test', function () {
     return view('welcome');

});

Route::get('/', function () {
    return view('index');
} );

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/tst', function () {
    return response()->json([
        'stuff' => phpinfo()
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::patch('/update/pic',[UserController::class, 'update'])->name('update.pic');
    // Route::patch('api/get-admin-data', [UserController::class, 'getJsonData'])->name('get.json');
    //Route::get('api/get-addresses', [AddressController::class, 'getJsonData'])->name('get.json.addresses');
    
});


/* Table display */


/* google map markers*/
Route::post('api/incidents/report/marker/Display', [IncidentModule::class, 'incidentReportMarkers'])->name('json');
Route::post('api/incidents/heat/map/marker/Display', [DashboardModule::class, 'heatMap'])->name('json');
Route::post('api/incidents/citizen/heat/map/marker/Display', [DashboardModule::class, 'citizenHeatMap'])->name('json');

/* address display */
Route::post('api/address/request', [CitizenUsersModule::class, 'displayAddress'])->name('json');
Route::post('api/barangay/request', [CitizenUsersModule::class, 'displayBarangay'])->name('json');

/* my account */
Route::post('api/citizen/basic/myaccount/view/request', [CitizenUsersModule::class, 'viewMyAccountBasic'])->name('json');
Route::post('api/citizen/personal/myaccount/view/request', [CitizenUsersModule::class, 'viewMyAccountPersonal'])->name('json');
Route::post('api/citizen/account/myaccount/view/request', [CitizenUsersModule::class, 'viewMyAccountCred'])->name('json');

Route::post('api/citizen/personal/myaccount/update/request', [CitizenUsersModule::class, 'basicUpdate'])->name('json');
/* officer */
Route::post('api/officer/basic/myaccount/view/request', [OfficerUsersModule::class, 'viewMyAccountBasic'])->name('json');
Route::post('api/officer/account/myaccount/view/request', [OfficerUsersModule::class, 'viewMyAccountCred'])->name('json');
Route::post('api/officer/personal/myaccount/view/request', [OfficerUsersModule::class, 'viewPersonal'])->name('json');
Route::post('api/officer/updatebasic/myaccount/update/request', [OfficerUsersModule::class, 'updateBasicData'])->name('json');
Route::post('api/officer/search/request', [OfficerUsersModule::class, 'searchOfficer'])->name('json');


Route::post('api/logs/list/Display', [LogsModule::class, 'listDisplay'])->name('json');
Route::post('api/activity/list/Display', [TrailLogModule::class, 'listDisplay'])->name('json');
Route::post('api/notifications/list/Display', [NotificationModule::class, 'listDisplay'])->name('json');

Route::post('api/notifications/notify/incidentReported/Display', [NotificationModule::class, 'notifyUser'])->name('json');

Route::post('api/notifications/notifed/request', [NotificationModule::class, 'notified'])->name('json');

/* Component Display */
/* dashboard components */
Route::post('api/dashboard/counts/Display', [DashboardModule::class, 'displayCount'])->name('json');
Route::post('api/dashboard/lineraph/generate', [DashboardModule::class, 'generateLine'])->name('json');
Route::post('api/dashboard/generate/reports', [DashboardModule::class, 'displayReports'])->name('json');
Route::post('api/dashboard/generate/emergency/reports', [DashboardModule::class, 'emergencyReports'])->name('json');
Route::get('api/stream-emergency-reports', [DashboardModule::class, 'emergencyReports0']);

Route::post('api/dashboard/generate/victims/gender/pie', [DashboardModule::class, 'victimsPieGender'])->name('json');
Route::post('api/dashboard/generate/victims/age/pie', [DashboardModule::class, 'victimsAge'])->name('json');
/* suspect */
Route::post('api/dashboard/generate/suspects/gender/pie', [DashboardModule::class, 'suspectsPieGender'])->name('json');
Route::post('api/dashboard/generate/suspects/age/pie', [DashboardModule::class, 'suspectsAge'])->name('json');

/* deep filter */
Route::post('api/dashboard/generate/barangay/victim/age/bar', [DashboardModule::class, 'victimsAgeArea'])->name('json');
Route::post('api/dashboard/generate/my/officers', [DashboardModule::class, 'generateOfficerAccounts'])->name('json');

/* dashboard end */

/* Ctitizen side API */
Route::post('api/user/request/registration', [CitizenUsersModule::class, 'requestAccount'])->name('json');

/* incident lists */
Route::get('api/incidents/citizen/view/display', [IncidentModule::class, 'incidentsCitizenDisplay'])->name('json');
Route::post('api/incidents/citizen/view/display2', [IncidentModule::class, 'incidentsCitizenDisplay'])->name('json');

/* report incident */
Route::post('api/incidents/report/request', [IncidentModule::class, 'reportIncident'])->name('json');

/* tracker */
Route::post('api/track/my/location/req', [TrackUser::class, 'add'])->name('json');
Route::post('api/track/location/map/req', [TrackUser::class, 'usermarker'])->name('json');

/* Auths Controller */
Route::post('api/create/reset/token', [UserAuths::class, 'createResetToken']);
Route::post('api/validate/reset/token', [UserAuths::class, 'validateResetToken']);
Route::post('api/my/password/reset', [UserAuths::class, 'resetMyPass']);
Route::post('api/temporary/login/user/request', [UserAuths::class, 'temporaryLogin'])->name('json');

/* Clickable displays */


/* requests */
Route::get('api/request/log/addLog', [LogsModule::class, 'addLog']);
Route::get('api/request/activity/addLog', [TrailLogModule::class, 'addLog']);

/* Incident Secure */
Route::post('api/incident/secure/add/item/request', [Requests::class, 'addIncidentSecured']);

require __DIR__ . '/auth.php';