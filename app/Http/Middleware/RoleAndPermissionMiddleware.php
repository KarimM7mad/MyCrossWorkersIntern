<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\hasRoles;
use App\User;

class RoleAndPermissionMiddleware {
    use hasRoles;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (auth()->user()->hasRole('Admin')) {
            if (auth()->user()->hasAnyPermission(['createEvent', 'readEvent', 'updateEvent', 'deleteEvent', 'cancelReservation ,createStand'])) {
                return $next($request);
            } else {
                abort(401, "Admin with no permissions,can't proceed");
            }
        } 
        else if (auth()->user()->hasRole('normalUser')) {
            if (auth()->user()->hasAnyPermission(['reserveStand', 'updateStand', 'cancelReservation'])) {
                return $next($request);
            } else {
                abort(401, "normalUser with no permissions,can't proceed");
            }
        }
        else return redirect('/register')->with('error','You must be registered to access this page');
    }
}
