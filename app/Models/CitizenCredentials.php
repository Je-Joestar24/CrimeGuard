<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CitizenCredentials extends Model
{
    use HasFactory;
    protected $table='citizen-credentials';

    
    protected $fillable=[
        'user_id',
        'valid_id',
        'date_request',
        'accepted_date',
        'deleted_by',
        'archived_at',
        'edited_by',
        'rejected_by',
        'accepted_by',
        'fb_name'
    ];

    /* Belongs to */

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
