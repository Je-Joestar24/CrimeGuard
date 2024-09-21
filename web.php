<?php


use App\Http\Controllers\crimeguardm\citizenUsersModule;
use App\Http\Controllers\crimeguardm\dashboardModule;
use App\Http\Controllers\CrimeGUardM\Dynamic\DynamicFunctions;
use App\Http\Controllers\CrimeGuardM\incidentModule;
use App\Http\Controllers\crimeguardm\incidentNamesModule;
use App\Http\Controllers\crimeguardm\logsModule;
use App\Http\Controllers\crimeGuardm\notificationModule;
use App\Http\Controllers\crimeguardm\officerUsersModule;
use App\Http\Controllers\CrimeGuardM\suspectsManipulation;
use App\Http\Controllers\crimeguardm\traillogModule;
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
Route::post('api/temporary/login/user/request', [citizenUsersModule::class, 'temporaryLogin'])->name('json');


/* Table display */


/* Incidents API */
Route::post('api/incidents/archive/table/Display', [incidentModule::class, 'displayArchiveIncidents'])->name('json');
Route::post('api/incidents/table/Display', [incidentModule::class, 'displayIncidents'])->name('json');
Route::post('api/incidents/report/list/Display', [incidentModule::class, 'incidentReportList'])->name('json');
Route::post('api/incidents/reject/messages/list/Display', [incidentModule::class, 'rejectMessages'])->name('json');
Route::post('api/incidents/delete/item/request', [incidentModule::class, 'archive'])->name('json');
Route::post('api/incidents/restore/item/request', [incidentModule::class, 'restore'])->name('json');
Route::post('api/incidents/respond/item/request', [incidentModule::class, 'respond'])->name('json');
Route::post('api/incidents/reject/item/request', [incidentModule::class, 'reject'])->name('json');
Route::post('api/incidents/assign/item/request', [incidentModule::class, 'assignTo'])->name('json');

/* view incidents */
Route::post('api/incidents/view/basic/details/request', [incidentModule::class, 'viewBasic'])->name('json');
Route::post('api/incidents/view/narative/details/request', [incidentModule::class, 'viewNarative'])->name('json');
Route::post('api/incidents/view/suspects/list/request', [incidentModule::class, 'viewSuspects'])->name('json');
Route::post('api/incidents/view/witness/list/request', [incidentModule::class, 'viewWitness'])->name('json');
Route::post('api/incidents/view/victim/list/request', [incidentModule::class, 'viewVictims'])->name('json');
/* Add incident */
Route::post('api/incidents/add/item/request', [incidentModule::class, 'addIncident'])->name('json');
Route::post('api/incidents/edit/item/request', [incidentModule::class, 'editDisplayData'])->name('json');
Route::post('api/incidents/update/item/request', [incidentModule::class, 'update'])->name('json');
Route::post('api/suspect/search/Display', [suspectsManipulation::class, 'search'])->name('json');
Route::post('api/victims/search/Display', [victimsModule::class, 'search'])->name('json');
Route::post('api/witness/search/Display', [witnessModule::class, 'search'])->name('json');
Route::post('api/incidentNames/search/Display', [incidentNamesModule::class, 'search'])->name('json');
/* REPORTS */
Route::post('api/incidents/generate/statistical/report', [incidentModule::class, 'generateReport'])->name('json');
Route::post('api/accounts/generate/statistical/report', [citizenUsersModule::class, 'accountRequestDisplay'])->name('json');
/* Narrative */
Route::post('api/dashboard/lineraph/filtered/generate', [dashboardModule::class, 'generateLine'])->name('json');
Route::post('api/dashboard/lineraph/predict/generate', [dashboardModule::class, 'generatePredictedLine'])->name('json');
Route::post('api/dashboard/generate/incident/top/barangay/bar', [dashboardModule::class, 'topBarangays'])->name('json');
Route::post('api/check/address', [dashboardModule::class, 'findBarangay'])->name('json');
Route::post('api/dashboard/report/change/rank', [dashboardModule::class, 'rankChangeReports'])->name('json');
Route::post('api/dashboard/report/transfer/station', [dashboardModule::class, 'areaTransferReports'])->name('json');

/* google map markers*/
Route::get('api/incidents/report/marker/Display', [incidentModule::class, 'incidentReportMarkers'])->name('json');
Route::post('api/incidents/heat/map/marker/Display', [dashboardModule::class, 'heatMap'])->name('json');
Route::post('api/incidents/citizen/heat/map/marker/Display', [dashboardModule::class, 'citizenHeatMap'])->name('json');

/* Susepcts API */
Route::post('api/suspect/table/Display', [suspectsManipulation::class, 'tableDisplay'])->name('json');
Route::post('api/suspect/archive/table/Display', [suspectsManipulation::class, 'archiveTableDisplay'])->name('json');
Route::post('api/suspects/delete/item/request', [suspectsManipulation::class, 'archive'])->name('json');
Route::post('api/suspects/restore/item/request', [suspectsManipulation::class, 'restore'])->name('json');

/* VIew */
Route::post('api/suspects/view/basic/details/request', [suspectsManipulation::class, 'viewSuspect'])->name('json');
Route::post('api/suspects/view/addresses/details/request', [suspectsManipulation::class, 'viewAddresses'])->name('json');
Route::post('api/suspects/view/records/details/request', [suspectsManipulation::class, 'viewRecords'])->name('json');
Route::post('api/suspects/view/physical_characteristics/details/request', [suspectsManipulation::class, 'viewPhysical'])->name('json');
Route::post('api/suspects/view/backgorund_info/details/request', [suspectsManipulation::class, 'viewBackgroundInfo'])->name('json');
Route::post('api/suspects/view/prevVictims/details/request', [suspectsManipulation::class, 'viewVictims'])->name('json');
/* add */
Route::post('api/suspects/add/item/request', [suspectsManipulation::class, 'addSuspect'])->name('json');
Route::post('api/suspects/edit/item/request', [suspectsManipulation::class, 'editDisplayData'])->name('json');
Route::post('api/suspects/update/item/request', [suspectsManipulation::class, 'update'])->name('json');

/* Victims API */
Route::post('api/victims/table/Display', [victimsModule::class, 'tableDisplay'])->name('json');
Route::post('api/victims/archive/table/Display', [victimsModule::class, 'archiveTableDisplay'])->name('json');
Route::post('api/victims/delete/item/request', [victimsModule::class, 'archive'])->name('json');
Route::post('api/victims/restore/item/request', [victimsModule::class, 'restore'])->name('json');
// View
Route::post('api/victims/view/basic/details/request', [victimsModule::class, 'viewVictim'])->name('json');
Route::post('api/victims/view/addresses/details/request', [victimsModule::class, 'viewAddresses'])->name('json');
Route::post('api/victims/view/records/details/request', [victimsModule::class, 'viewRecords'])->name('json');
//add
Route::post('api/victims/add/item/request', [victimsModule::class, 'addVictim'])->name('json');
Route::post('api/victims/edit/item/request', [victimsModule::class, 'editDisplayData'])->name('json');
Route::post('api/victims/update/item/request', [victimsModule::class, 'update'])->name('json');


/* Witness API */
Route::post('api/witness/table/Display', [witnessModule::class, 'tableDisplay'])->name('json');
Route::post('api/witness/archive/table/Display', [witnessModule::class, 'archiveTableDisplay'])->name('json');
Route::post('api/witness/delete/item/request', [witnessModule::class, 'archive'])->name('json');
Route::post('api/witness/restore/item/request', [witnessModule::class, 'restore'])->name('json');
Route::post('api/witness/view/basic/details/request', [witnessModule::class, 'viewWitness'])->name('json');
Route::post('api/witness/view/addresses/details/request', [witnessModule::class, 'viewAddresses'])->name('json');
Route::post('api/witness/view/records/details/request', [witnessModule::class, 'viewRecords'])->name('json');
//add
Route::post('api/witness/add/item/request', [witnessModule::class, 'addWitness'])->name('json');
Route::post('api/witness/edit/item/request', [witnessModule::class, 'editDisplayData'])->name('json');
Route::post('api/witness/update/item/request', [witnessModule::class, 'update'])->name('json');

/* Accounts api */
Route::post('api/citizenUsers/table/Display', [citizenUsersModule::class, 'tableDisplay'])->name('json');
Route::post('api/citizenUsers/account/request/list/Display', [citizenUsersModule::class, 'registrationRequests'])->name('json');
Route::post('api/citizenUsers/archive/table/Display', [citizenUsersModule::class, 'archiveTableDisplay'])->name('json');
Route::post('api/officerUsers/table/Display', [officerUsersModule::class, 'tableDisplay'])->name('json');
Route::post('api/citizenUsers/view/basic/details/request', [citizenUsersModule::class, 'viewBasic'])->name('json');
Route::post('api/users/delete/item/request', [citizenUsersModule::class, 'archive'])->name('json');
Route::post('api/users/restore/item/request', [citizenUsersModule::class, 'restore'])->name('json');
Route::post('api/users/accept/item/request', [citizenUsersModule::class, 'acceptAccount'])->name('json');
Route::post('api/users/view/addresses/details/request', [citizenUsersModule::class, 'viewAddresses'])->name('json');
/* add account */
Route::post('api/citizenusers/add/item/request', [citizenUsersModule::class, 'addCitizen'])->name('json');
Route::post('api/officerusers/add/item/request', [officerUsersModule::class, 'addUser'])->name('json');
/* edit account */
Route::post('api/citizenusers/edit/item/request', [citizenUsersModule::class, 'editDisplayData'])->name('json');
Route::post('api/officerusers/edit/item/request', [officerUsersModule::class, 'editDisplayData'])->name('json');
/* update account */
Route::post('api/citizenusers/update/item/request', [citizenUsersModule::class, 'update'])->name('json');
Route::post('api/officerusers/update/item/request', [officerUsersModule::class, 'update'])->name('json');
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

/* Incident Names API */
Route::post('api/incidentNames/table/Display', [incidentNamesModule::class, 'tableDisplay'])->name('json');
Route::post('api/incidentNames/delete/item/request', [incidentNamesModule::class, 'archive'])->name('json');
//Add
Route::post('api/incidentNames/add/item/request', [incidentNamesModule::class, 'addIncidentName'])->name('json');
Route::post('api/incidentNames/edit/item/request', [incidentNamesModule::class, 'editDisplayData'])->name('json');
Route::post('api/incidentNames/update/item/request', [incidentNamesModule::class, 'update'])->name('json');


Route::post('api/logs/list/Display', [logsModule::class, 'listDisplay'])->name('json');
Route::post('api/activity/list/Display', [traillogModule::class, 'listDisplay'])->name('json');
Route::get('api/notifications/list/Display', [notificationModule::class, 'listDisplay'])->name('json');

/* Component Display */
/* dashboard components */
Route::get('api/dashboard/counts/Display', [dashboardModule::class, 'displayCount'])->name('json');
Route::get('api/dashboard/lineraph/generate', [dashboardModule::class, 'generateLine'])->name('json');
Route::get('api/dashboard/generate/reports', [dashboardModule::class, 'displayReports'])->name('json');
Route::post('api/dashboard/generate/emergency/reports', [dashboardModule::class, 'emergencyReports'])->name('json');
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

/* Clickable displays */

/* requests */
Route::get('api/request/log/addLog', [logsModule::class, 'addLog']);
Route::get('api/request/activity/addLog', [traillogModule::class, 'addLog']);

require __DIR__ . '/auth.php';
