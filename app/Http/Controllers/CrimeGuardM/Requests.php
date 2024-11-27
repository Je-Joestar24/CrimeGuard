<?php

namespace App\Http\Controllers\crimeguardm;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CrimeGuardM\Dynamic\DynamicFunctions;
use Illuminate\Http\Request;
use App\Models\IncidentSecure;
class Requests extends Controller
{
    //
    protected $dynamic;
    public function __construct(DynamicFunctions $df)
    {
        $this->dynamic = $df;
    }

    public function addIncidentSecured(Request $request)
    {
        $data = [];
        try {
            date_default_timezone_set('Asia/Manila');
            // Create new incident secured record
            $incidentSecured = IncidentSecure::create([
                'incident' => $request->incident,
                'officer' => $request->officer, 
                'citizen' => $request->citizen
            ]);

            $data['response'] = 'Success';

        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['err'] = $e->getMessage();
        }

        return response()->json($data);
    }
}
