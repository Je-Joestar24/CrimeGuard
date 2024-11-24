<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentSuspects extends Model
{
    protected $table = 'incident-suspects';
    protected $fillable = ['incident', 'suspect'];
    use HasFactory;
}
