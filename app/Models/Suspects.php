<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspects extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'firstname',
        'lastname',
        'middlename',
        'qualifier',
        'nickname',
        'citizenship',
        'gender',
        'civil_status',
        'birth_date',
        'age',
        'place_of_birth',
        'home_phone',
        'mobile_phone',
        'current_address_id',
        'other_address_id',
        'highest_educ_attainment',
        'occupation',
        'work_address_id',
        'relation_to_victim',
        'fb_account',
        'email',
        'pnp_rank',
        'unit_assignment',
        'group_affiliation',
        'has_previous_record',
        'previous_records_details',
        'status',
        'height',
        'weight',
        'built',
        'eyes_color',
        'eyes_description',
        'hair_color',
        'hair_description',
        'under_influence_of',
        'edited_by', 
        'deleted', 
        'added_by', 
        'deleted_by',
        'profile'
    ];
}
