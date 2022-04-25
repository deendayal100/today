<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\NumberPlayer;
use App\Models\AnteAmount;

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

   public function player_game_history(){
        return view('Pages.frontend.player_game_history');
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
               Session::put('group_unique_id',$response->group_unique_id);
          }
          return $response;
     }

     public function group_complete_check(Request $request){
          $data=array(
               'group_id'=>$request->session()->get('group_id')
          );  
          return json_decode(Http::post('http://localhost/development/game_project/api/group/complete',$data));
     }
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
               Session::put('profile_image',$d_json->data->image);
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
            echo $response;
         }else{
            $response = Http::post('http://localhost/development/game_project/api/profile/update',$data);
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

     public function result_preloader(){
          return view('Pages.frontend.preloader');
     }

     public function result_page(Request $request){
          $data=array(
               'group_unique_id'=>$request->session()->get('group_unique_id')
          );  
          $response = json_decode(Http::post('http://localhost/development/game_project/api/game/detail',$data));
          $resultData = $response->data;
          $resArray = array();
          $id = $request->session()->get('player_id');
          if(!empty($resultData))
          {             
               foreach($resultData as $d )
               {
                    if($d->player_id == $id)
                    {
                         array_push($resArray,$d);
                    }
               }
          }
          return view('Pages.frontend.result_screen',compact('resArray','resultData'));
     }

     public function countdown_tournament(){
          return view('Pages.frontend.countdown_tournament');
     }

     public function qa_tournament(){
          
          return view('Pages.frontend.qa_tournament');
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
  
}