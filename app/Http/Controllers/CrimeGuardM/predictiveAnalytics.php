<?php

namespace App\Http\Controllers\crimeguardm;

use App\Http\Controllers\Controller;
use App\Models\Incidents;
use App\Models\IncidentSubTypes;
use App\Models\IncidentTypes;
use Carbon\Carbon;
use Illuminate\Http\Request;

class predictiveAnalytics extends Controller
{

    public function generateIncidentData(Request $request)
    {
        // Step 1: Load all incidents from the 'incidents' table
        $allIncidents = Incidents::select('date_of_incident', 'barangay')
            ->where('status', '!=', 'report')
            ->where('status', '!=', 'reject')
            ->where('status', '!=', 'archive')
            ->orderBy('date_of_incident', 'ASC')
            ->get();

        // Step 2: Organize incidents by date and barangay
        $incidentData = [];
        foreach ($allIncidents as $incident) {
            $date = Carbon::parse($incident->date_of_incident)->toDateString();
            $barangay = $incident->barangay;

            // Initialize the array structure if not already
            if (!isset($incidentData[$barangay])) {
                $incidentData[$barangay] = [];
            }
            if (!isset($incidentData[$barangay][$date])) {
                $incidentData[$barangay][$date] = [
                    'date' => $date,
                    'barangay' => $barangay,
                    'incident_count' => 0,
                    '7_day_rolling_avg' => 0,
                    '30_day_rolling_avg' => 0,
                    'day_of_week' => Carbon::parse($date)->dayOfWeek,
                    'month' => Carbon::parse($date)->month,
                    'year' => Carbon::parse($date)->year,
                ];
            }

            // Increment the incident count for the date and barangay
            $incidentData[$barangay][$date]['incident_count']++;
        }

        // Step 3: Calculate the 7-day and 30-day rolling averages
        foreach ($incidentData as $barangay => $dates) {
            // Get an array of all the dates for the barangay in ascending order
            $sortedDates = collect($dates)->sortBy('date')->values();

            // Calculate the rolling averages for each date
            for ($i = 0; $i < $sortedDates->count(); $i++) {
                // Get the last 7 days for the 7-day rolling average
                $last7Days = $sortedDates->slice(max(0, $i - 6), 7);
                $incidentData[$barangay][$sortedDates[$i]['date']]['7_day_rolling_avg'] = round($last7Days->avg('incident_count'), 2);

                // Get the last 30 days for the 30-day rolling average
                $last30Days = $sortedDates->slice(max(0, $i - 29), 30);
                $incidentData[$barangay][$sortedDates[$i]['date']]['30_day_rolling_avg'] = round($last30Days->avg('incident_count'), 2);
            }
        }

        // Step 4: Flatten the data structure into an associative array in the required format
        $formattedData = [];
        foreach ($incidentData as $barangay => $dates) {
            foreach ($dates as $date => $data) {
                $formattedData[] = $data;
            }
        }

        // Return the formatted array as a response (or process further if needed)
        return response()->json($this->predictTopBarangays($formattedData));
    }

    private function predictTopBarangays($incidentData)
    {
        $predictedBarangays = [];

        foreach ($incidentData as $data) {
            $barangay = $data['barangay'];
            $incidentCount = $data['incident_count'];
            $rolling7Day = $data['7_day_rolling_avg'];
            $rolling30Day = $data['30_day_rolling_avg'];

            $predictedIncidentCount = ($incidentCount * 0.4) + ($rolling7Day * 0.3) + ($rolling30Day * 0.3);

            if (!isset($predictedBarangays[$barangay])) {
                $predictedBarangays[$barangay] = 0;
            }

            $predictedBarangays[$barangay] += $predictedIncidentCount;
        }

        arsort($predictedBarangays);

        $topBarangays = array_slice($predictedBarangays, 0, 3, true);

        $totalTopIncidents = array_sum($topBarangays);

        $result = [];
        foreach ($topBarangays as $barangay => $predictedCount) {
            $probability = ($predictedCount / $totalTopIncidents) * 100;
            $result[] = [
                'barangay' => $barangay,
                'probability' => round($probability, 2) // Round the probability to 2 decimal places
            ];
        }

        return $result;
    }

    public function predictTopBarangaysForFuture(Request $request)
    {

        $request->validate([
            'date_start' => 'required|date_format:Y-m-d',
            'date_end' => 'required|date_format:Y-m-d|after_or_equal:date_start',
        ]);
        $dt = [
            'data' => [],
            'response' => 'Success'
        ];
        try {
            $futureStartDate = Carbon::parse($request->input('date_start'));
            $futureEndDate = Carbon::parse($request->input('date_end'));

            $historicalData = $request->has('incident_type')  ? $this->historicalData($request->input('incident_type')) : $this->historicalData('');

            $predictedBarangays = [];

            foreach ($historicalData as $data) {
                $barangay = $data['barangay'];

                $daysToPredict = $futureStartDate->diffInDays($futureEndDate) + 1;
                $totalPredictedIncidents = 0;

                for ($i = 0; $i < $daysToPredict; $i++) {
                    $currentDate = $futureStartDate->copy()->addDays($i);

                    $predictedIncidentCount = $this->predictIncidentForDay($data, $currentDate);

                    if (!isset($predictedBarangays[$barangay])) {
                        $predictedBarangays[$barangay] = 0;
                    }
                    $predictedBarangays[$barangay] += $predictedIncidentCount;
                }
            }

            arsort($predictedBarangays);

            $topBarangays = array_slice($predictedBarangays, 0, 3, true);

            $totalTopIncidents = array_sum($topBarangays);

            $result = [];
            foreach ($topBarangays as $barangay => $predictedCount) {
                $probability = ($predictedCount / $totalTopIncidents) * 100;
                $result[] = [
                    'barangay' => $barangay,
                    'probability' => round($probability, 2)
                ];
            }
            $dt['data'] = $result;
        } catch (\Exception $e) {
            $dt['response'] = 'Error';
            $dt['err'] = $e;
        }
        return response()->json($dt);
    }

    /* Predictive */
    public function generatePredictedLine(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $startDate = Carbon::create(2024, 1, 1);
        $endDate = Carbon::now();

        $userStartDate = $request->input('date_start') ?? $startDate->toDateString();
        $userEndDate = $request->input('date_end') ?? $endDate->toDateString();

        $userStartC = Carbon::parse($userStartDate);
        $userEndC = Carbon::parse($userEndDate);

        $historicalData = Incidents::selectRaw('DATE(date_reported) as date, COUNT(*) as count')
            ->whereBetween('date_reported', [$startDate->toDateString(), $endDate->toDateString()])
            ->whereNull('archived_at')
            ->whereNull('archived_by');

        if ($request->has('barangay') && !empty($request->input('barangay'))) {
            $historicalData = $historicalData->where('barangay', '=', $request->input('barangay'));
        }

        if ($request->has('incident_type') && !empty($request->input('incident_type'))) {
            $historicalData = $historicalData->where('incident_type', '=', $request->input('incident_type'));
        }

        $historicalData = $historicalData
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $historicalCounts = [];
        foreach ($historicalData as $data) {
            $historicalCounts[$data->date] = $data->count;
        }

        $predictedData = [];
        $totalDaysToPredict = $userEndC->diffInDays($userStartC);

        for ($i = 0; $i <= $totalDaysToPredict; $i++) {
            $currentDate = $userStartC->copy()->addDays($i);
            $predictedCount = $this->predictDailyCount($currentDate, $historicalCounts);
            $predictedData[] = [
                'date' => $currentDate->toDateString(),
                'count' => $predictedCount
            ];
        }

        $responseData = [
            'data' => [
                'linegraph' => $predictedData,
            ],
            'response' => 'Success'
        ];

        return response()->json($responseData);
    }

    private function predictDailyCount($date, $historicalCounts)
    {
        if (isset($historicalCounts[$date->toDateString()])) {
            return $historicalCounts[$date->toDateString()];
        }

        $totalHistoricalDays = count($historicalCounts);
        if ($totalHistoricalDays < 1) {
            return 0;
        }

        $dayOfWeek = $date->dayOfWeek;
        $historicalDayCounts = [];
        foreach ($historicalCounts as $histDate => $count) {
            $histDateObj = Carbon::parse($histDate);
            if ($histDateObj->dayOfWeek == $dayOfWeek) {
                $historicalDayCounts[] = $count;
            }
        }

        if (count($historicalDayCounts) > 0) {
            return round(array_sum($historicalDayCounts) / count($historicalDayCounts));
        }

        return round(array_sum($historicalCounts) / $totalHistoricalDays);
    }
    public function predictTopIncidentTypes(Request $request)
    {

        $dt = [
            'data' => [],
            'response' => 'Success'
        ];
        try {
            $startDate = Carbon::parse($request->input('date_start'));
            $endDate = Carbon::parse($request->input('date_end'));

            $incidentStatistics = $request->has('barangay') ? $this->generateIncidentStatistics($request->input('barangay')) : $this->generateIncidentStatistics('');

            $predictedIncidentCounts = [];

            foreach ($incidentStatistics as $incidentData) {
                $incidentTypeId = $incidentData['incident_type_id'];
                $incidentCount7d = $incidentData['incident_count_7d'];
                $incidentCount30d = $incidentData['incident_count_30d'];

                $predictedDailyIncidents = ($incidentCount7d * 0.7) + ($incidentCount30d * 0.3);

                $daysInRange = $endDate->diffInDays($startDate) + 1;

                $predictedTotalIncidents = $predictedDailyIncidents * $daysInRange;

                if (!isset($predictedIncidentCounts[$incidentTypeId])) {
                    $predictedIncidentCounts[$incidentTypeId] = 0;
                }
                $predictedIncidentCounts[$incidentTypeId] += $predictedTotalIncidents;
            }

            arsort($predictedIncidentCounts);

            $top5IncidentTypes = array_slice($predictedIncidentCounts, 0, 5, true);

            $topIncidentTypes = [];
            foreach ($top5IncidentTypes as $incidentTypeId => $predictedCount) {
                $iname = IncidentTypes::select('incident_name', 'sub_type_id')->find($incidentTypeId);
                $res = $iname->toArray()['incident_name'] . "";
                if ($iname->toArray()['sub_type_id'] != NULL) {
                    $ist = IncidentSubTypes::select('sub_type')->find($iname->toArray()['sub_type_id']);
                    $res .= " (" . $ist->toArray()['sub_type'] . ")";
                }
                array_push($topIncidentTypes, [
                    'incident' => $res,
                    'predicted_count' => round($predictedCount, 2),
                ]);
            }
            $dt['data'] = $topIncidentTypes;
        } catch (\Exception $e) {
            $dt['response'] = 'Error';
            $dt['err'] = $e;
        }
        return response()->json($dt);
    }

    private function historicalData($param)
    {
        $allIncidents = Incidents::select('date_of_incident', 'barangay')
            ->where('status', '!=', 'report')
            ->where('status', '!=', 'reject')
            ->where('status', '!=', 'archive');
        if ($param != '') $allIncidents = $allIncidents->where('incident_type', '=', $param);
        $allIncidents = $allIncidents->orderBy('date_of_incident', 'ASC')
            ->get();

        $incidentData = [];
        foreach ($allIncidents as $incident) {
            $date = Carbon::parse($incident->date_of_incident)->toDateString();
            $barangay = $incident->barangay;

            if (!isset($incidentData[$barangay])) {
                $incidentData[$barangay] = [];
            }
            if (!isset($incidentData[$barangay][$date])) {
                $incidentData[$barangay][$date] = [
                    'date' => $date,
                    'barangay' => $barangay,
                    'incident_count' => 0,
                    '7_day_rolling_avg' => 0,
                    '30_day_rolling_avg' => 0,
                    'day_of_week' => Carbon::parse($date)->dayOfWeek,
                    'month' => Carbon::parse($date)->month,
                    'year' => Carbon::parse($date)->year,
                ];
            }

            $incidentData[$barangay][$date]['incident_count']++;
        }

        foreach ($incidentData as $barangay => $dates) {
            $sortedDates = collect($dates)->sortBy('date')->values();

            for ($i = 0; $i < $sortedDates->count(); $i++) {
                $last7Days = $sortedDates->slice(max(0, $i - 6), 7);
                $incidentData[$barangay][$sortedDates[$i]['date']]['7_day_rolling_avg'] = round($last7Days->avg('incident_count'), 2);
                $last30Days = $sortedDates->slice(max(0, $i - 29), 30);
                $incidentData[$barangay][$sortedDates[$i]['date']]['30_day_rolling_avg'] = round($last30Days->avg('incident_count'), 2);
            }
        }
        $formattedData = [];
        foreach ($incidentData as $barangay => $dates) {
            foreach ($dates as $date => $data) {
                $formattedData[] = $data;
            }
        }
        return $formattedData;
    }

    private function predictIncidentForDay($data, $date)
    {
        $rolling7Day = $data['7_day_rolling_avg'];
        $rolling30Day = $data['30_day_rolling_avg'];
        $dayOfWeek = $date->dayOfWeek;
        $month = $date->month;

        $predictedIncidentCount = ($rolling7Day * 0.5) + ($rolling30Day * 0.3) + ($dayOfWeek * 0.1) + ($month * 0.1);

        return round($predictedIncidentCount, 2);
    }

    private function generateIncidentStatistics($param)
    {
        $incidentTypes = IncidentTypes::all()->pluck('incident_name', 'id');

        $incidents = Incidents::select('incident_type', 'date_of_incident', 'time_of_incident')
            ->where('status', '!=', 'report')
            ->where('status', '!=', 'reject')
            ->where('status', '!=', 'archive');
        if ($param != '') $incidents = $incidents->where('barangay', '=', $param);
        $incidents = $incidents->orderBy('date_of_incident', 'ASC')
            ->get();

        $incidentStatistics = [];

        $incidentsGrouped = $incidents->groupBy(['incident_type', 'date_of_incident']);

        foreach ($incidentsGrouped as $incidentTypeId => $dates) {
            foreach ($dates as $date => $incidentsOnDate) {
                $incidentCount = count($incidentsOnDate);
                $avgTimeOfIncident = Carbon::createFromTime(0, 0, 0)->addSeconds(
                    collect($incidentsOnDate)->average(function ($incident) {
                        return Carbon::parse($incident->time_of_incident)->secondsSinceMidnight();
                    })
                );

                $rolling7Day = $this->calculateRollingAverage($incidentTypeId, $date, 7, $incidentsGrouped);
                $rolling30Day = $this->calculateRollingAverage($incidentTypeId, $date, 30, $incidentsGrouped);

                $incidentDate = Carbon::parse($date);
                $dayOfWeek = $incidentDate->dayOfWeek;
                $month = $incidentDate->month;
                $year = $incidentDate->year;

                $incidentStatistics[] = [
                    'incident_type_id' => $incidentTypeId,
                    'incident_date' => $date,
                    'total_incidents' => $incidentCount,
                    'avg_time_of_incident' => $avgTimeOfIncident->toTimeString(),
                    'incident_count_7d' => $rolling7Day,
                    'incident_count_30d' => $rolling30Day,
                    'day_of_week' => $dayOfWeek,
                    'month' => $month,
                    'year' => $year
                ];
            }
        }

        return $incidentStatistics;
    }

    private function calculateRollingAverage($incidentTypeId, $currentDate, $days, $incidentsGrouped)
    {
        $startDate = Carbon::parse($currentDate)->subDays($days);

        $totalIncidentsInWindow = 0;
        $daysInWindow = 0;

        foreach ($incidentsGrouped[$incidentTypeId] as $date => $incidentsOnDate) {
            $date = Carbon::parse($date);
            if ($date->between($startDate, Carbon::parse($currentDate))) {
                $totalIncidentsInWindow += count($incidentsOnDate);
                $daysInWindow++;
            }
        }

        return $daysInWindow > 0 ? $totalIncidentsInWindow / $daysInWindow : 0;
    }
}
