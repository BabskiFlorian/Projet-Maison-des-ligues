<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collaborateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage; // Plus besoin d'importer Storage si vous ne gérez pas de fichiers

class CollaborateurController extends Controller
{
    /**
     * Affiche le formulaire de création d'un nouveau collaborateur.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $loggedInUser = Auth::user();
        return view('create', compact('loggedInUser'));
    }

    /**
     * Traite la soumission du formulaire et stocke un nouveau collaborateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validation des données pour la création
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:collaborateur,email',
            'mot_de_passe' => 'required|string|min:8|confirmed',
            'civilite' => 'nullable|string|max:50',
            'categorie' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'date_de_naissance' => 'nullable|date',
            'ville' => 'nullable|string|max:255',
            'pays' => 'nullable|string|max:255',
            'photo' => 'nullable|url|max:2048', // Validation pour une URL
            'est_admin' => 'boolean',
        ]);

        $data = $request->all();

        // Le mot de passe sera haché automatiquement par le cast 'hashed' de votre modèle
        // Assurez-vous que 'est_admin' est correctement traité comme un booléen
        $data['est_admin'] = $request->has('est_admin');

        Collaborateur::create($data);

        return redirect()->route('liste')->with('success', 'Collaborateur créé avec succès !');
    }

    /**
     * Affiche le formulaire pour modifier le collaborateur spécifié.
     *
     * @param  \App\Models\Collaborateur  $collaborateur
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Collaborateur $collaborateur)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/accueil')->with('error', 'Accès non autorisé. Vous devez être administrateur.');
        }

        $loggedInUser = Auth::user();
        // C'EST LA LIGNE MODIFIÉE : 'modifier' au lieu de 'collaborateurs.edit'
        return view('modifier', compact('collaborateur', 'loggedInUser'));
    }

    /**
     * Met à jour le collaborateur spécifié dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collaborateur  $collaborateur
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Collaborateur $collaborateur)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/accueil')->with('error', 'Accès non autorisé. Vous devez être administrateur.');
        }

        // Validation des données pour la mise à jour
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:collaborateur,email,' . $collaborateur->id_collaborateur . ',id_collaborateur',
            'civilite' => 'nullable|string|max:50',
            'categorie' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'date_de_naissance' => 'nullable|date',
            'ville' => 'nullable|string|max:255',
            'pays' => 'nullable|string|max:255',
            'photo' => 'nullable|url|max:2048', // Validation pour une URL
            // Pour le mot de passe, si vous avez des champs 'mot_de_passe' et 'mot_de_passe_confirmation'
            // dans votre formulaire de modification, vous devez ajouter une validation conditionnelle ici.
            // Par exemple :
            'mot_de_passe' => 'nullable|string|min:8|confirmed',
            'est_admin' => 'boolean', // Si vous permettez de modifier le statut admin
        ]);

        // Gérer le mot de passe si un nouveau est fourni
        if (!empty($validatedData['mot_de_passe'])) {
            $collaborateur->mot_de_passe = $validatedData['mot_de_passe']; // Le cast 'hashed' du modèle s'en chargera
        }
        // Retirer le mot de passe des données validées pour éviter de l'écraser si vide
        unset($validatedData['mot_de_passe']);

        // Gérer le statut admin si le champ est présent dans le formulaire
        $validatedData['est_admin'] = $request->has('est_admin');


        $collaborateur->update($validatedData);

        return redirect()->route('liste')->with('success', 'Collaborateur mis à jour avec succès !');
    }

    public function destroy(Collaborateur $collaborateur)
    {
        // Optionnel mais bonne pratique : vérifier l'autorisation même si le middleware est là
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.'); // Renvoie une erreur 403 si l'utilisateur n'est pas admin
        }

        try {
            $collaborateur->delete(); // Supprime le collaborateur de la base de données
            return redirect()->route('liste')->with('success', 'Collaborateur supprimé avec succès !');
        } catch (\Exception $e) {
            // Gérer les erreurs (par exemple, si la suppression échoue pour une raison quelconque)
            return redirect()->back()->with('error', 'Erreur lors de la suppression du collaborateur : ' . $e->getMessage());
        }
    }
}