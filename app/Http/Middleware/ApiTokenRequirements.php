<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class ApiTokenRequirements extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if(!$request->hasHeader('uuid') || $request->header('uuid') == null)
        {
            return  response()->json(['message' => 'uuid is required!'], 400);
        }
        $request->validate([
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'grant_type' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $request['username'] = $request['email'];
        return $next($request->replace($request->except('email')));
    }
}
