<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\DB;

class UserIndentify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->hasHeader('uuid') || $request->header('uuid') == null)
        {
            return  response()->json(['message' => 'User is not authenticated!'], 401);
        }
        if($request->user() == null)
        {
            return  response()->json(['message' => 'User is not authenticated!'], 401);
        }
        $uuid = $request->header('uuid');
        $user = User::where('id',$request->user()->id)->first();
        if($user->identifier != $uuid)
        {
            return  response()->json(['message' => 'User is not authenticated!'], 401);
        }
        return $next($request);
    }
}
