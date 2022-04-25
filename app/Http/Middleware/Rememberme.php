<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Rememberme
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle(Request $request, Closure $next)
    {
         $value = $request->cookie('remember_me');
         //dd($value);
        if(empty($value))
        {
            
            if(empty(session('id')))
            {
                return redirect('admin');
            }
        }      
        return $next($request);
    }
}
