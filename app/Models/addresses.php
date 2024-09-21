<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Model;

class Addresses extends EloquentModel{

    protected $table = 'addresses';

    protected $fillable = ['street', 'house_number', 'village', 'barangay', 'city', 'province', 'sitio', 'block'];

    public function user():HasOne
    {
        return $this->hasOne(User::class, 'id');
    }

    public function IncidentNarative():HasOne
    {
        return $this->hasOne(IncidentNarative::class, 'id');
    }
}