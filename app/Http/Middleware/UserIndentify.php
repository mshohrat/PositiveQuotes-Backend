<?php

namespace App\Http\Middleware;

use App\Http\Utils\ResponseUtil;
use App\Role\UserRole;
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
            return ResponseUtil::handleErrorResponse('User is not authenticated!',ResponseUtil::UNAUTHORIZED);
        }
        if($request->user() == null)
        {
            return ResponseUtil::handleErrorResponse('User is not authenticated!',ResponseUtil::UNAUTHORIZED);
        }
        $uuid = $request->header('uuid');
        $user = $request->user();
        if($user->identifier != $uuid)
        {
            return ResponseUtil::handleErrorResponse('User is not authenticated!',ResponseUtil::UNAUTHORIZED);
        }
        return $next($request);
    }
}
