<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrailLog extends Model
{
    use HasFactory;
    protected $table = 'trail-log';
    protected $fillable = ['user_id', 'item', 'action'];
}
