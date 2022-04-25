<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'game_status',
        'question_id',
        'group_unique_id',
        'group_id',
        'answer',
        'category',
        'play_time',
        'game_status',
        'game_type',
        'status',
        'created_at',
        'updated_at'
    ];

    function fund(){
        return  $this->belongsTo('App\Models\FundLog','player_id','user_id');
    }

     function category(){
        return  $this->belongsTo('App\Models\Question','question_id','id');
    }
}
