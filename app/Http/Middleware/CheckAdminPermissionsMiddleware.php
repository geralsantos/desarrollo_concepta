<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminPermissionsMiddleware
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
        $admin = auth()->guard('admin')->user();

        if ($admin->role_id == ROLE_ADMIN) {
            return $next($request);
        } else{
            return redirect()->back();
        }
    }
}
