<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\NumberPlayer;
use App\Models\AnteAmount;
use App\Models\GameLog;
use App\Models\GroupLive;
use App\Models\HourlyQuestion;
use App\Models\Question;
use App\Models\BonusPot;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class WebController extends Controller
{
   public function signup(Request $request){
       return view('Pages.frontend.signup');
   }

   public function signin(){
        return view('Pages.frontend.signin');
   }

   public function player_account(Request $request){
        $player_id = $request->session()->get('player_id');
       
      $player_info = User::where(['id'=>$player_id])->first();
        return view('Pages.frontend.player_account',compact('player_info'));
   }

   public function player_profile(Request $request){
     $player_id = $request->session()->get('player_id');
     $player_info = User::where(['id'=>$player_id])->first();
     return view('Pages.frontend.player_profile',compact('player_info'));
   }

   public function player_fund_management(){
        return view('Pages.frontend.player_fund_management');
   }

   public function player_game_history(Request $request){
     $group_res=GameLog::where(['game_type'=>'group','player_id'=>$request->session()->get('player_id')])->get();
     if(!empty($group_res)){
         foreach($group_res as $k=>$val1){
             $group_res[$k]->question = Question::where('id',$val1->question_id)->value('question');
             $group_res[$k]->player_name = User::where('id',$val1->player_id)->value('name');
         }
     }
     $hourly_res=GameLog::where(['game_type'=>'hourly','player_id'=>$request->session()->get('player_id')])->get();
        if(!empty($hourly_res)){
            foreach($hourly_res as $k=>$val2){
                $hourly_res[$k]->tl_attemped = HourlyQuestion::where(['tournament_unique_id'=>$val2->group_unique_id,'player_id'=>$val2->player_id])
               ->count();
               $hourly_res[$k]->tl_correct =  HourlyQuestion::where(['tournament_unique_id'=>$val2->group_unique_id,
               'player_id'=>$val2->player_id,'answer'=>'correct'])->count();
                $hourly_res[$k]->player_name = User::where('id',$val2->player_id)->value('name');
            }
        }
     return view('Pages.frontend.player_game_history',compact('group_res','hourly_res'));
   }

   public function send_invite(){
          return view('Pages.frontend.send_invite');
   }

   
   public function select_group(Request $request){
     $ante_amount_res = json_decode(Http::get('http://localhost/development/game_project/api/ante/amount'));
     $player_number_res = json_decode(Http::get('http://localhost/development/game_project/api/player/number'));
     if($ante_amount_res->status == true){
          $ante_amount = $ante_amount_res->data;
     }
     if($player_number_res->status == true){
          $number_player = $player_number_res->data;
     }  
     return view('Pages.frontend.select_group',compact('ante_amount','number_player'));
   }

   public function tournament_ante(){
        $ante_amount_res = json_decode(Http::get('http://localhost/development/game_project/api/hourly/ante/amount'));
        if($ante_amount_res->status == true){
               $ante_amount = $ante_amount_res->data;
          }
        return view('Pages.frontend.tournament_ante',compact('ante_amount'));
   }

   public function countdown_group(Request $request){
          $data=array(
               'player_id'=>$request->session()->get('player_id'),
               'ante_amount_id'=>$request->anteAmountId,
               'player_no_id'=>$request->playerNoId
          ); 
          $response = json_decode(Http::post('http://localhost/development/game_project/api/add/player/ingroup',$data));
          if(!empty($response)){
               Session::put('group_id',$response->group_id);
               //Session::put('group_unique_id',$response->group_unique_id);
          }
          return $response;
     }

     public function group_complete_check(Request $request){
          // $data=array(
          //      'group_id'=>$request->session()->get('group_id')
          // );  
          // return json_decode(Http::post('http://localhost/development/game_project/api/group/complete',$data));

          // $data=array(
          //      'group_id'=>$request->session()->get('group_id')
          // );  
          //  $json_data = json_decode(Http::post('http://localhost/development/game_project/api/group/complete',$data));
          //  if(!empty($json_data)){
          //      Session::put('group_unique_id',$json_data->group_unique_id);
          // }

          $group_res = Grouplive::where(['group_id'=>$request->session()->get('group_id'),'status'=>2])->get();
          if(count($group_res)>0){
               Session::put('group_unique_id',$group_res[0]->group_unique_id);
               return array('status'=>true,'message'=>'Success.');
              
          }else{
               return array('status'=>false,'message'=>'Failed.!');
          }
     }

     // public function group_complete_check(Request $request){
     //      // $data=array(
     //      //      'group_id'=>$request->session()->get('group_id')
     //      // );  
     //      // return json_decode(Http::post('http://localhost/development/game_project/api/group/complete',$data));

     //      $data=array(
     //           'group_id'=>$request->session()->get('group_id')
     //      );  
     //       $json_data = json_decode(Http::post('http://localhost/development/game_project/api/group/complete',$data));
     //       if(!empty($json_data)){
     //           Session::put('group_unique_id',$json_data->group_unique_id);
     //      }
     //      return $json_data;
     // }


   ///////
   public function player_signup(Request $request){
        $data=array(
             'name'=>$request->name,
             'alias'=>$request->alias,
             'email'=>$request->email,
             'password'=>$request->password,
             'role'=>97,
             'status'=>0,
        );
        if($request->hasFile('profile_image')){
          $filename=$request->profile_image->getClientOriginalName();
          $response = Http::attach(
               'image', file_get_contents($request->profile_image),$filename 
               )->post('http://localhost/development/game_project/api/user/register',$data);
          echo $response;
       }else{
          $response = Http::post('http://localhost/development/game_project/api/user/register',$data);
          echo $response;
       }
        
     }

     public function player_signin(Request $request){
          $data=array(
               'alias'=>$request->alias,
               'password'=>$request->password
          );
          $response = Http::post('http://localhost/development/game_project/api/login',$data);
          $d_json=json_decode($response);
          if(!empty($d_json->data)){
               Session::put('access_token',$d_json->access_token);
               Session::put('player_id',$d_json->data->id);
               if($d_json->data->image != null){     
                    Session::put('profile_image',$d_json->data->image);
               }
               Session::put('wallet_amnt',$d_json->data->wallet);
               Session::put('player_name',$d_json->data->name);
          }   
          echo $response;
     }

     public function player_profile_update(Request $request){
          $data=array(
               'id'=>$request->session()->get('player_id'),
               'name'=>$request->name,
               'alias'=>$request->alias,
               'email'=>$request->email,
               'password'=>$request->password,
               'new_password'=>$request->new_password
          );
          if($request->hasFile('profile_image')){
            $filename=$request->profile_image->getClientOriginalName();
            $response = Http::attach(
                 'image', file_get_contents($request->profile_image),$filename 
                 )->post('http://localhost/development/game_project/api/profile/update',$data);
                 $user_res = User::where('id',$request->session()->get('player_id'))->first();
                 if($user_res != '' && $user_res != null){
                    if(isset($user_res->image) && $user_res->image != null){
                         Session::put('profile_image',$user_res->image);
                         Session::put('player_name',$user_res->name); 
                    }
                 }
            echo $response;
         }else{
            $response = Http::post('http://localhost/development/game_project/api/profile/update',$data);
            $user_res = User::where('id',$request->session()->get('player_id'))->first();
                 if($user_res != '' && $user_res != null){
                    Session::put('player_name',$user_res->image);
                 }
            echo $response;
         }        
     }
     
     public function active_players(Request $request){
          $data=array(
               'ante_amount_id'=>$request->anteAmountId,
               'player_no_id'=>$request->playerNoId
          );
          echo Http::post('http://localhost/development/game_project/api/group/live/players',$data);
     }

     public function group_countdown(){
          return view('Pages.frontend.countdown_group');
     }

     public function remove_from_group(Request $request){
          $data=array(
               'player_id'=>$request->session()->get('player_id'),
               'group_id'=>$request->session()->get('group_id'),
          );  
          $response = json_decode(Http::post('http://localhost/development/game_project/api/remove/player/fromgroup',$data));
          return $response;
     }

     public function question_screen(){
          return view('Pages.frontend.qa_screen');
     }
     

     public function get_question(Request $request){
          $data=array(
               'player_id'=>$request->session()->get('player_id'),
               'group_id'=>$request->session()->get('group_id'),
          );  
          return json_decode(Http::post('http://localhost/development/game_project/api/get/question',$data));
     }

     public function player_answer(Request $request){
          $data=array(
               'player_id'=>$request->session()->get('player_id'),
               'group_id'=>$request->session()->get('group_id'),
               'group_unique_id'=>$request->session()->get('group_unique_id'),
               'question_id'=>$request->question_id,
               'play_time'=>$request->play_time,
               'game_type'=>$request->game_type,
               'answer'=>$request->ques_ans,
          );  
          return json_decode(Http::post('http://localhost/development/game_project/api/player/answer',$data));
     }

     public function all_players_answer(Request $request){
          $data=array(
               'group_unique_id'=>$request->session()->get('group_unique_id'),
               'game_type'=>'group',
               'answer'=>'noanswer',
          );  
          return json_decode(Http::post('http://localhost/development/game_project/api/all/players/answer',$data));
     }

     public function auto_answer(Request $request){
          $data=array(
               'group_unique_id'=>$request->session()->get('group_unique_id'),
               'game_type'=>'group',
               'answer'=>'noanswer',
          );  
         // return json_decode(Http::post('http://localhost/development/game_project/api/all/players/answer',$data));
         return json_decode(Http::post('http://localhost/development/game_project/api/play/group/result',$data));
     }

     public function player_hourly_answer(Request $request){
          $data=array(
               'player_id'=>$request->session()->get('player_id'),
               'tournament_unique_id'=>$request->session()->get('tournament_unique_id'),
               'question_id'=>$request->question_id,
               // 'play_time'=>$request->play_time,
               'game_type'=>$request->game_type,
               'answer'=>$request->ques_ans,
          );  
          return json_decode(Http::post('http://localhost/development/game_project/api/player/hourly/answer',$data));
     }
     
     public function result_preloader(){
          return view('Pages.frontend.preloader');
     }

     public function hourly_result_preloader(){
          return view('Pages.frontend.preloader_hourly');
     }

     public function result_page(Request $request){
          $id = $request->session()->get('player_id');
          $data=array(
               'group_unique_id'=>$request->session()->get('group_unique_id'),
               'player_id'=>$id,
          );  
          $response = json_decode(Http::post('http://localhost/development/game_project/api/game/detail',$data));
          $resultData = $response->data->game_detail;
          $game_amnt = $response->data->game_amount;
          $game_status = $response->data->game_status;
          return view('Pages.frontend.result_screen',compact('game_status','resultData','game_amnt'));
     }
     
     public function hourly_result_page(Request $request){
          $data=array(
               'tournament_unique_id'=>$request->session()->get('tournament_unique_id'),
               'player_id'=>$request->session()->get('player_id'),
               'game_type'=>'hourly'
          );  
          $response = json_decode(Http::post('http://localhost/development/game_project/api/hourly/game/detail',$data));
          return $response;         
     }

     public function hourly_result(Request $request){
          $tournament_unique_id = $request->session()->get('tournament_unique_id');
          $player_id = $request->session()->get('player_id');
          $bonuspot = BonusPot::where(['group_unique_id'=>$tournament_unique_id])->value('amount');
          $h_game_detail = GameLog::where(['group_unique_id'=>$tournament_unique_id])->get();
        if(!empty($h_game_detail))
        {
          foreach($h_game_detail as $k=> $play)
          {
               $h_game_detail[$k]->tl_attemped = HourlyQuestion::where(['tournament_unique_id'=>$tournament_unique_id,'player_id'=>$play->player_id])
               ->count();
               $h_game_detail[$k]->tl_correct =  HourlyQuestion::where(['tournament_unique_id'=>$tournament_unique_id,
               'player_id'=>$play->player_id,'answer'=>'correct'])->count();
               $h_game_detail[$k]->player_name = User::where(['id'=>$play->player_id])->value('name');
          }
        }
        $prize_amnt = GameLog::where(['group_unique_id'=>$tournament_unique_id,'player_id'=>$player_id])->first();
        return view('Pages.frontend.lose_screen_tournament',compact('h_game_detail','prize_amnt','bonuspot'));
     }

     public function countdown_tournament(){
          return view('Pages.frontend.countdown_tournament');
     }


     // public function qa_tournament(Request $request){
     //      $data=array(
     //           'player_id'=>$request->session()->get('player_id'),
     //           'tournament_unique_id'=>$request->session()->get('tournament_unique_id')
     //      ); 
     //     $data_res =  json_decode(Http::post('http://localhost/development/game_project/api/get/tournament/question',$data));
     //     $data_array=$data_res->data;
     //     if($data_res->status == 200 && !empty($data_array) ){
     //           return view('Pages.frontend.qa_tournament',compact('data_array'));
     //     }
          
     // }

     public function qa_tournament(Request $request){
          $data=array(
               'tournament_unique_id'=>$request->session()->get('tournament_unique_id')
          );
         $data_res =  json_decode(Http::post('http://localhost/development/game_project/api/get/tournament/question',$data));      
         if($data_res->status == 200 ){
              $data_array = $data_res->data;
               return view('Pages.frontend.qa_tournament',compact('data_array'));
         }
     }

     public function group_hourly(Request $request){
          $data=array(
               'player_id'=>$request->session()->get('player_id'),
               'ante_amount_id'=>$request->anteAmountId
          ); 
          $response = json_decode(Http::post('http://localhost/development/game_project/api/add/player/tournament',$data));
          if(!empty($response)){
               Session::put('tournament_unique_id',$response->tournament_unique_id);
          }
          return $response;
     }

     public function tournament_question(Request $request){
          $data=array(
               'player_id'=>$request->session()->get('player_id'),
               'tournament_unique_id'=>$request->session()->get('tournament_unique_id')
          ); 
          return json_decode(Http::post('http://localhost/development/game_project/api/get/tournament/question',$data));
          
     }

     public function forget_password(Request $request){
         return view('Pages.frontend.forgetpass');
     }

     public function reset_password(Request $request){
           $tomail = $request->email;
          $email_check = User::where('email',$tomail)->first();
          if($email_check != '' && $email_check != null){
               $sub = 'Password Reset Link from Trivia';
               $data = array('link'=> url('reset-password-page').'/'.$email_check->id);
               $mail_res = Mail::send(['text'=>'Pages.frontend.mail'], $data, function($message) use($tomail,$sub) {
               $message->to($tomail, 'Registered Player')->subject
                    ($sub);
                    $message->from(env('MAIL_USERNAME'),'Trivia');
               });
               return response()->json(['status'=>200,'message'=>'Success.']);
          }else{
               return response()->json(['status'=>202,'message'=>'The email is not registered with Trivia.']);
          }
        
     }

     public function reset_password_page(){
          return view('Pages.frontend.forget_password');
     }
  
}