<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdministeringOfficer extends Model
{
    use HasFactory;
    protected $table = 'administering-officers';

    protected $fillable = [
        'officer_name',
        'signature',
        'officer_id'
    ];

    /* Belongs to */

    public function officer():BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }


    /* Has Many */

    public function incidentNarative():HasMany
    {
        return $this->hasMany(IncidentNarative::class, 'id');
    }
}
