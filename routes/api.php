<?php

use App\Http\Controllers\CrimeGuardM\CitizenUsersModule;
use App\Http\Controllers\CrimeGuardM\DashboardModule;
use App\Http\Controllers\CrimeGuardM\Dynamic\DynamicFunctions;
use App\Http\Controllers\CrimeGuardM\IncidentModule;
use App\Http\Controllers\CrimeGuardM\IncidentNamesModule;
use App\Http\Controllers\CrimeGuardM\OfficerUsersModule;
use App\Http\Controllers\CrimeGuardM\PredictiveAnalytics;
use App\Http\Controllers\CrimeGuardM\SuspectsManipulation;
use App\Http\Controllers\CrimeGuardM\VictimsModule;
use App\Http\Controllers\CrimeGuardM\WitnessModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('file/upload', [DynamicFunctions::class, 'upload'])->name('file.upload');

Route::middleware('auth:sanctum')->get('/check-token', function (Request $request) {
    // You don't need to pass the user explicitly
    // $request->user() gives you the authenticated user from the token
    return response()->json([
        'message' => 'Token is valid',
        'user' => $request->user(), // Automatically retrieved user
    ], 200);
});

Route::post('dashboard/generate/incident/top/barangay/bar', [DashboardModule::class, 'topBarangays']);

Route::middleware('auth:sanctum', 'checkUserLevel:1')->get('/check-level-1', function (Request $request) {
    return response()->json([
        'message' => true,
        'user' => $request->user(),
        'level' => 1
    ], 200);
});

Route::middleware('auth:sanctum', 'checkUserLevel:2')->get('/check-level-2', function (Request $request) {
    return response()->json([
        'message' => true,
        'user' => $request->user(),
        'level' => 2
    ], 200);
});

Route::middleware('auth:sanctum', 'checkUserLevel:3')->get('/check-level-3', function (Request $request) {
    return response()->json([
        'message' => true,
        'user' => $request->user(), 
        'level' => 3
    ], 200);
});

Route::middleware('auth:sanctum', 'checkUserLevel:4')->get('/check-level-4', function (Request $request) {
    return response()->json([
        'message' => true,
        'user' => $request->user(),
        'level' => 4
    ], 200);
});

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    // Revoke the current user’s token
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Logged out successfully'], 200);
});

/* ADMIN */
Route::middleware('auth:sanctum', 'checkUserLevel:1')->group(function () {


    /* Accounts api */
    Route::post('citizenUsers/table/Display', [CitizenUsersModule::class, 'tableDisplay'])->name('json');
    Route::post('citizenUsers/account/request/list/Display', [CitizenUsersModule::class, 'registrationRequests'])->name('json');
    Route::post('citizenUsers/archive/table/Display', [CitizenUsersModule::class, 'archiveTableDisplay'])->name('json');
    Route::post('officerUsers/table/Display', [OfficerUsersModule::class, 'tableDisplay'])->name('json');
    Route::post('citizenUsers/view/basic/details/request', [CitizenUsersModule::class, 'viewBasic'])->name('json');
    Route::post('users/delete/item/request', [CitizenUsersModule::class, 'archive'])->name('json');
    Route::post('users/restore/item/request', [CitizenUsersModule::class, 'restore'])->name('json');
    Route::post('users/accept/item/request', [CitizenUsersModule::class, 'acceptAccount'])->name('json');
    Route::post('users/view/addresses/details/request', [CitizenUsersModule::class, 'viewAddresses'])->name('json');
    /* add account */
    Route::post('citizenusers/add/item/request', [CitizenUsersModule::class, 'addCitizen'])->name('json');
    Route::post('officerusers/add/item/request', [OfficerUsersModule::class, 'addUser'])->name('json');
    /* edit account */
    Route::post('citizenusers/edit/item/request', [CitizenUsersModule::class, 'editDisplayData'])->name('json');
    Route::post('officerusers/edit/item/request', [OfficerUsersModule::class, 'editDisplayData'])->name('json');
    /* update account */
    Route::post('citizenusers/update/item/request', [CitizenUsersModule::class, 'update'])->name('json');
    Route::post('officerusers/update/item/request', [OfficerUsersModule::class, 'update'])->name('json');
});

/* Admin Officer */
Route::middleware('auth:sanctum', 'checkUserLevel:1,2')->group(function () {

    /* Incident Names API */
    Route::post('incidentNames/table/Display', [IncidentNamesModule::class, 'tableDisplay'])->name('json');
    Route::post('incidentNames/delete/item/request', [IncidentNamesModule::class, 'archive'])->name('json');
    //Add
    Route::post('incidentNames/add/item/request', [IncidentNamesModule::class, 'addIncidentName'])->name('json');
    Route::post('incidentNames/edit/item/request', [IncidentNamesModule::class, 'editDisplayData'])->name('json');
    Route::post('incidentNames/update/item/request', [IncidentNamesModule::class, 'update'])->name('json');

    /* Incidents API */
    Route::post('incidents/archive/table/Display', [IncidentModule::class, 'displayArchiveIncidents'])->name('json');
    Route::post('incidents/table/Display', [IncidentModule::class, 'displayIncidents'])->name('json');
    Route::post('incidents/report/list/Display', [IncidentModule::class, 'incidentReportList'])->name('json');
    Route::post('incidents/reject/messages/list/Display', [IncidentModule::class, 'rejectMessages'])->name('json');
    Route::post('incidents/delete/item/request', [IncidentModule::class, 'archive'])->name('json');
    Route::post('incidents/restore/item/request', [IncidentModule::class, 'restore'])->name('json');
    Route::post('incidents/respond/item/request', [IncidentModule::class, 'respond'])->name('json');
    Route::post('incidents/reject/item/request', [IncidentModule::class, 'reject'])->name('json');
    Route::post('incidents/assign/item/request', [IncidentModule::class, 'assignTo'])->name('json');

    /* view incidents */
    Route::post('incidents/view/basic/details/request', [IncidentModule::class, 'viewBasic'])->name('json');
    Route::post('incidents/view/narative/details/request', [IncidentModule::class, 'viewNarative'])->name('json');
    Route::post('incidents/view/suspects/list/request', [IncidentModule::class, 'viewSuspects'])->name('json');
    Route::post('incidents/view/witness/list/request', [IncidentModule::class, 'viewWitness'])->name('json');
    Route::post('incidents/view/victim/list/request', [IncidentModule::class, 'viewVictims'])->name('json');


    /* Add incident */
    Route::post('incidents/add/item/request', [IncidentModule::class, 'addIncident'])->name('json');
    Route::post('incidents/edit/item/request', [IncidentModule::class, 'editDisplayData'])->name('json');
    Route::post('incidents/update/item/request', [IncidentModule::class, 'update'])->name('json');
    Route::post('suspect/search/Display', [SuspectsManipulation::class, 'search'])->name('json');
    Route::post('victims/search/Display', [VictimsModule::class, 'search'])->name('json');
    Route::post('witness/search/Display', [WitnessModule::class, 'search'])->name('json');
    Route::post('incidentNames/search/Display', [IncidentNamesModule::class, 'search'])->name('json');

    /* REPORTS */
    Route::post('incidents/generate/statistical/report', [IncidentModule::class, 'generateReport'])->name('json');
    Route::post('accounts/generate/statistical/report', [CitizenUsersModule::class, 'accountRequestDisplay'])->name('json');

    /* Narrative */
    Route::post('dashboard/lineraph/filtered/generate', [DashboardModule::class, 'generateLine'])->name('json');
    Route::post('check/address', [DashboardModule::class, 'findBarangay'])->name('json');
    Route::post('dashboard/report/change/rank', [DashboardModule::class, 'rankChangeReports'])->name('json');
    Route::post('dashboard/report/transfer/station', [DashboardModule::class, 'areaTransferReports'])->name('json');

    /* Susepcts API */
    Route::post('suspect/table/Display', [SuspectsManipulation::class, 'tableDisplay'])->name('json');
    Route::post('suspect/archive/table/Display', [SuspectsManipulation::class, 'archiveTableDisplay'])->name('json');
    Route::post('suspects/delete/item/request', [SuspectsManipulation::class, 'archive'])->name('json');
    Route::post('suspects/restore/item/request', [SuspectsManipulation::class, 'restore'])->name('json');

    /* VIew */
    Route::post('suspects/view/basic/details/request', [SuspectsManipulation::class, 'viewSuspect'])->name('json');
    Route::post('suspects/view/addresses/details/request', [SuspectsManipulation::class, 'viewAddresses'])->name('json');
    Route::post('suspects/view/records/details/request', [SuspectsManipulation::class, 'viewRecords'])->name('json');
    Route::post('suspects/view/physical_characteristics/details/request', [SuspectsManipulation::class, 'viewPhysical'])->name('json');
    Route::post('suspects/view/backgorund_info/details/request', [SuspectsManipulation::class, 'viewBackgroundInfo'])->name('json');
    Route::post('suspects/view/prevVictims/details/request', [SuspectsManipulation::class, 'viewVictims'])->name('json');
    /* add */
    Route::post('suspects/add/item/request', [SuspectsManipulation::class, 'addSuspect'])->name('json');
    Route::post('suspects/edit/item/request', [SuspectsManipulation::class, 'editDisplayData'])->name('json');
    Route::post('suspects/update/item/request', [SuspectsManipulation::class, 'update'])->name('json');

    /* Victims API */
    Route::post('victims/table/Display', [VictimsModule::class, 'tableDisplay'])->name('json');
    Route::post('victims/archive/table/Display', [VictimsModule::class, 'archiveTableDisplay'])->name('json');
    Route::post('victims/delete/item/request', [VictimsModule::class, 'archive'])->name('json');
    Route::post('api/victims/restore/item/request', [VictimsModule::class, 'restore'])->name('json');
    // View
    Route::post('victims/view/basic/details/request', [VictimsModule::class, 'viewVictim'])->name('json');
    Route::post('victims/view/addresses/details/request', [VictimsModule::class, 'viewAddresses'])->name('json');
    Route::post('victims/view/records/details/request', [VictimsModule::class, 'viewRecords'])->name('json');
    //add
    Route::post('victims/add/item/request', [VictimsModule::class, 'addVictim'])->name('json');
    Route::post('victims/edit/item/request', [VictimsModule::class, 'editDisplayData'])->name('json');
    Route::post('victims/update/item/request', [VictimsModule::class, 'update'])->name('json');


    /* Witness API */
    Route::post('witness/table/Display', [WitnessModule::class, 'tableDisplay'])->name('json');
    Route::post('witness/archive/table/Display', [WitnessModule::class, 'archiveTableDisplay'])->name('json');
    Route::post('witness/delete/item/request', [WitnessModule::class, 'archive'])->name('json');
    Route::post('witness/restore/item/request', [WitnessModule::class, 'restore'])->name('json');
    Route::post('witness/view/basic/details/request', [WitnessModule::class, 'viewWitness'])->name('json');
    Route::post('witness/view/addresses/details/request', [WitnessModule::class, 'viewAddresses'])->name('json');
    Route::post('witness/view/records/details/request', [WitnessModule::class, 'viewRecords'])->name('json');
    //add
    Route::post('witness/add/item/request', [WitnessModule::class, 'addWitness'])->name('json');
    Route::post('witness/edit/item/request', [WitnessModule::class, 'editDisplayData'])->name('json');
    Route::post('witness/update/item/request', [WitnessModule::class, 'update'])->name('json');

    /* Predictive Analytics */
    Route::post('incidents/top/baragay/prediction/display', [PredictiveAnalytics::class, 'predictTopBarangaysForFuture']);
    Route::post('top/incidents/prediction/display', [PredictiveAnalytics::class, 'predictTopIncidentTypes']);
    Route::post('dashboard/lineraph/predict/generate', [PredictiveAnalytics::class, 'generatePredictedLine']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
