<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FundLog;

class FundsController extends Controller 
{
    public function index(){
        $funds = FundLog::where('type','credit')->with('user')->get();
        return view('Pages.admin.funds.funds_deposit',compact('funds'));
    }

    public function widrawl_index(){
        $funds = FundLog::where('type','debit')->with('user')->get();
        return view('Pages.admin.funds.funds_widrawl',compact('funds'));
    }

    public function widrawl_request_status(Request $request){
        $funds=FundLog::where('id',$request->fund_id)->update(
            [
                'widrawl_request_status'=>$request->status
            ]
        );
        if($funds == 1){
            return 'true';
        }else{
            return 'false';
        }
    }
}
