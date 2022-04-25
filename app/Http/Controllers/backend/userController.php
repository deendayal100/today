<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use App\Models\User;
class userController extends Controller
{
    public function index()
    {   
        //$users = User::where('role',97)->get();
        //$users = DB::table('users')->get();
        $users=User::where('role',97)->where('id', '!=' , 8)->where('id', '!=' , 72)->orderby('id','desc')->get();
        // dd($users);
        return view('Pages.customer', compact('users'));
    }

    public function create() {
        return view('pages.user-create');
    }

    public function store(Request $request)
    {
        $user =new  User();
        $validatedData = $request->validate([
          'name' => 'required',
          'email' => 'required',
          'username' => 'required',
          'password' => 'required'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->password =Hash::make($request->password);
        $user->status = 1;

        // $nameTaken = DB::table('users')->where('username', $request->username)->count();
        // $emailTaken = DB::table('users')->where('email', $request->email)->count();

        $nameTaken = $user->where('username', $request->username)->count();
        $emailTaken = $user->where('email', $request->email)->count();

        if($nameTaken > 0){
            $result=array('statusname'=> false,'message'=> 'Username is allready taken.');
        }
        elseif($emailTaken > 0){
            $result=array('statusemail'=> false,'message'=> 'Email is allready taken.');
        }else{
            $user->updated_at = date("Y-m-d h:i:s");
            $user->created_at = date("Y-m-d h:i:s");
            // $data = ['name' => $user->name,'email' => $user->email,'username' => $user->$username,'status' => $status,'password' => $password,'created_at' => $date,'updated_at' => $date];
           
    
         
            $fileimage="";
            $image_url='';

            if($request->hasfile('image')){
                
            $file_image=$request->file('image');
            
            $fileimage=$file_image->getClientOriginalName();
            $user->image = $fileimage;
            $destination=public_path("images");
            $file_image->move($destination,$fileimage);
            // $image_url=url('public/images').'/'.$filename;
            
            }    
            $user->role="99";
            $users =  $user->save();
            if($users){
                $result=array('status'=>true,'message'=> 'Data Insert Successfully.');
            }
            else{
                $result=array('status'=>false,'message'=> 'Data Insert Not Successfully.');
            }
        }
        echo json_encode($result);
    }

    public function userview(Request $request,$id){
        $id = $request->id;
        $user = DB::table('users')->where('id', $id)->first();
        return view('Pages.master.user_view',compact('user'));
    }


   
    public function delete(Request $request, $id)
    {   
        $id = $request->id;
        $user = User::where('id',$id)->delete();
        return redirect('/user_list');
    }
    
    public function edit($id){
        $users = User::where('id',$id)->first();
        // $users = DB::table('users')->where('id',$id)->first();
        return view('Pages.user-edit', compact('users')); 
    }
    
    public function changeStatus(Request $request){
        $id = $request->user_id;
        $status = $request->status;
        $data = ['status'=>$status];
        $update =  DB::table('users')->where('id',$id)->update($data);
        if($update){
            $result = array("status"=> true, "message"=>"update status");
        }
        else{
            $result = array("status"=> false, "message"=>"not update status");
        }
    }


  
//ravi sir
    public function updateData(Request $request)
    {   
        $validatedData = $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
          ]);
          $id=$request->user_id;
          $name = $request->name;
          $email = $request->email;
          $phone = $request->phone;
          $language = $request->language;

        $nameExists =  DB::table('users')->where('id',$id)->where('name',$name)->count();
        $emailExists =  DB::table('users')->where('id',$id)->where('email',$email)->count();

            $before = DB::table('users')->where('id',$id)->first();
            $date = date("Y-m-d h:i:s");
            
            if($before){
                $data = $data = ['name'=>$name ? $name : $before->name,'email'=>$email ?
                 $email : $before->email,'phone'=>$phone ? $phone : $before->phone, 'language'=>$language ? $language : $before->language,'updated_at'=>$date];;
               // $update =  DB::table('users')->where('id',$id)->update($data);
               $update =  DB::table('users')->where('id',$id)->update($data);
                if($update){
                    $result = array("status"=> true, "message"=>"User update success");
                }
                else{
                    $result = array("status"=> false, "message"=>"User not update success");
                }
            }
            else{
                 $result = array("status"=> false, "message"=>"User not update success");
            }    
       echo json_encode($result);
    }


    public function user_change_password(Request $request)
    {
        if(!empty($request->input()))
        {
            $old_password = $request->old_password;
            $new_password = $request->new_password;
            $id = $request->id;
             $users =  new User();
            
            $user =   $users->where("id",$id)->first();
            if($old_password==$new_password)
            {
                $result = array("status"=> false, "message"=>"Old Password and New Password should not be same");
            }
            else
            {
                if (!$user) {
                    $result = array("status"=> false, "message"=>"invalid old password");
                    
                 }

                 if (!Hash::check($old_password, $user->password)) {
                    $result = array("status"=> false, "message"=>"invalid old password");
                 }
                 else{
                    
                //    $result = array("status"=> false, "message"=>"invalid old password");
                    $data['password'] = Hash::make($new_password);
                  
                    $update = $user->where('id',$id) ->update($data);
                    $result = array("status"=> true, "message"=>"change password Successfully");
               }  
            }
         echo json_encode($result);
        }
    }
    

    public function update_admin_profile(Request $request)
    {
             if(!empty($request->input()))
            {
                   $image_url=url('public/images/userimage.png');
              //  dd($request->file());
                 //  dd($request->input());
                $id = $request->id;
                $usreData = DB::table('users')->where('id',$id)->first();
                $users =  new User();
                 $fileimage="";
                   $image_url='';
                   if($request->hasfile('file'))
                  {
                    $file_image=$request->file('file');
                    $fileimage=md5(date("Y-m-d h:i:s", time())).".".$file_image->getClientOriginalExtension();
                    $destination=public_path("images");
                    $file_image->move($destination,$fileimage);
                    $image_url=url('public/images').'/'.$fileimage;
                 
                  }
                  else
                  {
                    $image_url= $usreData->image;
                  }
                $user =   $users->where("id",$id)->first();
                $data['name'] = isset($request->name)? $request->name: $user->name;
                $data['image']=$image_url;
   
                $update = User::where('id', $id)->update($data);

                //$update =DB::table('users')->where('id',$id) ->update($data);
                //$update = $user->where('id',$id) ->update($data);
                if($update)
                {
                    $result = array("status"=> true, "message"=>"Profile Update Successfully");
                }
                else
                {
                    $result = array("status"=> true, "message"=>"Profile Update Fail");
                }
            }
        echo json_encode($result);
    } 


            public function userchangeStatus(Request $request)
            {
               // dd($request->input());
                $id = $request->user_id;
                $status = $request->status;
                $data = ['status'=>$status,'reason'=>isset($request->reason) ? $request->reason : '' ];
                $update=  User::where('id', $id)->update($data);
                if($update){
                    $result = array("status"=> true, "message"=>"User status  deactive successfully ");
                }
                else{
                    $result = array("status"=> false, "message"=>"not update status");
                }
                echo json_encode($result);
            }

            public function userchangestatusactive(Request $request)
            {
              //  dd($request->input());
                $id = $request->id;
                $status = $request->status;
                $data1 = ['status'=>$status];
               // $updated=  DB::table('users')->where('id',$id)->update($data);
                 //User::where('id', $id)->update($data);
                 $updated=  User::where('id', $id)->update($data1);
                if($updated){
                    $result = array("status"=> true, "message"=>"User status  active successfully ");
                }
                else{
                    $result = array("status"=> false, "message"=>"not update status");
                }
                echo json_encode($result);
            }

            
    
}
