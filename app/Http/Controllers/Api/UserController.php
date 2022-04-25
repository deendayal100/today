<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\User;
use App\Models\AnteAmount;
use App\Models\HourlyAnteAmount;
use App\Models\NumberPlayer;
use App\Models\GroupLive;
use App\Models\HourlyGrouplive;
use App\Models\HourlyQuestion;
use App\Models\GroupQuestion;
use App\Models\BonusPot;
use App\Models\GameLive;
use App\Models\GameLog;
use App\Models\Question;
use App\Models\TimeSlot;
class UserController extends Controller
{
    //user register 
    public function userRegister(Request $request) 
    {
        $validator = Validator::make(['name'=>$request->name],[
            'name' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('name')]);
        }
        $validator = Validator::make(['alias'=>$request->alias],[
            'alias' => 'required|string|unique:users'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('alias')]);
        }
        $validator = Validator::make(['email'=>$request->email],[
            'email' => 'required|email|unique:users'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('email')]);
        }
        // $validator = Validator::make(['image'=>$request->image],[
        //     'image' => 'required'
        // ]);
        // if($validator->fails()){
        //     return response()->json(['status'=>201,'message'=>$validator->errors()->first('image')]);
        // }
        if($request->hasFile('image')){
            $file_image=$request->file('image');
            $ext=$file_image->getClientOriginalExtension();
            $fileimage=rand(0,10000).'-'.date('s').'.'.$ext;
            $destination=public_path("images/profile");
            $file_image->move($destination,$fileimage);
            $image_url=url('public/images/profile').'/'.$fileimage;  
        }else{
            $image_url=null;
        }
        $validator = Validator::make(['password'=>$request->password],[
            'password' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('password')]);
        }
        $validator = Validator::make(['role'=>$request->role],[
            'role' => 'required|numeric|digits:2'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('role')]);
        }
        $unique_res = User::where('role',97)->latest()->first();
        if($unique_res == null && $unique_res == ''){
            $unique_id = "000001";
        }else{
            $unique_id =sprintf('%06d', $unique_res->unique_id + 1);
        }
        $user= new User;
        $user->name=$request->name;
        $user->alias=$request->alias;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->image=$image_url;
        $user->unique_id=$unique_id;
        $user->password= Hash::make($request->password);
        $user->status=0;
        $user->is_online=0;
        $user->role=$request->role;
        $res= $user->save();
        if($res > 0){
            return response()->json(['status'=>200,'message'=>"Your Account is Created, Successfully!"]);
        }else{
            return response()->json(['status'=>202,'message'=>"Failed!"]);
        }     
    }

    public function login(Request $request){
        // $validator = Validator::make(['role'=>$request->role],[
        //     'role' => 'required|numeric|digits:2'
        // ]);
        // if($validator->fails()){
        //     return response()->json(['status'=>false,'message'=>$validator->errors()->first('role'),'data'=>null,'token_type'=>'Bearer','access_token'=>null]);
        // }
        $validator = Validator::make(['alias'=>$request->alias],[
            'alias' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('alias'),'data'=>null,'token_type'=>'Bearer','access_token'=>null]);
        }
        $validator = Validator::make(['password'=>$request->password],[
            'password' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('password'),'data'=>null,'token_type'=>'Bearer','access_token'=>null]);
        }
        $user_info = User::where('alias',$request->alias)->first();
        if($user_info !=  '' && $user_info !=  null){
            if( !Hash::check($request->password, $user_info->password  ) )
            {
                return response()->json(['status'=>true,'message'=>'Incorrect Password.','data'=>null,'token_type'=>'Bearer','access_token'=>null]);
            }else{
              User::where('id',$user_info->id)->update(['is_online'=>1]); 
              $authToken = $user_info->createToken('Pesonal Access Token');
              return response()->json(['status'=>true,'message'=>'Success','data'=>$user_info,'token_type'=>'Bearer','access_token'=>$authToken->accessToken]);
            }
        }else{
            return response()->json(['status'=>true,'message'=>'Player not Registered with this Alias.','data'=>null,'token_type'=>'Bearer','access_token'=>null]);
        }
        
    }

    public function profile_details(Request $request){
        $validator = Validator::make(['id'=>$request->id],[
            'id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('id'),'data'=>null]);
        }
        $user_res = User::where('id',$request->id)->first();
        if($user_res != null){
            return response()->json(['status'=>true,'message'=>'Success.','data'=>$user_res]);
        }else{
            return response()->json(['status'=>false,'message'=>'Player Does not Exist.','data'=>null]);
        }
    }

    public function update_profile(Request $request){
        $validator = Validator::make(['id'=>$request->id],[
            'id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('id')]);
        }else{
            $user_info = User::where('id',$request->id)->first();
            //return $user_info;
            if($user_info != "" && $user_info != null){
                $player_name = $user_info->name;
                $player_alias = $user_info->alias;
                $player_email = $user_info->email;
                $image_url = $user_info->image;
                $player_password = $user_info->password;
            }
        }
       // return $player_name;
        if(isset($request->name)){
            $validator = Validator::make(['name'=>$request->name],[
                'name' => 'required|string'
            ]);
            if($validator->fails()){
                return response()->json(['status'=>false,'message'=>$validator->errors()->first('name')]);
            }else{$player_name = $request->name;}
        } 
        if(isset($request->alias)){   
            $validator = Validator::make(['alias'=>$request->alias],[
                'alias' => 'required|string'
            ]);
            if($validator->fails()){
                return response()->json(['status'=>false,'message'=>$validator->errors()->first('alias')]);
            }else{
                $user_info1 = User::where('id','!=',$request->id)->where('alias',$request->alias)->first();
                if($user_info1 != null && $user_info1 != ''){
                    return response()->json(['status'=>false,'message'=> 'Sorry! This Alias Already Existed.']);
                }else{
                    $player_alias = $request->alias;
                }
                
            }
        } 
        if(isset($request->email)){   
            $validator = Validator::make(['email'=>$request->email],[
                'email' => 'required|email'
            ]);
            if($validator->fails()){
                return response()->json(['status'=>false,'message'=>$validator->errors()->first('email')]);
            }else{
                $user_info2 = User::where('id','!=',$request->id)->where('email',$request->email)->first();
                if($user_info2 != null && $user_info2 != ''){
                    return response()->json(['status'=>false,'message'=> 'Sorry! This Email Already Existed.']);
                }else{
                    $player_email = $request->email;
                }                
                
            }
        }    
        if($request->hasFile('image')){
            $file_image=$request->file('image');
            $ext=$file_image->getClientOriginalExtension();
            $fileimage=rand(0,10000).'-'.date('s').'.'.$ext;
            $destination=public_path("images/profile");
            $file_image->move($destination,$fileimage);
            $image_url=url('public/images/profile').'/'.$fileimage;            
        }
        if(isset($request->password)){
            if( $request->password != null && $request->password != ''){
                $validator = Validator::make(['password'=>$request->password],[
                    'password' => 'required'
                ]);
                if($validator->fails()){
                    return response()->json(['status'=>false,'message'=>$validator->errors()->first('password')]);
                } 
                $validator = Validator::make(['new_password'=>$request->new_password],[
                    'new_password' => 'required'
                ]);
                if($validator->fails()){
                    return response()->json(['status'=>false,'message'=>$validator->errors()->first('new_password')]);
                }else{
                    if( !Hash::check($request->password, $user_info->password )){
                        return response()->json(['status'=>false,'message'=>'Password Did not Match.']);
                    }else{
                        $player_password = Hash::make($request->new_password);
                    }  
                } 
            }              
        }
        $update_res = User::where('id',$request->id)->update([
            'name'=>$player_name,
            'alias'=>$player_alias,
            'email'=>$player_email,
            'image'=>$image_url,
            'password'=>$player_password
        ]);
        if($update_res > 0){
            return response()->json(['status'=>true,'message'=>"Your Profile is Updated Successfully!"]);
        }else{
            return response()->json(['status'=>false,'message'=>"Failed!"]);
        }
        
    }

    public function hourly_ante_amount(Request $request){
        $ante_amnt_res = HourlyAnteAmount::get();
        if(!empty($ante_amnt_res)){
            return response()->json(['status'=>true,'message'=>'Success.','data'=>$ante_amnt_res]);
        }else{
            return response()->json(['status'=>false,'message'=>'Ante Amount not Found.','data'=>array()]);
        }
    }

    public function ante_amount(Request $request){
        $ante_amnt_res = AnteAmount::get();
        if(!empty($ante_amnt_res)){
            return response()->json(['status'=>true,'message'=>'Success.','data'=>$ante_amnt_res]);
        }else{
            return response()->json(['status'=>false,'message'=>'Ante Amount not Found.','data'=>array()]);
        }
    }

    public function player_number(Request $request){
        $player_no_res = NumberPlayer::get();
        if(!empty($player_no_res)){
            return response()->json(['status'=>true,'message'=>'Success.','data'=>$player_no_res]);
        }else{
            return response()->json(['status'=>false,'message'=>'Ante Amount not Found.','data'=>array()]);
        }
    }

    public function active_players(Request $request){
        $validator = Validator::make(['ante_amount_id'=>$request->ante_amount_id],[
            'ante_amount_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('ante_amount_id')]);
        }
        $validator = Validator::make(['player_no_id'=>$request->player_no_id],[
            'player_no_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('player_no_id')]);
        }
        $group_res = count(GroupLive::where(['group_id'=>$request->ante_amount_id.$request->player_no_id,
        'status'=>1])->get());
        if($group_res>0){
            return response()->json(['status'=>true,'message'=>'Success.','active_players'=>$group_res]);
        }else{
            return response()->json(['status'=>true,'message'=>'Group not Found.','active_players'=>$group_res]);
        }
        
    }

    // public function add_player_ingroup(Request $request){
    //     $validator = Validator::make(['player_id'=>$request->player_id],[
    //         'player_id' => 'required|numeric'
    //     ]);
    //     if($validator->fails()){
    //         return response()->json(['status'=>201,'message'=>$validator->errors()->first('player_id'),'group_unique_id'=>null,'answer_status'=>null]);
    //     }
    //     $user_res = User::where(['id'=>$request->player_id,'status'=>1])->first();
    //     if($user_res == '' && $user_res == null){
    //         return response()->json(['status'=>201,'message'=>"Player Not Existed or Not Active.",'group_unique_id'=>null,'answer_status'=>null]);
    //     }
    //     $validator = Validator::make(['ante_amount_id'=>$request->ante_amount_id],[
    //         'ante_amount_id' => 'required|numeric'
    //     ]);
    //     if($validator->fails()){
    //         return response()->json(['status'=>201,'message'=>$validator->errors()->first('ante_amount_id'),'group_unique_id'=>null,'answer_status'=>null]);
    //     }
    //     $validator = Validator::make(['player_no_id'=>$request->player_no_id],[
    //         'player_no_id' => 'required|numeric'
    //     ]);
    //     if($validator->fails()){
    //         return response()->json(['status'=>201,'message'=>$validator->errors()->first('player_no_id'),'group_unique_id'=>null,'answer_status'=>null]);
    //     }
    //     $group_res = GroupLive::where(['group_id'=>$request->ante_amount_id.$request->player_no_id])->get();
    //     if(count($group_res)>0){
            
   
    //     }else{
    //         $group_unique_id = rand(111,999).$request->player_id.rand(111,999);
    //         $user= new GroupLive;
    //         $user->player_id=$request->player_id;
    //         $user->group_id=$request->ante_amount_id.$request->player_no_id;
    //         $user->ante_amount_id=$request->ante_amount_id;
    //         $user->player_no_id=$request->player_no_id;
    //         $user->group_unique_id=$group_unique_id;
    //         $res= $user->save();
    //         if($res > 0){
    //             for($i=0;$i<10;$i++){
    //                 $ques_res=Question::select('id')->inRandomOrder()->take(10)->get();
    //                 if(count($ques_res)>0){
    //                     foreach($ques_res as $val){
    //                         $question= new GroupQuestion;
    //                         $question->question_id = $val->id;
    //                         $question->group_unique_id = $group_unique_id;
    //                         $question->question_set = $i;
    //                         $question->save();
    //                     }
    //                 }
    //             }    
    //             $ante_amnt = AnteAmount::where('id',$request->ante_amount_id)->value('ante_amount');
    //             $bonus= new BonusPot;
    //             $bonus->amount = $ante_amnt;
    //             $bonus->group_unique_id = $group_unique_id;
    //             $bonus->save();
    //             return response()->json(['status'=>200,'message'=>"Player Added in Group SuccessFully!.",'group_unique_id'=>$group_unique_id,'answer_status'=>0]);
    //         }else{
    //             return response()->json(['status'=>201,'message'=>"Failed!.",'group_unique_id'=>null,'answer_status'=>null]); 
    //         }
    //     }       
    // }

    public function add_player_ingroup(Request $request){
        $validator = Validator::make(['player_id'=>$request->player_id],[
            'player_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('player_id'),'group_id'=>null,'group_unique_id'=>null]);
        }
        $user_res = User::where(['id'=>$request->player_id,'status'=>1])->first();
        if($user_res == '' && $user_res == null){
            return response()->json(['status'=>201,'message'=>"Player Not Existed or Not Active.",'group_id'=>null,'group_unique_id'=>null]);
        }
        $validator = Validator::make(['ante_amount_id'=>$request->ante_amount_id],[
            'ante_amount_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('ante_amount_id'),'group_id'=>null,'group_unique_id'=>null]);
        }
        $validator = Validator::make(['player_no_id'=>$request->player_no_id],[
            'player_no_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('player_no_id'),'group_id'=>null,'group_unique_id'=>null]);
        }
        $group_res = GroupLive::where(['group_id'=>$request->ante_amount_id.$request->player_no_id,
        'status'=>1,'group_unique_id'=> null])->get();
        if(count($group_res)>0){
            $group_res1 = GroupLive::where(['group_id'=>$request->ante_amount_id.$request->player_no_id,
            'status'=>1,'player_id'=>$request->player_id])->get();
            if(count($group_res1)>0){
                return response()->json(['status'=>200,'message'=>"Player Already Added in This Group.",'group_id'=>$request->ante_amount_id.$request->player_no_id,'group_unique_id'=>null]);  
            }else{
                $tl_players =  NumberPlayer::where(['id'=>$request->player_no_id])->first();
                if($tl_players != '' && $tl_players != null){
                    if(count($group_res)+1 < $tl_players->player_number){
                        $user= new GroupLive;
                        $user->player_id=$request->player_id;
                        $user->group_id=$request->ante_amount_id.$request->player_no_id;
                        $user->ante_amount_id=$request->ante_amount_id;
                        $user->player_no_id=$request->player_no_id;
                        $res= $user->save();
                        if($res > 0){
                            return response()->json(['status'=>200,'message'=>"Player Added in Group SuccessFully!.",'group_id'=>$user->group_id,'group_unique_id'=>null]);
                        }else{
                            return response()->json(['status'=>201,'message'=>"Failed!.",'group_id'=>null,'group_unique_id'=>null]);
                        }  
                    }else{
                        $user= new GroupLive;
                        $user->player_id=$request->player_id;
                        $user->group_id=$request->ante_amount_id.$request->player_no_id;
                        $user->ante_amount_id=$request->ante_amount_id;
                        $user->player_no_id=$request->player_no_id; 
                        $res= $user->save();
                        if($res > 0){
                            $group_uniqie_id = rand(111,999).$request->player_id.rand(111,999);
                           $group= GroupLive::where(['group_id'=>$request->ante_amount_id.$request->player_no_id,
                        'status'=>1])->update(['status'=>2,'question_id'=>Question::inRandomOrder()->value('id'),
                    'group_unique_id'=>$group_uniqie_id]);
                    // --------
                    $get_ante_amnt = AnteAmount::where('id',$request->ante_amount_id)->value('ante_amount');
                    $get_player_no = NumberPlayer::where('id',$request->player_no_id)->value('player_number');
                    if($get_ante_amnt != "" && $get_ante_amnt != null && $get_player_no != "" && $get_player_no != null){
                        $bonus = new BonusPot;
                        $bonus->amount = $get_ante_amnt * $get_player_no;
                        $bonus->availabe_amount = $get_ante_amnt * $get_player_no;
                        $bonus->group_unique_id =$group_uniqie_id;
                        $bonus->save();
                    }
                    //------------ 

                            return response()->json(['status'=>200,'message'=>"Group Completed.",'group_id'=>$user->group_id,'group_unique_id'=>$group_uniqie_id]);
                        }else{
                            return response()->json(['status'=>201,'message'=>"Failed!",'group_id'=>null,'group_unique_id'=>null]);
                        } 
                    }
                }else{
                    return response()->json(['status'=>201,'message'=>"Player Numbers not Existed.",'group_id'=>null,'group_unique_id'=>null]);
                } 
            }   
        }else{
            $user= new GroupLive;
            $user->player_id=$request->player_id;
            $user->group_id=$request->ante_amount_id.$request->player_no_id;
            $user->ante_amount_id=$request->ante_amount_id;
            $user->player_no_id=$request->player_no_id;
            $res= $user->save();
            return response()->json(['status'=>200,'message'=>"Player Added in Group SuccessFully!.",'group_id'=>$user->group_id]);
        }       
    }

    public function remove_player_fromgroup(Request $request){
        $validator = Validator::make(['player_id'=>$request->player_id],[
            'player_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('player_id')]);
        }
        $user_res = User::where(['id'=>$request->player_id,'status'=>1])->first();
        if($user_res == '' && $user_res == null){
            return response()->json(['status'=>false,'message'=>"Player Not Existed."]);
        }
        $validator = Validator::make(['group_id'=>$request->group_id],[
            'group_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('group_id')]);
        }
        $player_delete = Grouplive::where(['player_id'=>$request->player_id,'group_id'=>$request->group_id])
        ->delete();
        if($player_delete == 1){
            return response()->json(['status'=>true,'message'=>'Success.']);
        }else{
            return response()->json(['status'=>false,'message'=>'Failed.!']);
        }
    }
    
    public function group_complete(Request $request){
        // $validator = Validator::make(['group_id'=>$request->group_id],[
        //     'group_id' => 'required|numeric'
        // ]);
        // if($validator->fails()){
        //     return response()->json(['status'=>false,'message'=>$validator->errors()->first('group_id')]);
        // }
        // $group_res = Grouplive::where(['group_id'=>$request->group_id,'status'=>2])->get();
        // if(count($group_res)>0){
        //     return response()->json(['status'=>true,'message'=>'Success.']);
        // }else{
        //     return response()->json(['status'=>false,'message'=>'Failed.!']);
        // }

        $validator = Validator::make(['group_id'=>$request->group_id],[
            'group_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('group_id')]);
        }
        $group_res = Grouplive::where(['group_id'=>$request->group_id,'status'=>2])->get();
        if(count($group_res)>0){
            return response()->json(['status'=>true,'message'=>'Success.','group_unique_id'=>$group_res[0]->group_unique_id]);
        }else{
            return response()->json(['status'=>false,'message'=>'Failed.!','group_unique_id'=>null]);
        }
    }

    public function get_question(Request $request){
        $validator = Validator::make(['group_id'=>$request->group_id],[
            'group_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('group_id')]);
        }
        $validator = Validator::make(['player_id'=>$request->player_id],[
            'player_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('player_id')]);
        }
        $group_res = Grouplive::where(['group_id'=>$request->group_id,'player_id'=>$request->player_id,'status'=>2])->first();
        if($group_res != '' && $group_res != null){
            $question_res = Question::where(['id'=>$group_res->question_id])->first();
            $data =array(
                'question_id'=>$question_res->id,
                'category'=>$question_res->category,
                'question'=>$question_res->question,
                'answer_array' => array('wrong_answer1'=>$question_res->wrong_answer1,'wrong_answer2'=>$question_res->wrong_answer2,'wrong_answer3'=>$question_res->wrong_answer3,'correct'=>$question_res->correct),
                'group_unique_id'=>$group_res->group_unique_id,
                'player_id'=>$group_res->player_id,
            );
            GameLive::create(['question_id'=>$question_res->id,'group_unique_id'=>$group_res->group_unique_id,'player_id'=>$group_res->player_id]);
            //GroupLive::where(['player_id'=>$group_res->player_id,'group_unique_id'=>$group_res->group_unique_id])->delete();
            return response()->json(['status'=>true,'message'=>'Success.','data'=>$data]);
        }else{
            return response()->json(['status'=>false,'message'=>'Failed.!','data'=>null]);
        }
    }



    public function player_answer(Request $request){
        $validator = Validator::make(['player_id'=>$request->player_id],[
            'player_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('player_id'),'data'=>null]);
        }
        $validator = Validator::make(['group_unique_id'=>$request->group_unique_id],[
            'group_unique_id' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('group_unique_id'),'data'=>null]);
        }
        $validator = Validator::make(['question_id'=>$request->question_id],[
            'question_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('question_id'),'data'=>null]);
        }
        $validator = Validator::make(['play_time'=>$request->play_time],[
            'play_time' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('play_time'),'data'=>null]);
        }
        $validator = Validator::make(['game_type'=>$request->game_type],[
            'game_type' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('game_type'),'data'=>null]);
        }
        $validator = Validator::make(['group_id'=>$request->group_id],[
            'group_id' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('group_id'),'data'=>null]);
        }
        $validator = Validator::make(['answer'=>$request->answer],[
            'answer' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('answer'),'data'=>null]);
        }
    
        $gammelog= new GameLog;
        $gammelog->player_id=$request->player_id;
        $gammelog->group_id=$request->group_id;
        $gammelog->group_unique_id=$request->group_unique_id;
        $gammelog->question_id=$request->question_id;
        $gammelog->category=Question::where('id',$request->question_id)->value('category');
        $gammelog->play_time=$request->play_time;
        $gammelog->game_type=$request->game_type;
        $gammelog->answer=$request->answer;
        $gammelog->save();
        $gammelog->id;
        if($gammelog->id >0){
            GroupLive::where(['player_id'=>$request->player_id,'group_unique_id'=>$request->group_unique_id])->delete();
            $data = Gamelog::where('id',$gammelog->id)->first();
            return response()->json(['status'=>true,'message'=>'Success.','data'=>$data]);
        }else{
            return response()->json(['status'=>false,'message'=>'Failed.','data'=>null]);
        } 
        
    }

    public function all_players_answer(Request $request){
        $validator = Validator::make(['group_unique_id'=>$request->group_unique_id],[
            'group_unique_id' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('group_unique_id')]);
        }
        $validator = Validator::make(['game_type'=>$request->game_type],[
            'game_type' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('game_type')]);
        }
        $validator = Validator::make(['answer'=>$request->answer],[
            'answer' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('answer')]);
        }
        $game_result = GroupLive::where('group_unique_id',$request->group_unique_id)->get();
        if(count($game_result)>0){
            foreach($game_result as $val1){
                $gammelog= new GameLog;
                $gammelog->player_id=$val1->player_id;
                $gammelog->group_id=$val1->group_id;
                $gammelog->group_unique_id=$request->group_unique_id;
                $gammelog->question_id=$val1->question_id;
                $gammelog->category=Question::where('id',$val1->question_id)->value('category');
                $gammelog->game_type=$request->game_type;
                $gammelog->answer=$request->answer;
                $gammelog->save();
            }
            $group_delete = GroupLive::where('group_unique_id',$request->group_unique_id)->delete(); 
            return response()->json(['status'=>200,'message'=>'Success']);    
        }else{
            return response()->json(['status'=>200,'message'=>'Success']);
        }               
    }

    public function play_group_result(Request $request){
        $validator = Validator::make(['group_unique_id'=>$request->group_unique_id],[
            'group_unique_id' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('group_unique_id')]);
        }
        $validator = Validator::make(['game_type'=>$request->game_type],[
            'game_type' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('game_type')]);
        }
        $validator = Validator::make(['answer'=>$request->answer],[
            'answer' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('answer')]);
        }
        $game_result = GroupLive::where('group_unique_id',$request->group_unique_id)->get();
        if(count($game_result)>0){
            foreach($game_result as $val1){
                $gammelog= new GameLog;
                $gammelog->player_id=$val1->player_id;
                $gammelog->group_id=$val1->group_id;
                $gammelog->group_unique_id=$request->group_unique_id;
                $gammelog->question_id=$val1->question_id;
                $gammelog->category=Question::where('id',$val1->question_id)->value('category');
                $gammelog->game_type=$request->game_type;
                $gammelog->prize_amount=AnteAmount::where('id',$val1->ante_amount_id)->value('ante_amount');
                $gammelog->answer=$request->answer;
                $gammelog->save();
            }
            $group_delete = GroupLive::where('group_unique_id',$request->group_unique_id)->delete();
            $sql ="
            SELECT id FROM `game_logs` WHERE play_time in (select min(play_time) from game_logs where group_unique_id ='".$request->group_unique_id."' AND  play_time!=0 AND answer = 'correct');";
            $winners=DB::select($sql);
            $tl_winner = count($winners);
            if($tl_winner > 0){
                $bonuspot= BonusPot::where('group_unique_id',$request->group_unique_id)->value('amount');
                if($bonuspot != "" && $bonuspot != null){
                    $prize_amount = $bonuspot / $tl_winner;
                    foreach($winners as $win){
                        GameLog::where('id',$win->id)->update(['game_status'=>1,'prize_amount'=>$prize_amount]);
                        BonusPot::where('group_unique_id',$request->group_unique_id)->decrement('availabe_amount', $prize_amount);
                    }
                }
            }
            return response()->json(['status'=>200,'message'=>'Success']);    
        }else{
            $sql ="
            SELECT id FROM `game_logs` WHERE play_time in (select min(play_time) from game_logs where group_unique_id ='".$request->group_unique_id."' AND  play_time!=0 AND answer = 'correct');";
            $winners=DB::select($sql);
            $tl_winner = count($winners);
            if($tl_winner > 0){
                $bonuspot= BonusPot::where('group_unique_id',$request->group_unique_id)->value('amount');
                if($bonuspot != "" && $bonuspot != null){
                    $prize_amount = $bonuspot / $tl_winner;
                    foreach($winners as $win){
                        GameLog::where('id',$win->id)->update(['game_status'=>1,'prize_amount'=>$prize_amount]);
                        BonusPot::where('group_unique_id',$request->group_unique_id)->decrement('availabe_amount', $prize_amount);
                    }
                }
            }
            return response()->json(['status'=>200,'message'=>'Success']);
        }               
    }

    public function game_detail(Request $request){
        $data = array();
        $validator = Validator::make(['group_unique_id'=>$request->group_unique_id],[
            'group_unique_id' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('group_unique_id'),'data'=>$data]);
        }
        $validator = Validator::make(['player_id'=>$request->player_id],[
            'player_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('player_id'),'data'=>$data]);
        }
        $prize_amount = GameLog::where(['group_unique_id'=>$request->group_unique_id,'player_id'=>$request->player_id])->first();
        if($prize_amount != '' && $prize_amount != null){
            if($prize_amount->game_status == '1'){
                $game_amount = $prize_amount->prize_amount;
            }else{
                $game_amount=AnteAmount:: where('id',substr($prize_amount->group_id, 0, 1))->value('ante_amount'); 
            }
        }
        $game_details = GameLog::select('game_logs.*','users.name')
        ->join('users', 'users.id', '=', 'game_logs.player_id')
        ->where('group_unique_id',$request->group_unique_id)->get();
        if(!empty($game_details)){
            $data['game_amount']=$game_amount;
            $data['game_status']=$prize_amount->game_status;
            $data['game_detail']=$game_details;
            return response()->json(['status'=>200,'message'=>'Success.','data'=>$data]);
        }else{
            return response()->json(['status'=>201,'message'=>'Failed.','data'=>$data]);
        }       
    }

    public function add_player_intournament(Request $request){
        $validator = Validator::make(['player_id'=>$request->player_id],[
            'player_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('player_id'),'tournament_unique_id'=>null]);
        }
        $user_res = User::where(['id'=>$request->player_id,'status'=>1])->first();
        if($user_res == '' && $user_res == null){
            return response()->json(['status'=>201,'message'=>"Player Not Existed or Not Active.",'tournament_unique_id'=>null]);
        }
        $validator = Validator::make(['ante_amount_id'=>$request->ante_amount_id],[
            'ante_amount_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('ante_amount_id'),'tournament_unique_id'=>null]);
        }
        $start_date = date("Y-m-d H:i:s");
        $newDate = date("h:00 A", strtotime($start_date));
        $newtime = date('h:i A',strtotime($newDate) + 60*60);
        $time_slot = $newDate." to ".$newtime;
        $time_slot_res = TimeSlot::where('time_slot', 'LIKE', '%'.$time_slot.'%')->value('id');
        $tournament_res = HourlyGrouplive::where('ante_amount_id',$request->ante_amount_id)
        ->where(['time_slot'=>$time_slot_res])
        ->where('date', 'LIKE', '%'.date('Y-m-d').'%')->first();
        if($tournament_res != '' && $tournament_res != null){
            $tournament_res1 = HourlyGrouplive::where(['ante_amount_id'=>$request->ante_amount_id,
            'player_id'=>$request->player_id,'status'=>1])
            ->where(['time_slot'=>$time_slot_res])
            ->where('date', 'LIKE', '%'.date('Y-m-d').'%')
            ->orderBy('id', 'desc')->first();
           // return $tournament_res1;
            if($tournament_res1 != '' && $tournament_res1 != null){
                return response()->json(['status'=>202,'message'=>"Player Already Added in Tournament!",'tournament_unique_id'=>$tournament_res1->tournament_unique_id]);          
            }else{
                $tournament_unique_id =$tournament_res->tournament_unique_id;
                $tournament= new HourlyGrouplive;
                $tournament->player_id=$request->player_id;
                $tournament->tournament_unique_id=$tournament_unique_id;
                $tournament->time_slot=$time_slot_res;
                $tournament->ante_amount_id=$request->ante_amount_id;
                $tournament->status=1;
                $tournament->date=date('Y-m-d');
                $res1 = $tournament->save();
                if($res1 > 0){
                    $ante_amnt=AnteAmount::where('id',$request->ante_amount_id)->value('ante_amount');
                    BonusPot::where('group_unique_id',$tournament_res->tournament_unique_id)->update([
                        'amount' => DB::raw('amount + "'.$ante_amnt.'"'),
                        'availabe_amount' => DB::raw('availabe_amount + "'.$ante_amnt.'"'),
                    ]);
                }
                return response()->json(['status'=>200,'message'=>"Player Added Successfully!",'tournament_unique_id'=>$tournament_unique_id]);
            }
        }else{
            $tournament_unique_id = rand(111,999).$request->player_id.rand(111,999);
            $tournament= new HourlyGrouplive;
            $tournament->player_id=$request->player_id;
            $tournament->tournament_unique_id=$tournament_unique_id;
            $tournament->time_slot=$time_slot_res;
            $tournament->ante_amount_id=$request->ante_amount_id;
            $tournament->status=1;
            $tournament->date=date('Y-m-d');
            $res=$tournament->save();
            if($res>0){
                $get_ante_amnt = AnteAmount::where('id',$request->ante_amount_id)->value('ante_amount');
                if($get_ante_amnt != "" && $get_ante_amnt != null){
                    $bonus = new BonusPot;
                    $bonus->amount = $get_ante_amnt;
                    $bonus->availabe_amount = $get_ante_amnt;
                    $bonus->group_unique_id =$tournament_unique_id;
                    $bonus->save();
                }
            }
            return response()->json(['status'=>200,'message'=>"Player Added Successfully!",'tournament_unique_id'=>$tournament_unique_id]);
        }
             
    }

    public function get_tournament_question(Request $request){
        $validator = Validator::make(['tournament_unique_id'=>$request->tournament_unique_id],[
            'tournament_unique_id' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('tournament_unique_id'),'data'=>array()]);
        }
        $time_slot = HourlyGrouplive::
        join('time_slots','hourly_group_lives.time_slot','=','time_slots.id')
        ->where(['hourly_group_lives.tournament_unique_id'=>$request->tournament_unique_id])->value('time_slots.time_slot');   
        $str = substr($time_slot, strpos($time_slot, 'to ') + strlen('to '));
       
        // $minutes = (strtotime(date('h:i A'))-strtotime($str))/60;
        // $sec = (strtotime(date('h:i A'))-strtotime($str))%60;
        // return  $minutes.":".$sec;
        $ques_res=Question::inRandomOrder()->first();
        if(isset($ques_res))
        {
            $data['id']=$ques_res->id;
            $data['question']=$ques_res->question;
            $data['category']=$ques_res->category;
            $data['end_time']=$str;
            $data['ansArr'] = array(
                'wrong_answer1'=>$ques_res->wrong_answer1,
                'wrong_answer2'=>$ques_res->wrong_answer2,
                'wrong_answer3'=>$ques_res->wrong_answer3,
                'correct'=>$ques_res->correct,
            );
            return response()->json(['status'=>200,'message'=>"Success.",'data'=>$data]);
        }else{
            return response()->json(['status'=>201,'message'=>"Failed!",'data'=>array()]);
        }
        
    }

    // public function add_player_intournament(Request $request){
    //     $validator = Validator::make(['player_id'=>$request->player_id],[
    //         'player_id' => 'required|numeric'
    //     ]);
    //     if($validator->fails()){
    //         return response()->json(['status'=>201,'message'=>$validator->errors()->first('player_id'),'tournament_unique_id'=>null]);
    //     }
    //     $user_res = User::where(['id'=>$request->player_id,'status'=>1])->first();
    //     if($user_res == '' && $user_res == null){
    //         return response()->json(['status'=>201,'message'=>"Player Not Existed or Not Active.",'tournament_unique_id'=>null]);
    //     }
    //     $validator = Validator::make(['ante_amount_id'=>$request->ante_amount_id],[
    //         'ante_amount_id' => 'required|numeric'
    //     ]);
    //     if($validator->fails()){
    //         return response()->json(['status'=>201,'message'=>$validator->errors()->first('ante_amount_id'),'tournament_unique_id'=>null]);
    //     }
    //     $start_time = date("Y-m-d H:i:s");
    //     $tournament_res = HourlyGrouplive::where('ante_amount_id',$request->ante_amount_id)->first();
    //     if($tournament_res != '' && $tournament_res != null){
    //         $tournament_res1 = HourlyGrouplive::where(['ante_amount_id'=>$request->ante_amount_id,
    //         'player_id'=>$request->player_id,'status'=>1])
    //         ->orderBy('id', 'desc')->first();
    //         if($tournament_res1 != '' && $tournament_res1 != null){
    //             if($tournament_res->end_time > $start_time){
    //                 return response()->json(['status'=>202,'message'=>"Player Already Added in Tournament!",'tournament_unique_id'=>$tournament_res1->tournament_unique_id]); 
    //             }else{
    //                 $update=HourlyGrouplive::where('tournament_unique_id',$tournament_res1->tournament_unique_id)->update([
    //                     'status'=>2
    //                 ]);
    //                 if($update > 0){
    //                     $end_time = date("Y-m-d H:i:s", strtotime("+1 hours"));
    //                     $tournament_unique_id = rand(111,999).$request->player_id.rand(111,999);
    //                     $tournament= new HourlyGrouplive;
    //                     $tournament->player_id=$request->player_id;
    //                     $tournament->tournament_unique_id=$tournament_unique_id;
    //                     $tournament->ante_amount_id=$request->ante_amount_id;
    //                     $tournament->start_time=$start_time;
    //                     $tournament->end_time=$end_time;
    //                     $tournament->status=1;
    //                     $tournament->save();
    //                     $ques_res=Question::select('id')->inRandomOrder()->take(10)->get();
    //                     if(count($ques_res)>0){
    //                         foreach($ques_res as $val){
    //                             $question= new HourlyQuestion;
    //                             $question->question_id = $val->id;
    //                             $question->tournament_unique_id = $tournament_unique_id;
    //                             $question->player_id = $request->player_id;
    //                             $question->save();
    //                         }
    //                     }
    //                     return response()->json(['status'=>200,'message'=>"Player Added Successfully!",'tournament_unique_id'=>$tournament_unique_id]);
    //                 }                  
    //             }                
    //         }else{
    //             if($tournament_res->end_time > $start_time){
    //                 $tournament_unique_id = rand(111,999).$request->player_id.rand(111,999);
    //                 $tournament= new HourlyGrouplive;
    //                 $tournament->player_id=$request->player_id;
    //                 $tournament->tournament_unique_id=$tournament_res->tournament_unique_id;
    //                 $tournament->ante_amount_id=$request->ante_amount_id;
    //                 $tournament->start_time=$tournament_res->start_time;
    //                 $tournament->end_time=$tournament_res->end_time;
    //                 $tournament->status=1;
    //                 $tournament->save();
    //                 $ques_res=Question::select('id')->inRandomOrder()->take(10)->get();
    //                 if(count($ques_res)>0){
    //                     foreach($ques_res as $val){
    //                         $question= new HourlyQuestion;
    //                         $question->question_id = $val->id;
    //                         $question->tournament_unique_id = $tournament_unique_id;
    //                         $question->player_id = $request->player_id;
    //                         $question->save();
    //                     }
    //                 }
    //                 return response()->json(['status'=>200,'message'=>"Player Added Successfully!",'tournament_unique_id'=>$tournament_res->tournament_unique_id]);
    //             }else{
                    
    //                $update=HourlyGrouplive::where('tournament_unique_id',$tournament_res->tournament_unique_id)->update([
    //                     'status'=>2
    //                ]);
    //                if($update > 0){
    //                 $end_time = date("Y-m-d H:i:s", strtotime("+1 hours"));
    //                 $tournament_unique_id = rand(111,999).$request->player_id.rand(111,999);
    //                 $tournament= new HourlyGrouplive;
    //                 $tournament->player_id=$request->player_id;
    //                 $tournament->tournament_unique_id=$tournament_unique_id;
    //                 $tournament->ante_amount_id=$request->ante_amount_id;
    //                 $tournament->start_time=$start_time;
    //                 $tournament->end_time=$end_time;
    //                 $tournament->status=1;
    //                 $tournament->save();
    //                 $ques_res=Question::select('id')->inRandomOrder()->take(10)->get();
    //                 if(count($ques_res)>0){
    //                     foreach($ques_res as $val){
    //                         $question= new HourlyQuestion;
    //                         $question->question_id = $val->id;
    //                         $question->tournament_unique_id = $tournament_unique_id;
    //                         $question->player_id = $request->player_id;
    //                         $question->save();
    //                     }
    //                 }
    //                 return response()->json(['status'=>200,'message'=>"Player Added Successfully!",'tournament_unique_id'=>$tournament_unique_id]);
    //                }
    //             }
    //         }
    //     }else{
    //         $end_time = date("Y-m-d H:i:s", strtotime("+1 hours"));
    //         $tournament_unique_id = rand(111,999).$request->player_id.rand(111,999);
    //         $tournament= new HourlyGrouplive;
    //         $tournament->player_id=$request->player_id;
    //         $tournament->tournament_unique_id=$tournament_unique_id;
    //         $tournament->ante_amount_id=$request->ante_amount_id;
    //         $tournament->start_time=$start_time;
    //         $tournament->end_time=$end_time;
    //         $tournament->status=1;
    //         $tournament->save();
    //         $ques_res=Question::select('id')->inRandomOrder()->take(10)->get();
    //         if(count($ques_res)>0){
    //             foreach($ques_res as $val){
    //                 $question= new HourlyQuestion;
    //                 $question->question_id = $val->id;
    //                 $question->tournament_unique_id = $tournament_unique_id;
    //                 $question->player_id = $request->player_id;
    //                 $question->save();
    //             }
    //         }
    //         return response()->json(['status'=>200,'message'=>"Player Added Successfully!",'tournament_unique_id'=>$tournament_unique_id]);
    //     }
             
    // }

    // public function get_tournament_question(Request $request){
    //     $ques_res = array();
    //     $validator = Validator::make(['player_id'=>$request->player_id],[
    //         'player_id' => 'required|numeric'
    //     ]);
    //     if($validator->fails()){
    //         return response()->json(['status'=>201,'message'=>$validator->errors()->first('player_id'),'tournament_unique_id'=>null]);
    //     }
    //     $user_res = User::where(['id'=>$request->player_id,'status'=>1])->first();
    //     if($user_res == '' && $user_res == null){
    //         return response()->json(['status'=>201,'message'=>"Player Not Existed or Not Active.",'tournament_unique_id'=>null]);
    //     }
    //     $validator = Validator::make(['tournament_unique_id'=>$request->tournament_unique_id],[
    //         'tournament_unique_id' => 'required|numeric'
    //     ]);
    //     if($validator->fails()){
    //         return response()->json(['status'=>201,'message'=>$validator->errors()->first('tournament_unique_id'),'tournament_unique_id'=>null]);
    //     }
        
    //     // $ques_res=HourlyQuestion::join('questions','hourly_questions.question_id','=','questions.id')
    //     // ->where(['player_id'=>$request->player_id,'tournament_unique_id'=>$request->tournament_unique_id])
    //     // ->get();
        
    //     $ques_res=HourlyQuestion::where(['player_id'=>$request->player_id,'tournament_unique_id'=>$request->tournament_unique_id])
    //     ->get();
    //     if(!empty($ques_res))
    //     {
    //         foreach($ques_res as $k=> $play)
    //         {
    //             $question_arr=Question::where("id",$play->question_id)->first();
    //             $ques_res[$k]->questionarr = $question_arr;
    //             $ques_res[$k]->answerarr = array('wrong_answer1'=>$question_arr->wrong_answer1,'wrong_answer2'=>$question_arr->wrong_answer2,'wrong_answer3'=>$question_arr->wrong_answer3,'correct'=>$question_arr->correct);
                
    //         }
    //     }
    //     return response()->json(['status'=>200,'message'=>"Success.",'data'=>$ques_res]);
    // }

    // public function player_hourly_answer(Request $request){
    //     $validator = Validator::make(['player_id'=>$request->player_id],[
    //         'player_id' => 'required|numeric'
    //     ]);
    //     if($validator->fails()){
    //         return response()->json(['status'=>false,'message'=>$validator->errors()->first('player_id'),'data'=>null]);
    //     }
    //     $validator = Validator::make(['tournament_unique_id'=>$request->tournament_unique_id],[
    //         'tournament_unique_id' => 'required|string'
    //     ]);
    //     if($validator->fails()){
    //         return response()->json(['status'=>false,'message'=>$validator->errors()->first('tournament_unique_id'),'data'=>null]);
    //     }
    //     $validator = Validator::make(['question_id'=>$request->question_id],[
    //         'question_id' => 'required|numeric'
    //     ]);
    //     if($validator->fails()){
    //         return response()->json(['status'=>false,'message'=>$validator->errors()->first('question_id'),'data'=>null]);
    //     }
    //     $validator = Validator::make(['play_time'=>$request->play_time],[
    //         'play_time' => 'required|numeric'
    //     ]);
    //     if($validator->fails()){
    //         return response()->json(['status'=>false,'message'=>$validator->errors()->first('play_time'),'data'=>null]);
    //     }
    //     $validator = Validator::make(['game_type'=>$request->game_type],[
    //         'game_type' => 'required|string'
    //     ]);
    //     if($validator->fails()){
    //         return response()->json(['status'=>false,'message'=>$validator->errors()->first('game_type'),'data'=>null]);
    //     }
    //     $validator = Validator::make(['answer'=>$request->answer],[
    //         'answer' => 'required|string'
    //     ]);
    //     if($validator->fails()){
    //         return response()->json(['status'=>false,'message'=>$validator->errors()->first('answer'),'data'=>null]);
    //     }
    //     $update_ans =HourlyQuestion::where(['player_id'=>$request->player_id,
    //     'tournament_unique_id'=>$request->tournament_unique_id,'question_id'=>$request->question_id])
    //     ->update([
    //         'answer'=>$request->answer,'answer_time'=>$request->play_time
    //     ]);
    //     if($update_ans > 0){
    //          return response()->json(['status'=>200,'message'=>'Success.']);
    //     }else{
    //         return response()->json(['status'=>201,'message'=>'Failed.','data'=>null]);
    //     } 
        
    // }  
    
    public function player_hourly_answer(Request $request){
        $validator = Validator::make(['player_id'=>$request->player_id],[
            'player_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('player_id'),'data'=>null]);
        }
        $validator = Validator::make(['tournament_unique_id'=>$request->tournament_unique_id],[
            'tournament_unique_id' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('tournament_unique_id'),'data'=>null]);
        }
        $validator = Validator::make(['question_id'=>$request->question_id],[
            'question_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('question_id'),'data'=>null]);
        }
        // $validator = Validator::make(['play_time'=>$request->play_time],[
        //     'play_time' => 'required|numeric'
        // ]);
        // if($validator->fails()){
        //     return response()->json(['status'=>false,'message'=>$validator->errors()->first('play_time'),'data'=>null]);
        // }
        $validator = Validator::make(['game_type'=>$request->game_type],[
            'game_type' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('game_type'),'data'=>null]);
        }
        $validator = Validator::make(['answer'=>$request->answer],[
            'answer' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('answer'),'data'=>null]);
        }
        $questions = new HourlyQuestion ;
        $questions->question_id = $request->question_id;
        $questions->tournament_unique_id = $request->tournament_unique_id;
        $questions->player_id = $request->player_id;
        $questions->answer = $request->answer;
        $ques_res=$questions->save();
        if($ques_res > 0){
            $data = array();
            $ques_res=Question::inRandomOrder()->first();
            if(isset($ques_res))
            {
                $time_slot = HourlyGrouplive::join('time_slots','hourly_group_lives.time_slot','=','time_slots.id')
                ->where(['hourly_group_lives.tournament_unique_id'=>$request->tournament_unique_id])->value('time_slots.time_slot');   
                $str = substr($time_slot, strpos($time_slot, 'to ') + strlen('to '));
                $data['id']=$ques_res->id;
                $data['question']=$ques_res->question;
                $data['category']=$ques_res->category;
                $data['end_time']=$str;
                $data['ansArr'] = array(
                    'wrong_answer1'=>$ques_res->wrong_answer1,
                    'wrong_answer2'=>$ques_res->wrong_answer2,
                    'wrong_answer3'=>$ques_res->wrong_answer3,
                    'correct'=>$ques_res->correct,
                );
            }
             return response()->json(['status'=>200,'message'=>'Success.','data'=>$data]);
        }else{
            return response()->json(['status'=>201,'message'=>'Failed.','data'=>null]);
        }        
    }
    
    public function hourly_game_detail(Request $request){
        $validator = Validator::make(['player_id'=>$request->player_id],[
            'player_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>$validator->errors()->first('player_id'),'data'=>null]);
        }
        $validator = Validator::make(['tournament_unique_id'=>$request->tournament_unique_id],[
            'tournament_unique_id' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('tournament_unique_id')]);
        }
        $validator = Validator::make(['game_type'=>$request->game_type],[
            'game_type' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>201,'message'=>$validator->errors()->first('game_type')]);
        }
        $game_result = HourlyGroupLive::where('tournament_unique_id',$request->tournament_unique_id)->get();
        //return $game_result;
        if(count($game_result)>0){
            foreach($game_result as $val1){
                $gammelog= new GameLog;
                $gammelog->player_id=$val1->player_id;
                $gammelog->group_unique_id=$request->tournament_unique_id;
                $gammelog->game_type=$request->game_type;
                $gammelog->time_slot=$request->time_slot;
                $gammelog->ante_amount_id=$val1->ante_amount_id;
                $gammelog->prize_amount=HourlyAnteAmount::where(['id'=>$val1->ante_amount_id])->value('ante_amount');
                $gammelog->date=$request->date;
                $gammelog->save();
            }
            $group_delete = HourlyGroupLive::where('tournament_unique_id',$request->tournament_unique_id)->delete();
            $sql ="SELECT player_id,COUNT(*) as count FROM `hourly_questions` WHERE tournament_unique_id ='".$request->tournament_unique_id."' AND answer ='correct' group by player_id";
            $winners=DB::select($sql);
            $win_array = json_decode(json_encode($winners), true);
            $max = 0;
            foreach( (array)$win_array as $k => $v )
            {
                $max = max( array( $max, $v['count'] ) );
            }
            if(!empty($winners))
            {
                foreach($winners as  $win)
                {
                    if($win->count==$max)
                    {
                        GameLog::where(['group_unique_id'=>$request->tournament_unique_id,'player_id'=>$win->player_id])
                        ->update(['game_status'=>1]);
                    }
                }
            }
            $tl_winners = GameLog::where(['group_unique_id'=>$request->tournament_unique_id,'game_status'=>1])->get();
            if(!empty($tl_winners)){
                $bonuspot= BonusPot::where('group_unique_id',$request->tournament_unique_id)->value('amount');
                $prize_amount = $bonuspot / count($tl_winners);
                foreach($tl_winners as $val_win){
                    BonusPot::where('group_unique_id',$request->tournament_unique_id)->decrement('availabe_amount', $prize_amount);
                    BonusPot::where('group_unique_id',$request->tournament_unique_id)->increment('widrawal_amnt', $prize_amount);
                    GameLog::where(['group_unique_id'=>$request->tournament_unique_id,'player_id'=>$val_win->player_id])
                    ->update(['prize_amount'=>$prize_amount,'status'=>1]);
                }
            }
            return response()->json(['status'=>200,'message'=>'Success']);    
        }else{
            return response()->json(['status'=>200,'message'=>'Success']);
        }               
    }

  
    
}