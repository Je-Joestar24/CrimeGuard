<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incidents extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_type',
        'status',
        'time_of_incident',
        'date_of_incident',
        'incident_narrative',
        'latitude',
        'longitude',
        'landmark',
        'message',
        'location',
        'time_reported',
        'date_reported', 
        'edited_by', 
        'deleted', 
        'added_by', 
        'deleted_by',
        'village',
        'barangay',
        'street',
        'city',
        'province',
        'reported_by_user',
        'copy_for',
        'IRF_Entry_no',
        'report_type',
        'station',
        'assigned_to',
        'rej_message'
    ];

    /* Belongs to */

    public function incidentNarative(): BelongsTo
    {
        return $this->belongsTo(IncidentNarative::class, 'narrative_id');
    }
}
