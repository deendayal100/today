<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Verification;
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\SMTP; 
use App\Models\Users;
use App\Models\User;
use URL;
use Illuminate\Http\Response;
use PHPMailer\PHPMailer\Exception;
use Carbon\Carbon;
use DB;
use Hash;
use DateTime;
use Session;


class LoginController extends Controller
{

    public function storetoken(Request $request)
    {
        dd($request->all());
    }
    public function index()
    {
         return view('wemarkthespot.login');
    }
    public function signup()
    {
        $country_codedata =DB::table('country_codes')->get();
        return view('wemarkthespot.signup',compact('country_codedata'));
    }

public function forgotadminpasswordformcheck(Request $request )
            {
            
                if(!empty($request->input()))
                {
                    date_default_timezone_set('Asia/Kolkata');
                    $date = date("Y-m-d h:i:s", time());
                    $email = $request->input('email');
                    $request->session()->put('email',$email);
                    $checkemail = Users::where('email',$email)->first();
                    
                    if(!empty($checkemail))
                    {
                        
                      //  $redriecturl = "adminotp-verifictionforget/".$checkemail->id;

                          $redriecturl = "adminotp-verifictionforget";
                        $otp =  mt_rand(100000,999999);
                        $subject="Forgot password";
                        $message = "Forgot password OTP ". $otp;
                        $up_otp = ['otp'=>$otp,'email'=>$request->email, 'create_at'=>$date, 'update_at'=>$date];
                        
                        
                        $check_email2=DB::table('password_otp')->where('email', $email)->first();
                        if(!empty($check_email2))
                        {
                            $upt_success = DB::table('password_otp')->where('email', $email)->update($up_otp);
                        }
                        else
                        {
                            $upt_success = DB::table('password_otp')->insert($up_otp);
                        }
                        if($upt_success)
                        {
                            $this->sendMail($request->email,$subject,$message);
                            $result = array('status'=> true, 'message'=>'OTP sent successfully',"url"=>$redriecturl); 
                        }
                        else
                        {
                            $result = array('status'=> false, 'message'=>'OTP not Send');
                        }
                    }
                    else
                    {
                        $result = array("status"=> false, "message"=>"Invalid Email Address.");
                    }
                }
                echo json_encode($result);

            }
            public function adminotpverifictionforget()
      {
        $email = Session::get("email");

            $user_data=Users::where('email',$email)->first();
        //   dd($user_data);
          //  $resend_otp = url('resend_otp')."/".$user_data->id;
             $resend_otp = url('resend_otp');
           return view('Pages.adminotpverifictionforget',compact('user_data','resend_otp'));
      }

        public function adminverify_otp(Request $request)
      {
      
      
          $id = $request->id;
          $email = $request->email;
          if((!isset($request->digit1)) || (!isset($request->digit2)) || (!isset($request->digit3)) || (!isset($request->digit4)) || (!isset($request->digit5)) || (!isset($request->digit6)))
          {
                   $result=array('status'=>false,'message'=>'Invalid OTP ');
          }
          else
          {

       
         $otp=$request->digit1.$request->digit2.$request->digit3.$request->digit4.$request->digit5.$request->digit6;
        $otp = (int)$otp; 
        $date1=new DateTime(date('d-m-Y h:i:s',time()));
        $res=DB::table('password_otp')->where('email',$email)->first();
        
        if($res){
                // $date2=new DateTime($res->verify_at); 
                $res=DB::table('password_otp')->where('otp',$otp)->first(); 

                if($res){
                    
                    $redriecturl = url('adminforgetpasswordview')."/".$request->id;
                            $res=DB::table('password_otp')->where('email',$email)->delete();  
                            $data = Users::where('email',$email)->update(['email_verified_at'=>$date1]);
                            $result=array('status'=>true,'message'=>'OTP verify succesfully','url'=>$redriecturl);                   
                    
                    }else{   
                        $result=array('status'=>false,'message'=>'Invalid OTP ');
                    }     
        }else{
            $result=array('status'=>false,'message'=>'email not exits ');
        }
           }
        echo json_encode($result);
      }
      public function adminforgetpasswordview($id)
      {
        return view("Pages.adminforgetpasswordview",compact('id'));
      }
      public function verify_adminforgetpassword(Request $request)
      {
        if($request->input())
        {
        
            $id = $request->input('id');
            $password =  hash::make($request->password);
        
            $update = Users::where('id',$id)->update(array('password'=>$password));
            if($update)
            {
                $result=array('status'=>true,'message'=>'Password Reset Successfully.','url'=>"login");
            }
            else
            {
                $result=array('status'=>false,'message'=>'Password Reset Failed.');
            }
            echo json_encode($result);
        }

        
      }
    public  function signupuser(request $request)
    {
    
    

        $Validation = Validator::make($request->all(),[
                'name' => 'required',
                'password' => 'required|min:5',
                'location'=>'required',
                'cpassword'=>'required',  
                'email' => 'required',
                'business_type'=>'required',
              //  'upload_doc'=>'required',

                //'termsconditions'=>'required'
        ], [
                'name.required' => 'Business Owner Name is required',
                'password.required' => 'Password is required',
                'location.required'=>"location is required",
                'cpassword.required'=>"Conform Password is required",
                'business_type.required'=>"Please Select business type",
             //   'upload_doc'=>"Upload Commercial License",
                 // 'termsconditions'=>"Accepted Terms & Conditions"
            ]);

        if($Validation->fails())
        {
            return redirect('/signup')->withErrors($Validation)->withInput();    
        }
        else
        {
           $temp_user = DB::table('temp_users')->where('email',$request->email)->first();
        
           if(isset($temp_user))
           {
            DB::table('temp_users')->where('email',$request->email)->delete();
           }
           // echo $request->hasfile('image');
             $termsconditions =$request->input('termsconditions');
        //     $email =$request->input('email');
            if(empty($request->hasfile('image')))
            {
               $result= array("status"=>false,"image"=>false, "message"=>"Please select profile image");
            }
            else if(!isset($termsconditions))
            {
                $result= array("status"=>false,"termsconditions"=>false, "message"=>"Please accept Terms & Conditions & Privacy Policy");
            } 
            else{
                $emailexitc = Users::where('email',$request->email)->count();
             
                if($emailexitc>0)
                {
                          $result= array("status"=>false,"email"=>false, "message"=>" User already registered");
                }
                else
                {
                    $otp =  mt_rand(100000,999999);
       
                   $fileimage="";
                   $image_url='';
                   if($request->hasfile('image'))
                  {
                    $file_image=$request->file('image');
                    $fileimage=md5(date("Y-m-d h:i:s", time())).".".$file_image->getClientOriginalExtension();
                    $destination=public_path("images");
                    $file_image->move($destination,$fileimage);
                    $image_url=url('public/images').'/'.$fileimage;
                 
                  }
                  else
                  {
                      $image_url=url('public/images/userimage.png');
                  }
                    // upload_doc
                  
                   $upload_doc ="";
                   if($request->hasfile('upload_doc'))
                  {
                    $file_image=$request->file('upload_doc');
                    $fileimage=md5(date("Y-m-d h:i:s", time())).".".$file_image->getClientOriginalExtension();
                    $destination=public_path("upload_doc");
                    $file_image->move($destination,$fileimage);
                    $upload_doc=url('public/upload_doc').'/'.$fileimage;
                  }
                  else
                  {
                    $upload_doc= "";
                  }
                

                  $data = array(
                    'device_token'=>$request->device_token,
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'phone'=>isset($request->phone)? $request->phone : '',
                    'country_code'=>isset($request->country_code)? $request->country_code : '',
                    'location'=>isset($request->location) ? $request->location :'',
                    'lat'=>isset($request->lat) ? $request->lat :'',
                    'long'=>isset($request->long) ? $request->long :'',
                    'password'=>hash::make($request->password),
                    'business_type'=>isset($request->business_type)? $request->business_type : 1,
                      'image'=>$image_url,
                      'upload_doc'=>$upload_doc,
                     'created_at'=>date("Y-m-d h:i:s", time()),
                      'updated_at'=>date("Y-m-d h:i:s", time()),
                      'email_verified'=>0,
                      'role'=>99,
                      'status'=>1,
                      'approved'=>0,
                    );

          //  dd($data);
                    $date = date("Y-m-d h:i:s", time());
                  
                    $subject="Register Otp";
                    $message = "Register  OTP ". $otp;
                    $up_otp = ['otp'=>$otp,'email'=>$request->email, 'create_at'=>$date, 'update_at'=>$date];
                    $upt_success = DB::table('password_otp')->insert($up_otp);
                    DB::table('temp_users')->insert($data);
                    $id = DB::getPdo()->lastInsertId();;
                    //dd($id);
                    if($this->sendMail($request->email,$subject,$message)){
                        //   return view('Pages.email-verification');
                      //  $id =Users::create($data)->id;
                        $request->session()->put('email',$request->email);
                        $result=array('status' => true,'message' =>"Send Email in your Email Address","last_id"=>$id);
                    }else{
                    $result=array('status' => false,'message' =>"Something Went Wrong");
                    }
                }
         }
        }
        echo json_encode($result);
    }
    public  function signupuserold(request $request)
    {
       
        $Validation = Validator::make($request->all(),[
                'name' => 'required',
                'password' => 'required|min:5',
                'location'=>'required',
                'cpassword'=>'required',  
                'email' => 'required|email|unique:users',
                'business_type'=>'required',
                'upload_doc'=>'required',

                'termsconditions'=>'required'
        ], [
                'name.required' => 'Business Owner Name is required',
                'password.required' => 'Password is required',
                'location.required'=>"location is required",
                'cpassword.required'=>"Conform Password is required",
                'business_type.required'=>"Please Select business type",
                'upload_doc'=>"Upload Commercial License",
              //  'termsconditions'=>"Accepted Terms & Conditions"
            ]);

        if($Validation->fails())
        {
            return redirect('/signup')->withErrors($Validation)->withInput();    
        }
        else
        {
             $otp =  mt_rand(100000,999999);
        //   dd($request->file('image'));
               $fileimage="";
               $image_url='';
               if($request->hasfile('image'))
              {
                $file_image=$request->file('image');
                $fileimage=md5(date("Y-m-d h:i:s", time())).".".$file_image->getClientOriginalExtension();
                $destination=public_path("images");
                $file_image->move($destination,$fileimage);
                $image_url=url('public/images').'/'.$fileimage;
             
              }
              else
              {
                  $image_url=url('public/images/userimage.png');
              }
                // upload_doc
              
               $upload_doc ="";
               if($request->hasfile('upload_doc'))
              {
                $file_image=$request->file('upload_doc');
                $fileimage=md5(date("Y-m-d h:i:s", time())).".".$file_image->getClientOriginalExtension();
                $destination=public_path("upload_doc");
                $file_image->move($destination,$fileimage);
                $upload_doc=url('public/upload_doc').'/'.$fileimage;
              }
              else
              {
                $upload_doc= "";
              }
            
         

              $data = array(
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>isset($request->phone)? $request->phone : '',
                'country_code'=>isset($request->country_code)? $request->country_code : '',
                'location'=>isset($request->location) ? $request->location :'',
                'password'=>hash::make($request->password),
                'business_type'=>isset($request->business_type)? $request->business_type : 1,
                  'image'=>$image_url,
                  'upload_doc'=>$upload_doc,
                 'created_at'=>date("Y-m-d h:i:s", time()),
                  'updated_at'=>date("Y-m-d h:i:s", time()),
                  'email_verified'=>0,
                  'role'=>99,
                  'status'=>1,
                  'approved'=>0,
            );

        
              $date = date("Y-m-d h:i:s", time());
              
            $subject="Register Otp";
            $message = "Register Otp OTP ". $otp;
            $up_otp = ['otp'=>$otp,'email'=>$request->email, 'create_at'=>$date, 'update_at'=>$date];
            $upt_success = DB::table('password_otp')->insert($up_otp);
             if($this->sendMail($request->email,$subject,$message)){
                 //   return view('Pages.email-verification');
                  $id =Users::create($data)->id;


                 $result=array('status' => true,'message' =>"Send Email in your Email Address","last_id"=>$id);
     
            }else{
             $result=array('status' => false,'message' =>"Something Went Wrong");
          //  return view('signup');
        }
     }

        echo json_encode($result);
    }

    public function otp_verifiction(){
      //  $user_data=Users::where('id',$id)->first();
        $email = Session::get('email');

        $user_data= DB::table('temp_users')->where('email',$email)->first();

      //  dd($user_data);
//          $resend_otp = url('resend_otp')."/".$user_data->id;
             $resend_otp = url('resend_otp');
        return view('wemarkthespot.otp-verifiction',compact('user_data','resend_otp'));
    }

     public function sendMail($email,$stubject=NULL,$message=NULL){

        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions
        try {
            $mail->SMTPDebug = 0;   
            $mail->isSMTP();
            $mail->Host="smtp.gmail.com";
            $mail->Port=587;
            $mail->SMTPSecure="tls";
            $mail->SMTPAuth=true;
            $mail->Username= "wemarkspot@gmail.com"; //"raviappic@gmail.com";
            $mail->Password="dwspcijqkcgagrzl";//"audnjvohywazsdqo";
            $mail->addAddress($email,"User Name");
            $mail->Subject=$stubject;
            $mail->isHTML();
            $mail->Body=$message;
            $mail->setFrom("wemarkspot@gmail.com");
            $mail->FromName="We Mark The Spot";
            
            if($mail->send())
            {   
                return 1;                 
            }
            else
            { 
                return 0;
            }

        } catch (Exception $e) {
             return 0;
        }
    }

    public function verifyOtp(Request $request){
     //   dd($request->input());

        $email = $request->email;
         $otp=$request->digit1.$request->digit2.$request->digit3.$request->digit4.$request->digit5.$request->digit6;
        $otp = (int)$otp; 
         if(!empty($otp))
        {
                $res1=DB::table('password_otp')->where('otp',$otp)->first(); 
              
                if($res1)
                {
                    $date1=new DateTime(date('d-m-Y h:i:s',time()));
                    $res=DB::table('password_otp')->where('email',$email)->first();
                  
                
                    if($res){
                        // $date2=new DateTime($res->verify_at); 
                            $res=DB::table('password_otp')->where('otp',$otp)->first(); 
                             $temp_users=DB::table('temp_users')->where('email',$email)->first();
                            if($temp_users){
                              
                                     $res=DB::table('password_otp')->where('email',$email)->delete();  
                                      $image_url=url('public/images/userimage.png');
                                        $date = date("Y-m-d h:i:s", time());
                                        $updateData['device_token'] = $temp_users->device_token;
                                        $updateData['name'] = $temp_users->name;
                                 $updateData['username'] = $temp_users->name;
                                    $updateData['email'] = $temp_users->email;
                                       $updateData['country_code']=$temp_users->country_code;
                                    $updateData['phone'] =    $temp_users->phone;
                                  
                                      
                                    
                                 
                                    $updateData['location']=$temp_users->location;
                                     $updateData['lat']=$temp_users->lat;
                                      $updateData['long']=$temp_users->long;
                                    $updateData['password']=$temp_users->password;
                                    $updateData['business_type']=$temp_users->business_type;
                                     $updateData['role']=$temp_users->role;
                                    $updateData['image'] =  isset($temp_users->image)? $temp_users->image : $image_url ;
                                    $updateData['created_at'] =   $date ;
                                    $updateData['updated_at'] =   $date ;
                                    $updateData['email_verified']=0;
                                     $updateData['role']=99;
                                      $updateData['status']=1;
                                        $updateData['approved']=0;
                                     $updateData['upload_doc']=$temp_users->upload_doc;
                                   //  dd($updateData);
                                     Users::create($updateData);
//                                    DB::table('users')->insert($updateData);
                                     DB::table('temp_users')->where('id',$temp_users->id)->delete();
                                    
                           
                                     $data = Users::where('email',$email)->update(['email_verified_at'=>$date1]);
                                     $result=array('status'=>true,'message'=>'verify succesfully');                   
                                       //yaha databse me entry hogi  user ki sari details          
                                
                                }else{   
                                    $result=array('status'=>false,'message'=>'Invalid OTP ');
                                }     
                    }else{
                        $result=array('status'=>false,'message'=>'email not exits ');
                    }
                }
                else
                {
                 $result = array('status'=> false, 'message'=>'Invalid OTP','otp'=>false);            
                }
        
        }
       
        echo json_encode($result);
      }



       public function checklogin(Request $request)
    {
//       dd($request->input());
        if($request->input())
        {
            $business  =  Users::where('email',$request->email)->first();
             
        if(!is_null($business))
        {
            if(!Hash::check($request->password, $business->password))
            {
               // $result=array('status'=>false,'message'=> 'Invalid Password','check'=>"password");
                 $status = false;
                         $message = "Invalid Password";
                         $check = "password";
                        return response()->json(compact('status','message','check'));
            }
            else
            {
                $remember_me = $request->has('remember') ? true : false; 

                $where =array('email'=>$request->email);
                $business  =  Users::where($where)->first();
             //  dd($business->status);
                if($business->status==2)
                {
                     $request->session()->put('user_ids', $business->id);
                    $request->session()->put('id', $business->id);
                    $request->session()->put('role', $business->role);
                    $request->session()->put('name', $business->name);
                    $request->session()->put('email', $business->email);
                    $request->session()->put('phone', $business->phone);
                    $request->session()->put('upload_doc', $business->upload_doc);
                    $request->session()->put('address', $business->business_type);
                     $request->session()->put('image', $business->image);
                     
  
                     $device_token = $request->device_token;
                     Users::where('id',$business->id)->update(array('device_token'=>$device_token)); 
               if($remember_me==true)
                    {
                        $minutes = 14400;
                        $r_token =md5(date("Y-m-d",time()));
                        //exit;
                        $cooky=(cookie('remember_me',$r_token, $minutes));
                        $response = new Response();
                        $response->withCookie($cooky);
                        Users::where($where)->update(array('remember_token'=>$r_token));
                        //            $result=array('status'=>true,'message'=>'Login succesfully'); 
                        $status = true;
                         $message = "Login succesfully";
                        return response()->json(compact('status','message'))->cookie($cooky);
                    //    return redirect()->to('/dashboard') ->withSuccess('Signed in')->withCookie($cooky);
                    }else{
                        $minutes = 0;
                    //    $result=array('status'=>true,'message'=>'Login succesfully');   
                        $status = true;
                        $message = "Logged in succesfully";
                        return response()->json(compact('status','message'))->cookie('remember_me','', $minutes);
                    
                    //    return redirect()->to('/dashboard') ->withSuccess('Signed in')->withCookie(cookie('remember_me','', $minutes));
                    }

                    // $result=array('status'=>true,'message'=>'Login succesfully');  
                }
                else if($business->status==3)
                {
                    $minutes=0;
                    $status = false;
                    $message = "Your Request has been Rejected by Admin.";
                    return response()->json(compact('status','message'))->cookie('remember_me','', $minutes);
                }
                else
                {
                    $minutes=0;
                    $status = false;
                    $message = "Your request is yet to be approved by Admin. You will receive a confirmation mail over registered mail id, once admin responds over your application.";
                    return response()->json(compact('status','message'))->cookie('remember_me','', $minutes);
                
                //    $result=array('status'=>false,'message'=>'Your request is yet to be approved by Admin. You will receive a confirmation mail over registered mail id, once admin responds over your application.');  
                }
                 
            }
            
        }
        else
        {
            $minutes=0;
                    $status = false;
                    $message = "Invalid Email address";
            //        $result=array('status'=>false,'message'=> 'Invalid Email address','check'=>"email");
                    $check="email";
                    return response()->json(compact('status','message','check'))->cookie('remember_me','', $minutes);
            //$result=array('status'=>false,'message'=> 'Invalid Email address','check'=>"email");
        }
//        echo json_encode($result);

        }
    }

    
    public function my_profile_edit(Request $request){
      //dd($request->input());
        $validate = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required',
                'business_name'=>'required',
                'location' => 'required'
        ]);

        if($validate->fails()){
           $result = array('status'=>false, 'message'=>'Validation failed', 'error'=>$validate->errors());
        }
        else{
            $data = array();
            $user_id = session()->get('id');
          //  $user = new Users();
            $user = Users::where('id', $user_id)->first();
            
            $fileimage="";
               $image_url='';
               if($request->hasfile('image'))
              {
                $file_image=$request->file('image');
                $fileimage=md5(date("Y-m-d h:i:s", time())).".".$file_image->getClientOriginalExtension();
                $destination=public_path("images");
                $file_image->move($destination,$fileimage);
                $image_url=url('public/images').'/'.$fileimage;
              }
              else{
                  $image_url = $user->image;
              }
              $fileimage2="";
              $business_image_url='';
              if(!empty($request->hasfile('business_images')))
             {
               $file_image=$request->file('business_images');
               $fileimage2=md5(date("Y-m-d h:i:s", time())).".".$file_image->getClientOriginalExtension();
               $destination=public_path("images");
               $file_image->move($destination,$fileimage2);
               $business_image_url=url('public/images').'/'.$fileimage2;
             }
             else{
                 $business_image_url = isset($request->old_business_images) ? $request->old_business_images : $user->business_images;
             }
              
            
             $data['name']=isset($request->name)? $request->name:$user->name;
             $data['business_name']=isset($request->business_name) ? $request->business_name : $user->business_name;
             $data['email']=isset($request->email)? $request->email:$user->email;
             $data['country_code']=isset($request->country_code)? $request->country_code:$user->country_code;
             $data['phone']=isset($request->phone)? $request->phone:$user->phone;
             $data['location']=isset($request->location)? $request->location:$user->location;

             $data['lat']=isset($request->lat)? $request->lat:$user->lat;
             $data['long']=isset($request->long)? $request->long:$user->long;

             $data['opeing_hour']=isset($request->opeing_hour)? $request->opeing_hour:$user->opeing_hour;
             $data['closing_hour']=isset($request->closing_hour)? $request->closing_hour:$user->closing_hour;
             $data['business_type']=isset($request->business_type)? $request->business_type:$user->business_type;
             $data['image']=$image_url;
             $data['business_category']=isset($request->business_category)? $request->business_category:$user->business_category;
             $data['business_sub_category']=isset($request->business_sub_category)? $request->business_sub_category:$user->business_sub_category;
             $data['description']=isset($request->description)? $request->description:$user->description;
             $data['business_images']=$business_image_url;
          //   dd($data);
                  $update = $user->where('id',$user_id) ->update($data);
                  if($update){
                          $result = array('status'=>true, 'message'=>'Profile Updated Successfully');
                        }else{
                               $result = array('status'=>false, 'message'=>'Something Went Wrong ');
                        }
              
        }
        echo json_encode($result);
    }

    public function signout()

    {
        Session::flush();
        return Redirect('signin');
    }
    public function forgetpsd()
    {
        return view('wemarkthespot.forgetpsd');
    }
    public function forgotPassword(Request $request) {
        date_default_timezone_set('Asia/Kolkata');
           $email = $request->email;
         // $emailcheck=Users::where(['email'=>$email,'status'=>99])->first();
    $request->session()->put('email',$email);

         $otp =  mt_rand(100000,999999);
        $date = date("Y-m-d h:i:s", time());
        if(!empty($email))
        {
                 $check_email=Users::where(['email'=>$email])->first();
               // dd($check_email);

                
            
               $subject="Forgot password";
               $message = "Forgot password OTP ". $otp;
               if(!empty($check_email))
               {
                     //$redriecturl = "otp-verifictionforget/".$check_email->id;
                $redriecturl = "otp-verifictionforget";
                    $up_otp = ['otp'=>$otp, 'create_at'=>$date, 'update_at'=>$date,'email'=>$email];
                    if($this->sendMail($email,$subject,$message))
                    {
                        $check_email2=DB::table('password_otp')->where('email', $email)->first();
                            if(!empty($check_email2))
                            {
                                $upt_success = DB::table('password_otp')->where('email', $email)->update($up_otp);
                            }
                            else
                            {
                                $upt_success = DB::table('password_otp')->insert($up_otp);
                            }
                            if($upt_success)
                            {
                            
                                $result = array('status'=> true, 'message'=>'OTP sent successfully',"url"=>$redriecturl); 
                            }
                            else
                            {
                                $result = array('status'=> false, 'message'=>'OTP not Send');
                            }
                    }
                    else
                    {
                        $result = array('status'=> false, 'message'=>'OTP not Send');
                    }
          
               }
               else
               {
                    $result = array('status'=> false, 'message'=>'Invalid email address','email'=>false);
               }
           }
           else
           {
               $result = array('status'=> false, 'message'=>'Email is required');
           }
           echo json_encode($result);
       }

       public function otp_verifictionforget()
       {
        $email = Session::get('email');

        $user_data=Users::where('email',$email)->first();
        //   dd($user_data);
     //   $resend_otp = url('resend_otp')."/".$user_data->id;
           $resend_otp = url('resend_otp');
           return view('wemarkthespot.otp-verifictionforget',compact('user_data','resend_otp'));
       }

       public function verify_otpforget(Request $request)
       {
       // dd($request);
        date_default_timezone_set('Asia/Kolkata');
     
        $email = $request->email;
        if((!isset($request->digit1)) || (!isset($request->digit2)) || (!isset($request->digit3)) || (!isset($request->digit4)) || (!isset($request->digit5)) || (!isset($request->digit6)) )
        {
            $result = array('status'=> false, 'message'=>'Invalid OTP','otp'=>false);
        }
        else
        {
             $otp = $request->digit1.$request->digit2.$request->digit3.$request->digit4.$request->digit5.$request->digit6;
            
       
      
        if(!empty($otp))
        {
          
             $verify_otp = DB::table('password_otp')->where('email', $email)->where('otp', $otp)->first();
         
             if($verify_otp)
             {
                if(!empty($verify_otp))
                {
                   //    $otp_expires_time = Carbon::now()->subMinutes(5);
                  $otp_expires_time=  date('m/d/Y h:i:s', time());
                        if($verify_otp->create_at < $otp_expires_time){
                            $result = array('status'=> false, 'message'=>'OTP Expired.');
                        }
                        else{
                            DB::table('password_otp')->where('email',$email)->delete();
                              $user_data = DB::table('users')->where('email', $email)->first();
                             // $url  =url('forget_pasword_views').'/'.$user_data->id;
                               $url  =url('forget_pasword_views');
                            $result = array('status'=> true, 'message'=>' OTP verified.','url'=>$url);        
                                   
                    }
                }
                else
                {
                    $result = array('status'=> false, 'message'=>'Invalid OTP');
                }
             }
             else
             {
                $result = array('status'=> false, 'message'=>'Invalid OTP','otp'=>false);
             }
                
        }
        else
        {
            $verify_otp = DB::table('password_otp')->where('email', $email)->where('otp', $otp)->first();
         }
            
        }
        
        echo json_encode($result);
       }

      public function forget_pasword_view()
      {
        $email = Session::get('email');

        $user_data=Users::where('email',$email)->first();
        //   dd($user_data);
           return view('wemarkthespot.forget_pasword_view',compact('user_data'));
      }

      public function verify_forgetpassword(Request $request)
      {
        if($request->input())
        {
            $email= $request->email;
            $password= hash::make($request->password);
            $updateData = array('password'=>$password);
            if(Users::where("email",$email)->update($updateData))
            {
                $url = route('signin');
                $request->session()->put('email','');
                $result = array('status'=> true, 'message'=>'Your password reset successfully','url'=>$url);
            }
            else
            {
                $result = array('status'=> false, 'message'=>'Passowrd Updated failed');
            }
            echo json_encode($result);
        }
    
      }
     public function resend_otp(){
           $email= Session::get('email');
    
             date_default_timezone_set('Asia/Kolkata');
        
         // $emailcheck=Users::where(['email'=>$email,'status'=>99])->first();

         $otp =  mt_rand(100000,999999);
        $date = date("Y-m-d h:i:s", time());
        if(!empty($email))
        {
            $usersData=Users::where(['email'=>$email])->first();
         
            if(isset($usersData))
            {
               $check_email= $usersData;
                 
            }
            else
            {
                $check_email=DB::table('temp_users')->where(['email'=>$email])->first();
            }

           // dd($check_email);
               $subject="Resend  OTP";
               $message = "Resend  OTP ". $otp;
               $email = $check_email->email;
               if(!empty($check_email))
               {
                    // $redriecturl = "otp-verifictionforget/".$check_email->id;
                    $up_otp = ['otp'=>$otp, 'create_at'=>$date, 'update_at'=>$date,'email'=>$email];
                    if($this->sendMail($email,$subject,$message))
                    {
                            $check_email2=DB::table('password_otp')->where('email', $check_email->email)->first();
                            if(!empty($check_email2))
                            {
                                $upt_success = DB::table('password_otp')->where('email', $email)->update($up_otp);
                            }
                            else
                            {
                                $upt_success = DB::table('password_otp')->insert($up_otp);
                            }
                            if($upt_success)
                            {
                            
                                  return redirect()->back()->with('message','Resent OTP Successfully');
                            }
                            else
                            {
                                   return redirect()->back()->with('message','OTP not Send');
                            }
                    }
                    else
                    {
                         return redirect()->back()->with('message','OTP not Send');
                    }
                 }
              
           }
          
            
    }
   
}
