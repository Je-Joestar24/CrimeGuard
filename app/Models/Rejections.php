<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rejections extends Model
{
    use HasFactory;
    protected $table = 'rejections';
    protected $fillable = [
        'reject_message',
        'incident_id',
        'user_id',
    ];
}
