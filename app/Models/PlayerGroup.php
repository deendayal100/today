<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'ante_amount1',
        'ante_amount2',
        'ante_amount3',
        'player_no1',
        'player_no2',
        'player_no3',
        'created_at',
        'updated_at'
    ];

}
