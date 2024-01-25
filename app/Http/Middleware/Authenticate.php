<?php

namespace App\Http\Middleware;

namespace App\Http\Middleware;

//use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return JsonResponse|RedirectResponse|mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (auth()->guard($guard)->guest()) {
            if ($guard == "web"){
                return redirect()->route('web.login');
            }
            return returnResponseJson(['message'=>'Unauthorized.'], 401);
        }

        return $next($request);
    }
}
