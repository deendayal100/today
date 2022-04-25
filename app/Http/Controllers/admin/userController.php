<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use App\Models\User;

class userController extends Controller
{
    public function index()  //In Use
    { 
        $users=User::where('role',97)->where('role', '!=' , 98)->where('role', '!=' , 99)->where('status', '!=' , 4)->orderby('id','desc')->get();
        return view('Pages.customer', compact('users'));
    }

    public function rewords_list()  //In Use
    { 
        $users=User::where('role',97)->where('role', '!=' , 98)->where('role', '!=' , 99)->where('status', '!=' , 4)->orderby('id','desc')->get();
        return view('Pages.rewords_list', compact('users'));
    }
    public function statistics_list()  //In Use
    { 
        $users=User::where('role',97)->where('role', '!=' , 98)->where('role', '!=' , 99)->where('status', '!=' , 4)->orderby('id','desc')->get();
        return view('Pages.statistics_list', compact('users'));
    }
    public function userview(Request $request,$id){   //In Use //RR
        $id = $request->id;
        $user = DB::table('users')->where('id', $id)->first();
        return view('Pages.master.user_view',compact('user'));
    }

    public function userchangeStatus(Request $request)  //In Use //RR
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

    public function userchangestatusactive(Request $request)   //In Use //RR
    {
        $id = $request->id;
        $status = $request->status;
        $data1 = ['status'=>$status];

        $updated=  User::where('id', $id)->update($data1);
        if($updated){
            $result = array("status"=> true, "message"=>"User status  active successfully ");
        }else{
            $result = array("status"=> false, "message"=>"not update status");
        }
        echo json_encode($result);
    }

    public function edit($id){  //In Use //RR
        $users = User::where('id',$id)->first();
        return view('Pages.user-edit', compact('users')); 
    }

    public function updateData(Request $request)  //In Use //RR
    {      
        $validatedData = $request->validate([
            'user_id' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'phone' => 'required'
          ]);

          $id    = $request->user_id;
          $fname = $request->fname;
          $lname = $request->lname;
          $email = $request->email;
          $phone = $request->phone;

            $before = DB::table('users')->where('id',$id)->first();
            $date = date("Y-m-d H:i:s");
            
            if($before)
            {
                $data = array(
                'fname' => isset($fname)?$fname:$before->fname,
                'lname' => isset($lname)?$lname:$before->lname,
                'email' => isset($email)?$email:$before->email,
                'phone' => isset($phone)?$phone:$before->phone,
                'updated_at' => $date
                );

               $update =  DB::table('users')->where('id',$id)->update($data);
                if($update){
                    $result = array("status"=> true, "message"=>"User update successfully");
                }
                else{
                    $result = array("status"=> false, "message"=>"User not update successfully");
                }
            }else{
                 $result = array("status"=> false, "message"=>"User not updated");
            }    
       echo json_encode($result);
    }

    public function delete(Request $request, $id)  //In Use //RR
    {   
        $id = $request->id;
        $data = array('status' => 4);
        $updates =  DB::table('users')->where('id',$id)->update($data);
        // $user = User::where('id',$id)->delete();
        if($updates){
            return redirect('/user_list');
        }
    }

    //========================================================================================================================

    // public function changeStatus(Request $request){
    //     $id = $request->user_id;
    //     $status = $request->status;
    //     $data = ['status'=>$status];
    //     $update =  DB::table('users')->where('id',$id)->update($data);
    //     if($update){
    //         $result = array("status"=> true, "message"=>"update status");
    //     }
    //     else{
    //         $result = array("status"=> false, "message"=>"not update status");
    //     }
    // }


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
        }elseif($emailTaken > 0){
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
            }else{
                $result=array('status'=>false,'message'=> 'Data Insert Not Successfully.');
            }
        }
        echo json_encode($result);
    }

   

    




    public function updateData1(Request $request)
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
            if($request->hasfile('file')){
                $file_image=$request->file('file');
                $fileimage=md5(date("Y-m-d h:i:s", time())).".".$file_image->getClientOriginalExtension();
                $destination=public_path("images");
                $file_image->move($destination,$fileimage);
                $image_url=url('public/images').'/'.$fileimage;
            }else{
                $image_url= $usreData->image;
            }

            $user =   $users->where("id",$id)->first();
            $data['name'] = isset($request->name)? $request->name: $user->name;
            $data['image']=$image_url;

            $update = User::where('id', $id)->update($data);

            if($update){
                $result = array("status"=> true, "message"=>"Profile Update Successfully");
            }else{
                $result = array("status"=> true, "message"=>"Profile Update Fail");
            }
        }
        echo json_encode($result);
    } 
            
    
}
