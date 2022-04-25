<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'player_id',
        'group_unique_id',
        'question_id',
        'question_set',
        'answer_time',
        'answer',
        'created_at',
        'updated_at'
    ];

}
