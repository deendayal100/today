<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumberPlayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_number',
        'created_at',
        'updated_at'
    ];

}
