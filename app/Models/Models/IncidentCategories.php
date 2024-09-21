<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IncidentCategories extends Model
{
    
    use HasFactory;

    protected $table = 'incident-categories';

    protected $fillable = ['category_name', 'edited_by', 'deleted', 'added_by', 'deleted_by'];

    /* Has many relation ship */
    
    public function incidetType():HasMany
    {
        return $this->hasMany(IncidentTypes::class, 'id');
    }

    /* Belongs to */

}
