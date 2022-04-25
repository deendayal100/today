<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourlyQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'player_id',
        'tournament_unique_id',
        'question_id',
        'created_at',
        'updated_at'
    ];

}
