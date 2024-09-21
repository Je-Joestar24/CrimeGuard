<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChiefOfOffice extends Model
{
    protected $table = 'chief-of-office';

    protected $fillable = [
        'name',
        'contact',
        'email',
        'officer_id'        
    ];

    /* Belongs to */
    
    public function officer():BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }


    use HasFactory;


}
