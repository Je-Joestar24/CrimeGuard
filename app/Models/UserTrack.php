<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTrack extends Model
{
    protected $table = 'user_track';
    use HasFactory;
    protected $fillable = [
        'user',
        'latitude',
        'longitude'
    ];
}
