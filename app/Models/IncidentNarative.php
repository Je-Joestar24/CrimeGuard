<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncidentNarative extends Model
{

    use HasFactory;

    protected $table = 'incident-narative';

    protected $fillable = [
        'incident_type_id',
        'addresses_id',
        'date_of_incident',
        'details',
        'reporting_person_id',
        'administering_officer_id',
        'assisting_officer_id',
        'blotter_entry_nr'
    ];

    /* Belongs to */
    
    public function incidentType():BelongsTo
    {
        return $this->belongsTo(IncidentTypes::class, 'incident_type_id');
    }

    public function addresses():BelongsTo
    {
        return $this->belongsTo(Addresses::class, 'addresses_id');
    }

    public function reportingPerson():BelongsTo
    {
        return $this->belongsTo(ReportingPerson::class, 'reporting_person_id');
    }

    public function administeringOfficer():BelongsTo
    {
        return $this->belongsTo(AdministeringOfficer::class, 'administering_officer_id');
    }  

    public function assistingOfficer():BelongsTo
    {
        return $this->belongsTo(User::class, 'assisting_officer_id');
    }
}
