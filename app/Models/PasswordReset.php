<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'token', 'expires_at'];

    // Disabling automatic timestamps (since we're using created_at and expires_at)
    public $timestamps = false;

    protected $dates = ['expires_at'];
}
