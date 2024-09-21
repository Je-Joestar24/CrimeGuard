<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class IncidentSubTypes extends Model
{
    
    use HasFactory;
    protected $table = 'incident-sub-types';

    protected $fillable = ['sub_type', 'edited_by', 'deleted', 'added_by', 'deleted_by'];

    public function incidetType():BelongsToMany
    {
        return $this->belongsToMany(IncidentTypes::class, 'id');
    }
}
