<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusPot extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_unique_id',
        'amount',
        'created_at',
        'updated_at'
    ];

   
}
