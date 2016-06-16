<?php namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*public function handle($request, Closure $next)
    {
        if (Sentinel::check()) {
            if (Sentinel::hasAccess('admin')) { //instead of Sentinel::guest()
                if ($request->ajax()) {
                    return response('Unauthorized.', 401);
                } else {
                    return redirect()->guest('login');
                }
            }
        }

        return $next($request);
    }*/

    /*public function handle($request, Closure $next) {
        if (Sentinel::guest()) { //instead of $this->auth->guest()
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        return $next($request);
    }*/

    public function handle($request, Closure $next) {
        if (Sentinel::check()) {
            return $next($request);
        } else {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
    }
}
