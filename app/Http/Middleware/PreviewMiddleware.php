<?php

namespace Admins\Http\Middleware;

use Admins\Administrator;
use Admins\Libraries\PreviewHelper;
use Auth;
use Closure;

class PreviewMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route = $request->route()->getName();
        $user = Administrator::where('_id', Auth::user()->_id)->first();
        $test = isset($user->routeAdmins) ? $user->routeAdmins : [];
        $accept = ["home", 'auth.logout', 'campaigns::show', 'edit.profile', 'campaigns::reject::campaign',
            'campaigns::active::campaign', 'campaigns::admin::campaign', 'issuetracker::show', 'issuetracker::show',
            'admin::clients::show', 'network::show', 'network::search', 'issuetracker::close'];

        if (!in_array($route, $accept)) {
            array_unshift($test, PreviewHelper::getNameRoute($route) . '/' . $route);
        }
        if (count($test) > 5) {
            array_pop($test);
        }
        $diff = array_unique($test);
        $user->routeAdmins = $diff;
        $user->tour_taken = true;
        $user->save();
        return $next($request);
    }
}
