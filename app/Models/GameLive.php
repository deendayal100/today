<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameLive extends Model
{
    use HasFactory;
    protected $fillable = [
        'player_id',
        'group_unique_id',
        'question_id',
        'answer_time',
        'created_at',
        'updated_at'
    ];

}
