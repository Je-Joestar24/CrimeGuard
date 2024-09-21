<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class incidentReportingPerson extends Model
{
    protected $table = 'incident-reporting-persons';

    protected $fillable = ['incident', 'user', 'reporting_person'];
    use HasFactory;
}
