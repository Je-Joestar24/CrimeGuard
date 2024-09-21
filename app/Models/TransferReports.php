<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferReports extends Model
{
    use HasFactory;
    
    protected $table = 'transfer-reports';
    protected $fillable = [
        'officer',
        'transfer',
        'date_transferred',
    ];
}
