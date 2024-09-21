<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IncidentTypes extends Model
{
    use HasFactory;

    protected $table = 'incident-types';

    protected $fillable = ['incident_name', 'category_id', 'sub_type_id', 'edited_by', 'deleted', 'added_by', 'deleted_by'];

    /* Belongs to */

    public function subType():BelongsTo
    {
        return $this->belongsTo(IncidentSubTypes::class, 'sub_type_id');
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(IncidentCategories::class, 'category_id');
    }

    /* hasMany */

    public function IncidentNarative():HasMany
    {
        return $this->hasMany(IncidentNarative::class, 'id');
    }
}
