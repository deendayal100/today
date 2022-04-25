<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class Admin extends Controller
{
    public function index()
    {
        return view('Pages.login');
    }  
      
    public function forget_password()
    {
        return view("Pages.forgetpsdadmin");
    }

    public function customLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
    
        $remember_me = $request->has('remember') ? true : false; 
        
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me))
        {
            $user = auth()->user();
        
            $request->session()->put('id',$user->id);
            $request->session()->put('name',$user->name);
            $request->session()->put('email',$user->email);
            $request->session()->put('user_id',$user->id);
            $request->session()->put('role',$user->role);
            $request->session()->put('use_image',$user->use_image);
            $request->session()->put('phone',$user->phone);
            $request->session()->put('image',$user->image);
            $user = Auth::getProvider()->retrieveByCredentials(['email' => $request->input('email'), 'password' => $request->input('password')]);           
            if($remember_me==true)
            {
                $minutes = 14400;
                $response = new Response();
                $cooky=(cookie('remember_me', $user->remember_token, $minutes));
                return redirect()->to('/dashboard') ->withSuccess('Signed in')->withCookie($cooky);
            }else{
                $minutes = 0;
                return redirect()->to('/dashboard') ->withSuccess('Signed in')->withCookie(cookie('remember_me','', $minutes));
            }
          
        }else{
            return redirect('login')->with('msg', 'Please enter valid login credentials.');  
        }
    
    }

  


    public function dashboard()
    {
        //dd('jjj');
        //if(Auth::check()){
        $total_user = User::where('role',97)->count();
        $total_buiness = User::where('role',99)->count();
        $total_service = 0;
            
        return view('Pages.dashboard',compact('total_user','total_buiness','total_service'));
        //}
        //return redirect("login")->withSuccess('You are not allowed to access');
    }
    

    public function signOut() {
        Session::flush();
        Auth::logout();
        return Redirect('admin'); //redirect back to admin
    } 
    
    public function notification(Request $request)
    {
        if($request->all())
        {
            $ressponse= [];
            $result= [];
            $uds = $request->ids;
            foreach(explode(",",$uds) as $id)
           {
            $Fcm_tokenDetails = User::select('fcm_token')->where('id',$id)->first();
             $ressponse =  $this->sendNotification($Fcm_tokenDetails->fcm_token, array(
                 "title" => "Sample Message", 
                "body" => $request->message,
              ));
           } 
           if($ressponse)
           {
               $result = array('status'=>true,'message'=>$ressponse);
           }
           else
           {
            $result = array('status'=>false,'message'=>$ressponse);
           }
           echo json_encode( $result);
        }


    }

    public function sendNotification($device_token, $message)
    {
        $SERVER_API_KEY = env('Server_Key');
  
        // payload data, it will vary according to requirement
        $data = [
            "to" => $device_token, // for single device id
            "data" => $message
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
      
        curl_close($ch);
      
        return $response;
    }

}
