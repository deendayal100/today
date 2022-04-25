<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundLog extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'amount',
        'type', 
        'method',
        'transaction_id',
        'payment_status',
        'widrawl_request_status',
        'created_at',
        'updated_at'
    ];

    function user(){
        return  $this->belongsTo('App\Models\User','user_id','id');
     }
}
