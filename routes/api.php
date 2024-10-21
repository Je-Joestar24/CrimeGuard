<?php

use App\Http\Controllers\crimeguardm\citizenUsersModule;
use App\Http\Controllers\crimeguardm\dashboardModule;
use App\Http\Controllers\CrimeGuardM\incidentModule;
use App\Http\Controllers\crimeguardm\incidentNamesModule;
use App\Http\Controllers\crimeguardm\officerUsersModule;
use App\Http\Controllers\crimeguardm\predictiveAnalytics;
use App\Http\Controllers\CrimeGuardM\suspectsManipulation;
use App\Http\Controllers\CrimeGuardM\victimsModule;
use App\Http\Controllers\crimeguardm\witnessModule;
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

Route::middleware('auth:sanctum')->get('/check-token', function (Request $request) {
    // You don't need to pass the user explicitly
    // $request->user() gives you the authenticated user from the token
    return response()->json([
        'message' => 'Token is valid',
        'user' => $request->user(), // Automatically retrieved user
    ], 200);
});

Route::middleware('auth:sanctum', 'checkUserLevel:1,2,3')->group(function () {
    Route::post('dashboard/generate/incident/top/barangay/bar', [dashboardModule::class, 'topBarangays'])->name('json');
});

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    // Revoke the current user’s token
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Logged out successfully'], 200);
});

/* ADMIN */
Route::middleware('auth:sanctum', 'checkUserLevel:1')->group(function () {


    /* Accounts api */
    Route::post('citizenUsers/table/Display', [citizenUsersModule::class, 'tableDisplay'])->name('json');
    Route::post('citizenUsers/account/request/list/Display', [citizenUsersModule::class, 'registrationRequests'])->name('json');
    Route::post('citizenUsers/archive/table/Display', [citizenUsersModule::class, 'archiveTableDisplay'])->name('json');
    Route::post('officerUsers/table/Display', [officerUsersModule::class, 'tableDisplay'])->name('json');
    Route::post('citizenUsers/view/basic/details/request', [citizenUsersModule::class, 'viewBasic'])->name('json');
    Route::post('users/delete/item/request', [citizenUsersModule::class, 'archive'])->name('json');
    Route::post('users/restore/item/request', [citizenUsersModule::class, 'restore'])->name('json');
    Route::post('users/accept/item/request', [citizenUsersModule::class, 'acceptAccount'])->name('json');
    Route::post('users/view/addresses/details/request', [citizenUsersModule::class, 'viewAddresses'])->name('json');
    /* add account */
    Route::post('citizenusers/add/item/request', [citizenUsersModule::class, 'addCitizen'])->name('json');
    Route::post('officerusers/add/item/request', [officerUsersModule::class, 'addUser'])->name('json');
    /* edit account */
    Route::post('citizenusers/edit/item/request', [citizenUsersModule::class, 'editDisplayData'])->name('json');
    Route::post('officerusers/edit/item/request', [officerUsersModule::class, 'editDisplayData'])->name('json');
    /* update account */
    Route::post('citizenusers/update/item/request', [citizenUsersModule::class, 'update'])->name('json');
    Route::post('officerusers/update/item/request', [officerUsersModule::class, 'update'])->name('json');
});
/* Admin Officer */
Route::middleware('auth:sanctum', 'checkUserLevel:1,2')->group(function () {

    /* Incident Names API */
    Route::post('incidentNames/table/Display', [incidentNamesModule::class, 'tableDisplay'])->name('json');
    Route::post('incidentNames/delete/item/request', [incidentNamesModule::class, 'archive'])->name('json');
    //Add
    Route::post('incidentNames/add/item/request', [incidentNamesModule::class, 'addIncidentName'])->name('json');
    Route::post('incidentNames/edit/item/request', [incidentNamesModule::class, 'editDisplayData'])->name('json');
    Route::post('incidentNames/update/item/request', [incidentNamesModule::class, 'update'])->name('json');

    /* Incidents API */
    Route::post('incidents/archive/table/Display', [incidentModule::class, 'displayArchiveIncidents'])->name('json');
    Route::post('incidents/table/Display', [incidentModule::class, 'displayIncidents'])->name('json');
    Route::post('incidents/report/list/Display', [incidentModule::class, 'incidentReportList'])->name('json');
    Route::post('incidents/reject/messages/list/Display', [incidentModule::class, 'rejectMessages'])->name('json');
    Route::post('incidents/delete/item/request', [incidentModule::class, 'archive'])->name('json');
    Route::post('incidents/restore/item/request', [incidentModule::class, 'restore'])->name('json');
    Route::post('incidents/respond/item/request', [incidentModule::class, 'respond'])->name('json');
    Route::post('incidents/reject/item/request', [incidentModule::class, 'reject'])->name('json');
    Route::post('incidents/assign/item/request', [incidentModule::class, 'assignTo'])->name('json');

    /* view incidents */
    Route::post('incidents/view/basic/details/request', [incidentModule::class, 'viewBasic'])->name('json');
    Route::post('incidents/view/narative/details/request', [incidentModule::class, 'viewNarative'])->name('json');
    Route::post('incidents/view/suspects/list/request', [incidentModule::class, 'viewSuspects'])->name('json');
    Route::post('incidents/view/witness/list/request', [incidentModule::class, 'viewWitness'])->name('json');
    Route::post('incidents/view/victim/list/request', [incidentModule::class, 'viewVictims'])->name('json');


    /* Add incident */
    Route::post('incidents/add/item/request', [incidentModule::class, 'addIncident'])->name('json');
    Route::post('incidents/edit/item/request', [incidentModule::class, 'editDisplayData'])->name('json');
    Route::post('incidents/update/item/request', [incidentModule::class, 'update'])->name('json');
    Route::post('suspect/search/Display', [suspectsManipulation::class, 'search'])->name('json');
    Route::post('victims/search/Display', [victimsModule::class, 'search'])->name('json');
    Route::post('witness/search/Display', [witnessModule::class, 'search'])->name('json');
    Route::post('incidentNames/search/Display', [incidentNamesModule::class, 'search'])->name('json');

    /* REPORTS */
    Route::post('incidents/generate/statistical/report', [incidentModule::class, 'generateReport'])->name('json');
    Route::post('accounts/generate/statistical/report', [citizenUsersModule::class, 'accountRequestDisplay'])->name('json');

    /* Narrative */
    Route::post('dashboard/lineraph/filtered/generate', [dashboardModule::class, 'generateLine'])->name('json');
    Route::post('check/address', [dashboardModule::class, 'findBarangay'])->name('json');
    Route::post('dashboard/report/change/rank', [dashboardModule::class, 'rankChangeReports'])->name('json');
    Route::post('dashboard/report/transfer/station', [dashboardModule::class, 'areaTransferReports'])->name('json');

    /* Susepcts API */
    Route::post('suspect/table/Display', [suspectsManipulation::class, 'tableDisplay'])->name('json');
    Route::post('suspect/archive/table/Display', [suspectsManipulation::class, 'archiveTableDisplay'])->name('json');
    Route::post('suspects/delete/item/request', [suspectsManipulation::class, 'archive'])->name('json');
    Route::post('suspects/restore/item/request', [suspectsManipulation::class, 'restore'])->name('json');

    /* VIew */
    Route::post('suspects/view/basic/details/request', [suspectsManipulation::class, 'viewSuspect'])->name('json');
    Route::post('suspects/view/addresses/details/request', [suspectsManipulation::class, 'viewAddresses'])->name('json');
    Route::post('suspects/view/records/details/request', [suspectsManipulation::class, 'viewRecords'])->name('json');
    Route::post('suspects/view/physical_characteristics/details/request', [suspectsManipulation::class, 'viewPhysical'])->name('json');
    Route::post('suspects/view/backgorund_info/details/request', [suspectsManipulation::class, 'viewBackgroundInfo'])->name('json');
    Route::post('suspects/view/prevVictims/details/request', [suspectsManipulation::class, 'viewVictims'])->name('json');
    /* add */
    Route::post('suspects/add/item/request', [suspectsManipulation::class, 'addSuspect'])->name('json');
    Route::post('suspects/edit/item/request', [suspectsManipulation::class, 'editDisplayData'])->name('json');
    Route::post('suspects/update/item/request', [suspectsManipulation::class, 'update'])->name('json');

    /* Victims API */
    Route::post('victims/table/Display', [victimsModule::class, 'tableDisplay'])->name('json');
    Route::post('victims/archive/table/Display', [victimsModule::class, 'archiveTableDisplay'])->name('json');
    Route::post('victims/delete/item/request', [victimsModule::class, 'archive'])->name('json');
    Route::post('api/victims/restore/item/request', [victimsModule::class, 'restore'])->name('json');
    // View
    Route::post('victims/view/basic/details/request', [victimsModule::class, 'viewVictim'])->name('json');
    Route::post('victims/view/addresses/details/request', [victimsModule::class, 'viewAddresses'])->name('json');
    Route::post('victims/view/records/details/request', [victimsModule::class, 'viewRecords'])->name('json');
    //add
    Route::post('victims/add/item/request', [victimsModule::class, 'addVictim'])->name('json');
    Route::post('victims/edit/item/request', [victimsModule::class, 'editDisplayData'])->name('json');
    Route::post('victims/update/item/request', [victimsModule::class, 'update'])->name('json');


    /* Witness API */
    Route::post('witness/table/Display', [witnessModule::class, 'tableDisplay'])->name('json');
    Route::post('witness/archive/table/Display', [witnessModule::class, 'archiveTableDisplay'])->name('json');
    Route::post('witness/delete/item/request', [witnessModule::class, 'archive'])->name('json');
    Route::post('witness/restore/item/request', [witnessModule::class, 'restore'])->name('json');
    Route::post('witness/view/basic/details/request', [witnessModule::class, 'viewWitness'])->name('json');
    Route::post('witness/view/addresses/details/request', [witnessModule::class, 'viewAddresses'])->name('json');
    Route::post('witness/view/records/details/request', [witnessModule::class, 'viewRecords'])->name('json');
    //add
    Route::post('witness/add/item/request', [witnessModule::class, 'addWitness'])->name('json');
    Route::post('witness/edit/item/request', [witnessModule::class, 'editDisplayData'])->name('json');
    Route::post('witness/update/item/request', [witnessModule::class, 'update'])->name('json');

    /* Predictive Analytics */
    Route::post('incidents/top/baragay/prediction/display', [PredictiveAnalytics::class, 'predictTopBarangaysForFuture']);
    Route::post('top/incidents/prediction/display', [PredictiveAnalytics::class, 'predictTopIncidentTypes']);
    Route::post('dashboard/lineraph/predict/generate', [PredictiveAnalytics::class, 'generatePredictedLine']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
