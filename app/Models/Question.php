<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'category',
        'difficulty',
        'question',
        'wrong_answer1',
        'wrong_answer2',
        'wrong_answer3',
        'correct'
    ];

    function category(){
        return  $this->belongsTo('App\Models\Category','category_id','id');
    }

    public $timestamps = false;
}
