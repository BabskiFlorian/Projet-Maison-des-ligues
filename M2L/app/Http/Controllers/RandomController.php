<?php

namespace App\Http\Controllers;

use App\Models\Collaborateur; // Assurez-vous d'importer votre modèle Collaborateur
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RandomController extends Controller
{
    public function index()
    {
        // Récupérer l'utilisateur actuellement connecté
        $loggedInUser = Auth::user();

        // Récupérer un collaborateur aléatoire de la base de données
        // Exclure l'utilisateur connecté si il existe
        $randomCollaborateur = Collaborateur::inRandomOrder();

        if ($loggedInUser) {
            $randomCollaborateur->where('id_collaborateur', '!=', $loggedInUser->id_collaborateur);
        }

        $randomCollaborateur = $randomCollaborateur->first();

        // Passer à la fois l'utilisateur connecté et le collaborateur aléatoire à la vue
        return view('accueil', compact('loggedInUser', 'randomCollaborateur'));
    }
}