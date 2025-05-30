<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        // Diviser la chaîne de rôles en tableau
        $rolesArray = explode(',', $roles);
        // $user = $request->user();
        
        // Vérifier si l'utilisateur a au moins un des rôles spécifiés
        $hasRole = false;
                // dd($user->roles->pluck('name')); // Décommente pour voir tous les rôles de l'utilisateur

        foreach ($rolesArray as $role) {
            if ($request->user() && $request->user()->hasRole(trim($role))) {
                $hasRole = true;
            }
        }
        
        if (!$hasRole) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}