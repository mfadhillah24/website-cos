<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureDivisionScope
{
    /**
     * Role names that have division scope restrictions.
     */
    protected const KABID_ROLES = [
        'Kabid Networking',
        'Kabid Programming',
        'Kabid Desain Komunikasi Visual',
    ];

    /**
     * Roles that bypass all division scoping (full access).
     */
    protected const BYPASS_ROLES = [
        'Super Admin',
        'Admin',
        'Ketua Umum',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        // Bypass scope for privileged roles
        foreach (self::BYPASS_ROLES as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // Apply division scope for Kabid roles
        foreach (self::KABID_ROLES as $role) {
            if ($user->hasRole($role)) {
                // Primary: use division_id directly stored on user record
                if ($user->division_id) {
                    $request->attributes->set('scoped_division_id', $user->division_id);
                }
                break;
            }
        }

        return $next($request);
    }
}
