<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Important pour vérifier l'utilisateur

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifie si un utilisateur est connecté
        if (Auth::check()) {
            // Vérifie si l'utilisateur connecté est un administrateur
            // Assurez-vous que votre modèle User/Collaborateur a une méthode isAdmin()
            if (Auth::user()->isAdmin()) {
                return $next($request); // L'utilisateur est admin, continue la requête
            }
        }

        // Si l'utilisateur n'est pas connecté ou n'est pas admin,
        // redirige-le ou renvoie une erreur 403 (Accès interdit)
        return redirect('/accueil')->with('error', 'Accès non autorisé. Vous n\'êtes pas administrateur.');
        // Ou : abort(403, 'Accès non autorisé');
    }
}