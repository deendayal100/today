<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourlyAnteAmount extends Model
{
    use HasFactory;

    protected $fillable = [
        'ante_amount',
        'created_at',
        'updated_at'
    ];

}
