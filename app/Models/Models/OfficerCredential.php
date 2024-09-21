<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficerCredential extends Model
{
    use HasFactory;
    
    protected $table = 'officer-credentials';

    protected $fillable = [
        'user_id',
        'station',
        'rank',
    ];
}
