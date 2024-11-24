<?php

namespace App\Http\Controllers\CrimeGuardM\Dynamic;

use App\Http\Controllers\Controller;
use App\Models\IncidentReportingPerson;
use App\Models\Incidents;
use App\Models\IncidentSuspects;
use App\Models\IncidentVictims;

class IncidentFunctions extends Controller
{
    //

    public function incidentWitness($request)
    {

        $counta = $this->isIncidentArchive($request['id']);

        $query = IncidentReportingPerson::join('incidents', 'incident-reporting-persons.incident', '=', 'incidents.id')
            ->join('reporting-persons', 'incident-reporting-persons.reporting_person', '=', 'reporting-persons.id')
            ->select('reporting-persons.id', 'reporting-persons.firstname', 'reporting-persons.lastname', 'reporting-persons.mobile_phone');
        if ($counta == 0) {
            $query = $query->whereNull('reporting-persons.archived_at')
                ->whereNull('reporting-persons.deleted_by')
                ->whereNull('incidents.archived_at')
                ->whereNull('incidents.archived_by');
        }

        return $query->where('incidents.id', $request['id'])->get()->toArray();
    }

    public function IncidentSuspects( $request)
    {

        $counta = $this->isIncidentArchive($request['id']);

        $query = IncidentSuspects::join('incidents', 'incident-suspects.incident', '=', 'incidents.id')
            ->join('suspects', 'incident-suspects.suspect', '=', 'suspects.id')
            ->select('suspects.id', 'suspects.firstname', 'suspects.lastname', 'suspects.mobile_phone');
        if ($counta == 0) {
            $query = $query->whereNull('suspects.archived_at')
                ->whereNull('suspects.deleted_by')
                ->whereNull('incidents.archived_at')
                ->whereNull('incidents.archived_by');
        }
        return $query->where('incidents.id', $request['id'])->get()->toArray();
    }
    
    public function IncidentVictims($request)
    {
            $counta = $this->isIncidentArchive($request['id']);

            $query = IncidentVictims::join('incidents', 'incident-victims.incident', '=', 'incidents.id')
                ->join('victims', 'incident-victims.victim', '=', 'victims.id')
                ->select('victims.id', 'victims.firstname', 'victims.lastname', 'victims.mobile_phone');

            if ($counta == 0) {
                $query = $query->whereNull('victims.archived_at')
                    ->whereNull('victims.deleted_by')
                    ->whereNull('incidents.archived_at')
                    ->whereNull('incidents.archived_by');
            }

            return $query->where('incidents.id', $request['id'])->get()->toArray();

    }

    private function isIncidentArchive($id)
    {

        return Incidents::where('id', $id)
            ->whereNotNull('archived_at')
            ->whereNotNull('archived_by')
            ->count();
    }


}
