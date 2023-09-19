<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Coach;
use App\Models\Player;
use App\Models\CoachRequest;
use Illuminate\Http\Request;

class PlayerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $email= Player::where('email' , '=' , $request->input('email'))->first();
        if($email){
            return response()->json([
                    "Message" =>"You are already registered , Please login."
            ]);
        }
        
        $coachEmail = CoachRequest::where('email' , '=' , $request->input('email'))->first();
        if($coachEmail){
            return response()->json([
                "Message" =>"You are already registered as a coach , you can not register as a player too."
        ]);
        }

        $coachEmail = Coach::where('email' , '=' , $request->input('email'))->first();
        if($coachEmail){
            return response()->json([
                "Message" =>"You are already registered as a coach , you can not register as a player too."
        ]);
        }
        return $next($request);
    }
}
