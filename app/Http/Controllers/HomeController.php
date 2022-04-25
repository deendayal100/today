<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
   public function homepage(){
        if(Session::get('player_id'))
        {
            return redirect("/player-account");
        }
        else
        {
            return view('home');
        }
   }

   public function player_signout(){
        Session::flush();
        Auth::logout();
        return Redirect('/home');
    } 
}
