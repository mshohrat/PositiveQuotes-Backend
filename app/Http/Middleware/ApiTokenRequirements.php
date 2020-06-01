<?php


namespace App\Http\Middleware;

use App\Http\Utils\ResponseUtil;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class ApiTokenRequirements extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if(!$request->hasHeader('uuid') || $request->header('uuid') == null)
        {
            return ResponseUtil::handleErrorResponse('UUID is required!',ResponseUtil::BAD_REQUEST);
        }
        if(!$request->has('is_guest'))
        {
            $request['is_guest'] = false;
        }
        if($request['is_guest'] == true)
        {
            $request->validate([
                'client_id' => 'required|string',
                'client_secret' => 'required|string',
                'grant_type' => 'required|string',
                'email' => 'required|string',
                'password' => 'required|string',
            ]);
        }
        else {
            $request->validate([
                'client_id' => 'required|string',
                'client_secret' => 'required|string',
                'grant_type' => 'required|string',
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
        }
        $request['username'] = $request['email'];
        return $next($request->replace($request->except('email','is_guest')));
    }
}
