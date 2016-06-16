<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Sentinel;

class SentinelRedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Sentinel::guest()) { // Check if user is logged in
            //dd('abc');
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
