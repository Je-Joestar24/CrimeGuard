<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentSecure extends Model
{
    use HasFactory;
    protected $table = 'incident-secured';

    protected $fillable = [
        'incident',
        'officer',
        'citizen',
    ];
}
