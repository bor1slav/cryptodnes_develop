<?php

namespace Charlotte\Administration\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AdministratorLogged
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
        $logged = Auth::guard(config('administration.guard'))->check();

        if ($logged && Route::currentRouteName() == 'administration.login') {
            return redirect()->route('administration.index');

        }

        if (!$logged && Route::currentRouteName() != 'administration.login') {
            return redirect()->route('administration.login');
        }
        return $next($request);
    }
}
