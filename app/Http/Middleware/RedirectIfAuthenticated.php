<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
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
		$routeName = $request->route()->getName();

		switch ($routeName) {
			case 'home':
				if (!$request->session()->get('authenticated')) {
					return redirect('/');
				}

				break;
			default:
				if ($request->session()->get('authenticated')) {
					return redirect('/home');
				}

				break;
		}

        return $next($request);
    }
}
