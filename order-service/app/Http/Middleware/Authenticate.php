<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Mockery\Generator\StringManipulation\Pass\Pass;


class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            //dd($request->isMethod('get'));
            try {

                if($request->isMethod('get')){
                    //redirect()->route('home');
                    return $next($request);
                }
            }catch (\Exception $exception){
                return abort('404');
            }
           // return $next($request);
        }
        return redirect()->route('login');

    }



}
