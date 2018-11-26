<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware as BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;

class AdminCheck extends BaseMiddleware
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
