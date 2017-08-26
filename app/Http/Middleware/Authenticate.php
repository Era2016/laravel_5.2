<?php

namespace App\Http\Middleware;

use App\Model\Common;
use App\Model\Role;
use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        // TODO 权限验证
        $userId = \auth()->user()->getAuthIdentifier();
        $userPermissions = Common::getPermissionsByUser($userId);
        $permissions = array_column($userPermissions, 'description');

        $path = $request->path();
        if (in_array($path, $permissions)) {
            return $next($request);
        } else {
            //return redirect()->back()->withInput();
            return response('Access Forbidden', 403);
        }
        //return $next($request);
    }
}
