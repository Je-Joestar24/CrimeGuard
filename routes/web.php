<?php


use App\Http\Controllers\crimeguardm\citizenUsersModule;
use App\Http\Controllers\crimeguardm\dashboardModule;
use App\Http\Controllers\CrimeGUardM\Dynamic\DynamicFunctions;
use App\Http\Controllers\CrimeGuardM\incidentModule;
use App\Http\Controllers\crimeguardm\incidentNamesModule;
use App\Http\Controllers\crimeguardm\logsModule;
use App\Http\Controllers\crimeGuardm\notificationModule;
use App\Http\Controllers\crimeguardm\officerUsersModule;
use App\Http\Controllers\crimeguardm\predictiveAnalytics;
use App\Http\Controllers\CrimeGuardM\suspectsManipulation;
use App\Http\Controllers\CrimeGuardM\trackuser;
use App\Http\Controllers\crimeguardm\traillogModule;
use App\Http\Controllers\CrimeGuardM\userAuths;
use App\Http\Controllers\CrimeGuardM\victimsModule;
use App\Http\Controllers\crimeguardm\witnessModule;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\DB;
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


Route::post('api/file/upload', [DynamicFunctions::class, 'upload'])->name('file.upload');

/* Table display */


/* google map markers*/
Route::get('api/incidents/report/marker/Display', [incidentModule::class, 'incidentReportMarkers'])->name('json');
Route::post('api/incidents/heat/map/marker/Display', [dashboardModule::class, 'heatMap'])->name('json');
Route::post('api/incidents/citizen/heat/map/marker/Display', [dashboardModule::class, 'citizenHeatMap'])->name('json');

/* address display */
Route::post('api/address/request', [citizenUsersModule::class, 'displayAddress'])->name('json');
Route::post('api/barangay/request', [citizenUsersModule::class, 'displayBarangay'])->name('json');

/* my account */
Route::post('api/citizen/basic/myaccount/view/request', [citizenUsersModule::class, 'viewMyAccountBasic'])->name('json');
Route::post('api/citizen/personal/myaccount/view/request', [citizenUsersModule::class, 'viewMyAccountPersonal'])->name('json');
Route::post('api/citizen/account/myaccount/view/request', [citizenUsersModule::class, 'viewMyAccountCred'])->name('json');

Route::post('api/citizen/personal/myaccount/update/request', [citizenUsersModule::class, 'basicUpdate'])->name('json');
/* officer */
Route::post('api/officer/basic/myaccount/view/request', [officerUsersModule::class, 'viewMyAccountBasic'])->name('json');
Route::post('api/officer/account/myaccount/view/request', [officerUsersModule::class, 'viewMyAccountCred'])->name('json');
Route::post('api/officer/personal/myaccount/view/request', [officerUsersModule::class, 'viewPersonal'])->name('json');
Route::post('api/officer/updatebasic/myaccount/update/request', [officerUsersModule::class, 'updateBasicData'])->name('json');
Route::post('api/officer/search/request', [officerUsersModule::class, 'searchOfficer'])->name('json');


Route::post('api/logs/list/Display', [logsModule::class, 'listDisplay'])->name('json');
Route::post('api/activity/list/Display', [traillogModule::class, 'listDisplay'])->name('json');
Route::post('api/notifications/list/Display', [notificationModule::class, 'listDisplay'])->name('json');

Route::post('api/notifications/notify/incidentReported/Display', [notificationModule::class, 'notifyUser'])->name('json');

Route::post('api/notifications/notifed/request', [notificationModule::class, 'notified'])->name('json');

/* Component Display */
/* dashboard components */
Route::get('api/dashboard/counts/Display', [dashboardModule::class, 'displayCount'])->name('json');
Route::get('api/dashboard/lineraph/generate', [dashboardModule::class, 'generateLine'])->name('json');
Route::get('api/dashboard/generate/reports', [dashboardModule::class, 'displayReports'])->name('json');
Route::post('api/dashboard/generate/emergency/reports', [dashboardModule::class, 'emergencyReports'])->name('json');
Route::get('api/stream-emergency-reports', [dashboardModule::class, 'emergencyReports0']);

Route::post('api/dashboard/generate/victims/gender/pie', [dashboardModule::class, 'victimsPieGender'])->name('json');
Route::post('api/dashboard/generate/victims/age/pie', [dashboardModule::class, 'victimsAge'])->name('json');
/* suspect */
Route::post('api/dashboard/generate/suspects/gender/pie', [dashboardModule::class, 'suspectsPieGender'])->name('json');
Route::post('api/dashboard/generate/suspects/age/pie', [dashboardModule::class, 'suspectsAge'])->name('json');

/* deep filter */
Route::post('api/dashboard/generate/barangay/victim/age/bar', [dashboardModule::class, 'victimsAgeArea'])->name('json');
Route::post('api/dashboard/generate/my/officers', [dashboardModule::class, 'generateOfficerAccounts'])->name('json');

/* dashboard end */

/* Ctitizen side API */
Route::post('api/user/request/registration', [citizenUsersModule::class, 'requestAccount'])->name('json');

/* incident lists */
Route::get('api/incidents/citizen/view/display', [incidentModule::class, 'incidentsCitizenDisplay'])->name('json');
Route::post('api/incidents/citizen/view/display2', [incidentModule::class, 'incidentsCitizenDisplay'])->name('json');

/* report incident */
Route::post('api/incidents/report/request', [incidentModule::class, 'reportIncident'])->name('json');

/* tracker */
Route::post('api/track/my/location/req', [trackuser::class, 'add'])->name('json');
Route::post('api/track/location/map/req', [trackuser::class, 'usermarker'])->name('json');

/* Auths Controller */
Route::post('api/create/reset/token', [userAuths::class, 'createResetToken']);
Route::post('api/validate/reset/token', [userAuths::class, 'validateResetToken']);
Route::post('api/my/password/reset', [userAuths::class, 'resetMyPass']);
Route::post('api/temporary/login/user/request', [userAuths::class, 'temporaryLogin'])->name('json');

/* Clickable displays */

/* requests */
Route::get('api/request/log/addLog', [logsModule::class, 'addLog']);
Route::get('api/request/activity/addLog', [traillogModule::class, 'addLog']);

require __DIR__ . '/auth.php';
