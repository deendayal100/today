<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FundLog;

class StasticsController extends Controller
{
    public function index(){
        $players = User::where('role',97)->get();
        if(!empty($players))
        {
            foreach($players as $k=> $play)
            {
                $players[$k]->player_deposit = FundLog::where("user_id",$play->id)->where("type","credit")->sum('amount');
                $players[$k]->player_widrawl = FundLog::where("user_id",$play->id)->where("type","debit")->sum('amount');
            }
        }
        return view('Pages.admin.stastics.index',compact('players'));
    }
}
