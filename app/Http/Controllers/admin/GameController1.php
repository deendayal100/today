<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameLog;
use App\Models\PlayerGroup;
use App\Models\AnteAmount;
use App\Models\NumberPlayer;
use App\Models\User;
use App\Models\Category;

class GameController extends Controller
{
    public function index(){
        $players = User::where('role',97)->get();
        if(!empty($players))
        {
            foreach($players as $k=> $play)
            {
                $player_count = GameLog::where("player_id",$play->id)->count();
                $players[$k]->player_count = $player_count;
                $players[$k]->game_win = GameLog::where("player_id",$play->id)->where("game_status","1")->count();
                $players[$k]->game_loss = GameLog::where("player_id",$play->id)->where("game_status","2")->count();
                $avg = GameLog::where("player_id",$play->id)->avg('play_time');
                if(!empty($avg))
                {
                    $players[$k]->playser_avg=$avg;
                }
                else
                {
                    $players[$k]->playser_avg=0;
                }
            }
        }
        return view('Pages.admin.game.index',compact('players'));
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

    public function update_ante_amount(Request $request){
        $data = array($request->ante_amount1,$request->ante_amount2,$request->ante_amount3);
        for($i=0;$i<count($data);$i++){
            $update_amount = AnteAmount::where('id',$i+1)->update([
                'ante_amount'=> $data[$i],
               
            ]);
        }
        if($update_amount == 1){
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
        if($update_amount == 1){
            $result=array("status"=>true,"message"=>"Number of Players Updated Successfully ");
        }else{
            $result=array("status"=>false,"message"=>"Failed! ");
        }
        echo json_encode($result);
    }

    
}
