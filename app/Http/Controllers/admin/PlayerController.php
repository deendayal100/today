<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use DB;

class PlayerController extends Controller
{
   public function index(){
        $users = User::where('role',97)->get();
        return view('Pages.admin.player',compact('users'));
   }

   public function storePlayer(Request $request){
        $valiation = Validator::make($request->all(),[
            "name"=>'required',
            'alias'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'password'=>'required',
            'confirm_password'=>'required',
        ]);
        if($valiation->fails()){
            $result=array("status"=>false,"message"=>"valiation Failed",'errors'=>$valiation->errors());
        }else{
            $res = User::where('email',$request->email)->orWhere('phone',$request->phone)->orWhere('alias',$request->phone)->first();
            if($res){
                        $result=array("status"=>false,"message"=>"User Already Exists ","data"=>1);
            }else{
                if($request->password != $request->confirm_password){
                    $result=array("status"=>false,"message"=>"Password Don't Match! ","data"=>0);
                }else{
                    $unique_res = User::where('role',97)->latest()->first();
                    if($unique_res == null && $unique_res == ''){
                        $unique_id = "000001";
                    }else{
                        $unique_id =sprintf('%06d', $unique_res->unique_id + 1);
                    }
                    $user = new User();
                    $user->role=97;
                    $user->unique_id=$unique_id;
                    $user->name=$request->name;
                    $user->alias=$request->alias;
                    $user->email=$request->email;
                    $user->phone=$request->phone;
                    $user->password=Hash::make($request->password);
                    $user->status=0;
                    $user->save();
                    $result=array("status"=>true,"message"=>"Player Created Successfully ","data"=>$user);
                }       
            }
        }
        echo json_encode($result);
   }

   public function updatePlayer(Request $request){
    $valiation = Validator::make($request->all(),[
        "name"=>'required',
        'email'=>'required',
        'phone'=>'required'
    ]);
    if($valiation->fails()){
        $result=array("status"=>false,"message"=>"valiation Failed",'errors'=>$valiation->errors());
    }else{
        
        $res = User::where('id','!=',$request->player_id)->where('email',$request->email)->first();
        $res1 = User::where('id','!=',$request->player_id)->Where('phone',$request->phone)->first();
        if(isset($res) || isset($res1)){
            $result=array("status"=>false,"message"=>"User Already Exists ","data"=>1);
        }else{
            $update_player = User::where('id',$request->player_id)->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
            ]);
            if($update_player == 1){
                $result=array("status"=>true,"message"=>"Player Updated Successfully ","data"=>$update_player);
            }else{
                $result=array("status"=>false,"message"=>"Failed! ","data"=>$update_player);
            }
        }
    }
    echo json_encode($result);
   }

   public function player_change_Status(Request $request){      
        User::where('id',$request->user_id)->update(
            [
                'status'=>$request->status
            ]
        );
        return 'true';
   }

   public function delete($id){
       User::where('id',$id)->delete();
       return redirect('/player_list');
   }

   public function detailPlayer(Request $request){
     return  User::where('id',$request->player_id)->get();
   }
}
