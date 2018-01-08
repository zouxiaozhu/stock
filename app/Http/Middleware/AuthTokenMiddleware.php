<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/12
 * Time: 22:11
 */

namespace App\Http\Middleware;
use Closure;
use App\Http\Controllers\ApiAuth\AuthTokenController;
class AuthTokenMiddleware{

    public function __construct(AuthTokenController $authToken)
    {
        $this->authToken = $authToken;
    }

    public function handle($request, Closure $next)
    {
        if($this->authToken->checkToken($request)){
            return $next($request);
        }
        return response()->error(1003, 'No Permission');

    }
}