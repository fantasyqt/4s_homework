<?php

namespace App\Http\Middleware;

use Closure;

class AdminCheck
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
        $token = $this->auth->setRequest($request)->getToken();
        $user = $this->auth->authenticate($token);
        if ($user->role == "admin") {
            return $next($request);
        }
        return \APIReturn::error("permission_denied", "本操作需要管理员权限", 403);
    }
}
