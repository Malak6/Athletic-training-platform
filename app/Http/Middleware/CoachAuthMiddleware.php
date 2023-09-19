<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CoachAuthMiddleware
{
    
    public function handle(Request $request, Closure $next)
    {
        $user = auth('sanctum')->user();
        if( $user && $user->roles_id == 2 && $user->is_freez == false){
        return $next($request);
        }
        else {
            return response()->json([
                "Message" => "You can not do this"
            ]);
        }
    }
}
