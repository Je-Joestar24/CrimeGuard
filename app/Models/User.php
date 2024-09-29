<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $table = 'users';
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'profile',
        'password',
        'user_name',
        'gender',
        'contact',
        'user_level',
        'first_name',
        'last_name',
        'middle_name',
        'current_address',
        'other_address',
        'deleted_by',
        'archived_at',
        'accepted_by',
        'accepted_at',
        'latitude',
        'longitude'
    ];
    

    public function currentAddress():BelongsTo
    {
        return $this->belongsTo(Addresses::class, 'current_address');
    }

    public function otherAddress():BelongsTo
    {
        return $this->belongsTo(Addresses::class, 'other_address');
    }

    public function incidetType():BelongsToMany
    {
        return $this->belongsToMany(IncidentTypes::class, 'id');
    }


    protected function password(): Attribute
    {
        return Attribute::make(set: fn ($value) => bcrypt($value));
    }

    /* has one from one table */
/* 
    public function citizenCredentials():HasOne
    {
        return $this->hasOne(CitizenCredentials::class, 'id');
    } */

    public function AdministeringOfficer():HasOne
    {
        return $this->hasOne(AdministeringOfficer::class, 'id');
    }
    
    /* Has many from one table */
    
    public function ChiefOfOffice():HasMany
    {
        return $this->hasMany(ChiefOfOffice::class, 'id');
    }

    public function IncidentCategories():HasMany
    {
        return $this->hasMany(IncidentCategories::class, 'id');
    }

    public function incidentNarative():HasMany
    {
        return $this->hasMany(IncidentNarative::class, 'id');
    }

    
    public function citizenCredentials()
    {
        return $this->hasOne(CitizenCredentials::class, 'user_id');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
