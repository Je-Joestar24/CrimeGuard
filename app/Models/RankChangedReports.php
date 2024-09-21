<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankChangedReports extends Model
{
    use HasFactory;
    
    protected $table = 'rank-changed-reports';
    protected $fillable = [
        'officer',
        'change_rank',
        'date_changed',
    ];
}
