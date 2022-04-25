<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameLog;
use App\Models\PlayerGroup;
use App\Models\AnteAmount;
use App\Models\HourlyAnteAmount;
use App\Models\HourlyQuestion;
use App\Models\NumberPlayer;
use App\Models\User;
use App\Models\Category;
use App\Models\Question;

class RecordController extends Controller
{
    public function group_view(){
        $group_record = GameLog::where(['game_type'=>'group'])->get();
        if(!empty($group_record))
        {
          foreach($group_record as $k=> $play)
          {
               $group_record[$k]->player_name = User::where(['id'=>$play->player_id])->value('name');
               $group_record[$k]->question = Question::where(['id'=>$play->question_id])->value('question');
          }
        }
        return view('Pages.admin.record.group',compact('group_record'));
    }

    public function tournament_view(){
        $group_record = GameLog::where(['game_type'=>'hourly'])->get();
        if(!empty($group_record))
        {
          foreach($group_record as $k=> $play)
          {
            $group_record[$k]->tl_attemped = HourlyQuestion::where(['tournament_unique_id'=>$play->group_unique_id,'player_id'=>$play->player_id])
            ->count();
            $group_record[$k]->tl_correct =  HourlyQuestion::where(['tournament_unique_id'=>$play->group_unique_id,
            'player_id'=>$play->player_id,'answer'=>'correct'])->count();
            $group_record[$k]->player_name = User::where(['id'=>$play->player_id])->value('name');
          }
        }
        return view('Pages.admin.record.hourly',compact('group_record'));
    }
  

   
}