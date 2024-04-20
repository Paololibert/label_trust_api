<?php

namespace App\Http\Middleware;

use Closure;
use Core\Utils\Exceptions\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{

    // @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        if(count($permissions) && $request->user()->user->hasPermissionsTo($permissions))
        {
            return $next($request);
        }

        throw new AuthorizationException(message: "Vous n'avez pas les droits d'accès à cette resource");

        /* if(count($permissions) && Gate::check_middleware($permissions))
        {
            return $next($request);
            //return $this->errorResponse("Vous n'avez pas les droits d'accès à cette resource", [], Response::HTTP_FORBIDDEN);
        } */

        throw new AuthorizationException(message: "Vous n'avez pas les droits d'accès à cette resource");

        // Check if the user has any of the required permissions
        /* foreach ($permissions as $permission) {
            if ($request->user()->hasPermission($permission)) {
                return $next($request);
            }
        } */
        return $next($request);
    }
}
