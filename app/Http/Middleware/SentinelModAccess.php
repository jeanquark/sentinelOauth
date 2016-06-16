<?php namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelModAccess
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
        if (Sentinel::guest()) { //instead of $this->auth->guest()
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        } elseif (Sentinel::check()) {
            //if (Sentinel::hasAccess('admin')) {
            if (Sentinel::inRole('mod') || Sentinel::inRole('admin')) {
                return $next($request);
                //return 'Your are an admin';
            } else {
                //return redirect()->guest('login');
                $user = $user = Sentinel::getUser();
                return redirect()->route('home')->with('success', 'Welcome ' . $user->email . '!');
            }
        }       
    }
}
