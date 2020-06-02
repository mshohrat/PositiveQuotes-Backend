<?php

namespace App\Http\Middleware;

use App\Http\Utils\ResponseUtil;
use App\Role\RoleChecker;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{

    /**
     * @var RoleChecker
     */
    protected $roleChecker;

    public function __construct(RoleChecker $roleChecker)
    {
        $this->roleChecker = $roleChecker;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = $request->user();

        if ( ! $this->roleChecker->check($user, $role)) {
            if($request -> expectsJson())
            {
                return ResponseUtil::handleErrorResponse('Action is not allowed for this user!',ResponseUtil::NOT_ALLOWED);
            }
            else
            {
                Auth::logout();
                return redirect() -> route('login') -> withErrors(['authorize'=>'Action is not allowed for this user!']);
            }
        }
        else {
            return $next($request);
        }
    }
}
