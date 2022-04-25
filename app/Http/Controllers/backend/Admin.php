<?php

namespace App\Http\Controllers\backend;

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
     

    
        if (auth()->attempt(['email' => $request->input('email'),'role'=>98, 'password' => $request->input('password')], $remember_me))
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
            return redirect('admin')->with('msg', 'Please enter valid login credentials.');  
        }
    
    }

    public function customLoginold(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        // print_r($credentials);
        // exit;
        if (Auth::attempt($credentials)) {
            $user = User::where("email",$request->email)->first();
            // dd( $user->name);
            $request->session()->put('id',$user->id);
            $request->session()->put('name',$user->name);
            $request->session()->put('email',$user->email);
            $request->session()->put('user_id',$user->id);
            $request->session()->put('role',$user->role);
            $request->session()->put('use_image',$user->use_image);
            $request->session()->put('phone',$user->phone);
            $request->session()->put('image',$user->image);

          return redirect()->to('/dashboard') ->withSuccess('Signed in');
          
        }
        return redirect()->back()->with('msg', 'Please enter valid login credentials.');  

    }


    public function dashboard()
    {
        //dd('jjj');
        //if(Auth::check()){
        $total_user = User::where('role',97)->count();
        $total_buiness = User::where('role',99)->count();
            
        return view('Pages.dashboard',compact('total_user','total_buiness'));
        //}
        //return redirect("login")->withSuccess('You are not allowed to access');
    }
    

    public function signOut() {
        Session::flush();
        Auth::logout();
        return Redirect('admin'); //redirect back to admin
    }   
}
