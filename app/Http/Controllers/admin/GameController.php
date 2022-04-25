<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameLog;
use App\Models\PlayerGroup;
use App\Models\AnteAmount;
use App\Models\HourlyAnteAmount;
use App\Models\NumberPlayer;
use App\Models\User;
use App\Models\Category;
use App\Models\Question;

class GameController extends Controller
{
    public function index(){
        $players = GameLog::select('game_logs.*','users.name','questions.question')
        ->join('users', 'users.id', '=', 'game_logs.player_id')
        ->join('questions', 'questions.id', '=', 'game_logs.question_id')
        ->get();
        $cat = Question::groupBy('category')->get();
        $question_asked = GameLog::select('questions.id as ques_id','questions.question')
        ->join('questions', 'questions.id', '=', 'game_logs.question_id')
        ->get();
        return view('Pages.admin.game.index',compact('players','cat','question_asked'));
    }

    public function show($id){
      $history = GameLog::where('player_id',$id)->with('fund')->with('category')->get();
      return view('Pages.admin.history.index',compact('history'));
    }

    public function group_ante_amount(){
        $ante_amount1 = AnteAmount::get();
        $ante_amount=array();
        foreach($ante_amount1 as $val){
            array_push($ante_amount,$val->ante_amount);
        }
        return view('Pages.admin.player_group.anteamount',compact('ante_amount'));
    }

    public function hourly_ante_amount(){
        $ante_amount1 = HourlyAnteAmount::get();
        $ante_amount=array();
        foreach($ante_amount1 as $val){
            array_push($ante_amount,$val->ante_amount);
        }
        return view('Pages.admin.hourly.anteamount',compact('ante_amount'));
    }

    public function update_ante_amount(Request $request){
        $data = array($request->ante_amount1,$request->ante_amount2,$request->ante_amount3);
        for($i=0;$i<count($data);$i++){
            $update_amount = AnteAmount::where('id',$i+1)->update([
                'ante_amount'=> $data[$i],
               
            ]);
        }
        if($update_amount > 0){
            $result=array("status"=>true,"message"=>"Ante Amount Updated Successfully ");
        }else{
            $result=array("status"=>false,"message"=>"Failed! ");
        }
        echo json_encode($result);
    }

    public function update_hourly_ante_amount(Request $request){
        $data = array($request->ante_amount1,$request->ante_amount2,$request->ante_amount3);
        for($i=0;$i<count($data);$i++){
            $update_amount = HourlyAnteAmount::where('id',$i+1)->update([
                'ante_amount'=> $data[$i],
               
            ]);
        }
        if($update_amount > 0){
            $result=array("status"=>true,"message"=>"Ante Amount Updated Successfully ");
        }else{
            $result=array("status"=>false,"message"=>"Failed! ");
        }
        echo json_encode($result);
    }

    

    public function group_player_no(){
        $ante_amount1 = NumberPlayer::get();
        $ante_amount=array();
        foreach($ante_amount1 as $val){
            array_push($ante_amount,$val->player_number);
        }
        return view('Pages.admin.player_group.playerno',compact('ante_amount'));
    }

    public function update_player_no(Request $request){
        $data = array($request->ante_amount1,$request->ante_amount2,$request->ante_amount3);
        for($i=0;$i<count($data);$i++){
            $update_amount = NumberPlayer::where('id',$i+1)->update([
                'player_number'=> $data[$i],
               
            ]);
        }
        if($update_amount > 0){
            $result=array("status"=>true,"message"=>"Number of Players Updated Successfully ");
        }else{
            $result=array("status"=>false,"message"=>"Failed! ");
        }
        echo json_encode($result);
    }

    public function serach_game_record(Request $request){
        /////filter for all 
        if($request->game_date != ""  && $request->game_date != null && $request->game_record_cat != "" 
        && $request->game_record_cat != "null" && $request->game_record_question != "" && $request->game_record_question != "null"){     
            if($request->game_won_loss == 1 || $request->game_won_loss == 2)
            {
                $players = GameLog::select('game_logs.*','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->where('game_logs.category', 'LIKE', '%'.$request->game_record_cat.'%')
                ->where('game_logs.question_id', 'LIKE', '%'.$request->game_record_question.'%')
                ->where('game_logs.game_status', 'LIKE', '%'.$request->game_won_loss.'%')
                ->where('game_logs.created_at', 'LIKE', '%'.$request->game_date.'%')
                ->get();
                $cat = Question::groupBy('category')->get();
                $question_asked = GameLog::select('questions.id as ques_id','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->get();
                return view('Pages.admin.game.index',compact('players','cat','question_asked'));
            }
            else
            {
                $players = GameLog::select('game_logs.*','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->where('game_logs.category', 'LIKE', '%'.$request->game_record_cat.'%')
                ->where('game_logs.question_id', 'LIKE', '%'.$request->game_record_question.'%')
                ->where('game_logs.created_at', 'LIKE', '%'.$request->game_date.'%')
                ->get();
                $cat = Question::groupBy('category')->get();
                $question_asked = GameLog::select('questions.id as ques_id','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->get();
                return view('Pages.admin.game.index',compact('players','cat','question_asked'));
            }       
        }
        ////-- filter for category,asked question, game date
        if($request->game_record_cat != "" && $request->game_record_cat != "null" && $request->game_record_question != "" && $request->game_record_question != "null"  
        && $request->game_won_loss == 0 && $request->game_date != null && $request->game_date != ""){
            $players = GameLog::select('game_logs.*','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->where('game_logs.category', 'LIKE', '%'.$request->game_record_cat.'%')
            ->where('game_logs.question_id', 'LIKE', '%'.$request->game_record_question.'%')
            ->where('game_logs.created_at', 'LIKE', '%'.$request->game_date.'%')
            ->get();
            $cat = Question::groupBy('category')->get();
            $question_asked = GameLog::select('questions.id as ques_id','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->get();
            return view('Pages.admin.game.index',compact('players','cat','question_asked'));
        }

        //------ filter for category, question, won/loss
        if($request->game_record_cat != "" && $request->game_record_cat != "null" && 
        $request->game_record_question != "" && $request->game_record_question != "null"){
            if($request->game_won_loss == 1 || $request->game_won_loss == 2)
            { 
                $players = GameLog::select('game_logs.*','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->where('game_logs.category', 'LIKE', '%'.$request->game_record_cat.'%')
                ->where('game_logs.question_id', 'LIKE', '%'.$request->game_record_question.'%')
                ->where('game_logs.game_status', 'LIKE', '%'.$request->game_won_loss.'%')
                ->get();
                $cat = Question::groupBy('category')->get();
                $question_asked = GameLog::select('questions.id as ques_id','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->get();
                return view('Pages.admin.game.index',compact('players','cat','question_asked'));
            }else{
                $players = GameLog::select('game_logs.*','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->where('game_logs.category', 'LIKE', '%'.$request->game_record_cat.'%')
                ->where('game_logs.question_id', 'LIKE', '%'.$request->game_record_question.'%')
                ->get();
                $cat = Question::groupBy('category')->get();
                $question_asked = GameLog::select('questions.id as ques_id','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->get();
                return view('Pages.admin.game.index',compact('players','cat','question_asked'));
            }    
           
        }
        //------- filter for category, won/loss, game date
        if($request->game_record_cat != "" && $request->game_record_cat != "null" && $request->game_date != "" &&  $request->game_date != null){
            if($request->game_won_loss==1 || $request->game_won_loss ==2)
            { 
                $players = GameLog::select('game_logs.*','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->where('game_logs.category', 'LIKE', '%'.$request->game_record_cat.'%')
                ->where('game_logs.game_status', 'LIKE', '%'.$request->game_won_loss.'%')
                ->where('game_logs.created_at', 'LIKE', '%'.$request->game_date.'%')
                ->get();
                $cat = Question::groupBy('category')->get();
                $question_asked = GameLog::select('questions.id as ques_id','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->get();
                return view('Pages.admin.game.index',compact('players','cat','question_asked'));
            }else{
                $players = GameLog::select('game_logs.*','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->where('game_logs.category', 'LIKE', '%'.$request->game_record_cat.'%')
                ->where('game_logs.created_at', 'LIKE', '%'.$request->game_date.'%')
                ->get();
                $cat = Question::groupBy('category')->get();
                $question_asked = GameLog::select('questions.id as ques_id','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->get();
                return view('Pages.admin.game.index',compact('players','cat','question_asked'));
            }    
          
               
        }
        //------- filter for question, won/loss, game date
        if( $request->game_record_question != "" && $request->game_record_question != "null"  && $request->game_date != "" && $request->game_date != null){
            if($request->game_won_loss==1 || $request->game_won_loss ==2)
            { 
                $players = GameLog::select('game_logs.*','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->where('game_logs.question_id', 'LIKE', '%'.$request->game_record_question.'%')
                ->where('game_logs.game_status', 'LIKE', '%'.$request->game_won_loss.'%')
                ->where('game_logs.created_at', 'LIKE', '%'.$request->game_date.'%')
                ->get();
                $cat = Question::groupBy('category')->get();
                $question_asked = GameLog::select('questions.id as ques_id','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->get();
                return view('Pages.admin.game.index',compact('players','cat','question_asked'));
            }else{
                $players = GameLog::select('game_logs.*','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->where('game_logs.question_id', 'LIKE', '%'.$request->game_record_question.'%')
                ->where('game_logs.created_at', 'LIKE', '%'.$request->game_date.'%')
                ->get();
                $cat = Question::groupBy('category')->get();
                $question_asked = GameLog::select('questions.id as ques_id','questions.question')
                ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                ->get();
                return view('Pages.admin.game.index',compact('players','cat','question_asked'));
            }
           
               
        }
        //-------filter for category,question 
        if( 
            $request->game_record_cat != "" && $request->game_record_cat != "null" && $request->game_record_question != 0  && $request->game_won_loss ==0){
            
            $players = GameLog::select('game_logs.*','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->where('game_logs.category', 'LIKE', '%'.$request->game_record_cat.'%')
            ->where('game_logs.question_id', 'LIKE', '%'.$request->game_record_question.'%')
            ->get();
            $cat = Question::groupBy('category')->get();
            $question_asked = GameLog::select('questions.id as ques_id','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->get();
            return view('Pages.admin.game.index',compact('players','cat','question_asked'));
            
        }

        //-------filter for category, won/loss
        if($request->game_record_cat != "" && $request->game_record_cat != "null"  && $request->game_won_loss != "" && $request->game_won_loss != null ){
                if($request->game_won_loss==1 || $request->game_won_loss ==2)
                { 
                    $players = GameLog::select('game_logs.*','questions.question')
                    ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                    ->where('game_logs.category', 'LIKE', '%'.$request->game_record_cat.'%')
                    ->where('game_logs.game_status', 'LIKE', '%'.$request->game_won_loss.'%')
                    ->get();
                    $cat = Question::groupBy('category')->get();
                    $question_asked = GameLog::select('questions.id as ques_id','questions.question')
                    ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                    ->get();
                    return view('Pages.admin.game.index',compact('players','cat','question_asked'));
                }else{
                    $players = GameLog::select('game_logs.*','questions.question')
                    ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                    ->where('game_logs.category', 'LIKE', '%'.$request->game_record_cat.'%')
                    ->get();
                    $cat = Question::groupBy('category')->get();
                    $question_asked = GameLog::select('questions.id as ques_id','questions.question')
                    ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                    ->get();
                    return view('Pages.admin.game.index',compact('players','cat','question_asked'));
                }    
           
        }

        //-------filter for category, game date
        if($request->game_record_cat != "" && $request->game_record_cat != "null"  && $request->game_date != "" &&  $request->game_date != null  && $request->game_won_loss ==0){
            
            $players = GameLog::select('game_logs.*','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->where('game_logs.category', 'LIKE', '%'.$request->game_record_cat.'%')
            ->where('game_logs.created_at', 'LIKE', '%'.$request->game_date.'%')
            ->get();
            $cat = Question::groupBy('category')->get();
            $question_asked = GameLog::select('questions.id as ques_id','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->get();
            return view('Pages.admin.game.index',compact('players','cat','question_asked'));
            
        }

        //-------filter for question, won/loss
        if($request->game_record_question != "" && $request->game_record_question != "null"){
                 
                if($request->game_won_loss==1 || $request->game_won_loss ==2)
                { 
                    $players = GameLog::select('game_logs.*','questions.question')
                    ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                    ->where('game_logs.question_id', 'LIKE', '%'.$request->game_record_question.'%')
                    ->where('game_logs.game_status', 'LIKE', '%'.$request->game_won_loss.'%')
                    ->get();
                    $cat = Question::groupBy('category')->get();
                    $question_asked = GameLog::select('questions.id as ques_id','questions.question')
                    ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                    ->get();
                    return view('Pages.admin.game.index',compact('players','cat','question_asked'));
                }else{
                    
                    $players = GameLog::select('game_logs.*','questions.question')
                    ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                    ->where('game_logs.question_id', 'LIKE', '%'.$request->game_record_question.'%')
                    ->get();
                    $cat = Question::groupBy('category')->get();
                    $question_asked = GameLog::select('questions.id as ques_id','questions.question')
                    ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                    ->get();
                    return view('Pages.admin.game.index',compact('players','cat','question_asked'));
                }    
           
        }

        //-------filter for question, game date
        if( $request->game_record_question != "" && $request->game_record_question != "null" &&  $request->game_date != "" && $request->game_date != null  && $request->game_won_loss ==0){
               
            $players = GameLog::select('game_logs.*','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->where('game_logs.question_id', 'LIKE', '%'.$request->game_record_question.'%')
            ->where('game_logs.created_at', 'LIKE', '%'.$request->game_date.'%')
            ->get();
            $cat = Question::groupBy('category')->get();
            $question_asked = GameLog::select('questions.id as ques_id','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->get();
            return view('Pages.admin.game.index',compact('players','cat','question_asked'));
           
        }

        //-------filter for  won/loss,game date
        if(  $request->game_date != "" && $request->game_date != null){
                if($request->game_won_loss==1 || $request->game_won_loss ==2)
                {
                   
                    $players = GameLog::select('game_logs.*','questions.question')
                    ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                    ->where('game_logs.game_status', 'LIKE', '%'.$request->game_won_loss.'%')
                    ->where('game_logs.created_at', 'LIKE', '%'.$request->game_date.'%')
                    ->get();
                    $cat = Question::groupBy('category')->get();
                    $question_asked = GameLog::select('questions.id as ques_id','questions.question')
                    ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                    ->get();
                    return view('Pages.admin.game.index',compact('players','cat','question_asked'));
                }else{
                   
                    $players = GameLog::select('game_logs.*','questions.question')
                    ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                    ->where('game_logs.created_at', 'LIKE', '%'.$request->game_date.'%')
                    ->get();
                    $cat = Question::groupBy('category')->get();
                    $question_asked = GameLog::select('questions.id as ques_id','questions.question')
                    ->join('questions', 'questions.id', '=', 'game_logs.question_id')
                    ->get();
                    return view('Pages.admin.game.index',compact('players','cat','question_asked'));
                }    
           
        }

        //-------filter for category
        if( $request->game_record_cat != "" && $request->game_record_cat != "null"  && $request->game_won_loss ==0){
           
            $players = GameLog::select('game_logs.*','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->where('game_logs.category', 'LIKE', '%'.$request->game_record_cat.'%')
            ->get();
            $cat = Question::groupBy('category')->get();
            $question_asked = GameLog::select('questions.id as ques_id','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->get();
            return view('Pages.admin.game.index',compact('players','cat','question_asked'));
           
        }

        //-------filter for question
        if( $request->game_record_question != "" && $request->game_record_question != "null" && $request->game_won_loss ==0){           
            $players = GameLog::select('game_logs.*','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->where('game_logs.question_id', 'LIKE', '%'.$request->game_record_question.'%')
            ->get();
            $cat = Question::groupBy('category')->get();
            $question_asked = GameLog::select('questions.id as ques_id','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->get();
            return view('Pages.admin.game.index',compact('players','cat','question_asked'));
           
        }

        //-------filter for  won/loss
       
        if($request->game_won_loss==1 || $request->game_won_loss ==2)
        {
           
            $players = GameLog::select('game_logs.*','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->where('game_logs.game_status', 'LIKE', '%'.$request->game_won_loss.'%')
            ->get();
            $cat = Question::groupBy('category')->get();
            $question_asked = GameLog::select('questions.id as ques_id','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->get();
            return view('Pages.admin.game.index',compact('players','cat','question_asked'));
        }else{
           
            $players = GameLog::select('game_logs.*','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->get();
            $cat = Question::groupBy('category')->get();
            $question_asked = GameLog::select('questions.id as ques_id','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->get();
            return view('Pages.admin.game.index',compact('players','cat','question_asked'));
        }    
           

        //-------filter for game date
        
        if( $request->game_date != "" && $request->game_date != null  && $request->game_won_loss ==0){
           
            $players = GameLog::select('game_logs.*','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->where('game_logs.created_at', 'LIKE', '%'.$request->game_date.'%')
            ->get();
            $cat = Question::groupBy('category')->get();
            $question_asked = GameLog::select('questions.id as ques_id','questions.question')
            ->join('questions', 'questions.id', '=', 'game_logs.question_id')
            ->get();
            return view('Pages.admin.game.index',compact('players','cat','question_asked'));
        } 

    }

   
}