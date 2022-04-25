<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourlyGroupLive extends Model
{
    use HasFactory;
    protected $fillable = [
        'player_id',
        'ante_amount_id',
        'tournament_unique_id',
        'question_id',
        'start_time',
        'end_time',
        'created_at',
        'updated_at'
    ];

}
