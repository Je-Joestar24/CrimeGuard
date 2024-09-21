<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliceStation extends Model
{
    use HasFactory;

    protected $table = 'police-station';
    protected $fillable = [
        'name',
        'telephone',
        'officer_id',
        'location',
        'address'
    ];
}
