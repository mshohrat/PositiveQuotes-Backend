<?php

namespace App\Http\Middleware;

use App\Role\RoleChecker;
use Closure;
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
            return  response()->json(['message' => 'action is not allowed for this user!'], 405);
        }

        return $next($request);
    }
}
