<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupLive extends Model
{
    use HasFactory;
    protected $fillable = [
        'player_id',
        'group_id',
        'ante_amount_id',
        'player_no_id',
        'group_unique_id',
        'question_id',
        'created_at',
        'updated_at'
    ];

}
