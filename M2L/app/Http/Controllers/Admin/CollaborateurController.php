<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collaborateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use League\Csv\Reader; // csv
use Illuminate\Support\Facades\Validator; // csv

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

     /**
     * Importe des collaborateurs à partir d'un fichier CSV.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importCsv(Request $request)
    {
        // 1. Validation du fichier uploadé
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048', // max 2MB
        ], [
            'csv_file.required' => 'Veuillez sélectionner un fichier CSV.',
            'csv_file.mimes' => 'Le fichier doit être au format CSV (extensions .csv ou .txt).',
            'csv_file.max' => 'La taille du fichier CSV ne doit pas dépasser 2 Mo.',
        ]);

        $file = $request->file('csv_file');

        // 2. Traitement du fichier CSV
        try {
            // Créer un lecteur CSV à partir du chemin temporaire du fichier uploadé
            $csv = Reader::createFromPath($file->getPathname(), 'r');
            $csv->setHeaderOffset(0); // Suppose que la première ligne du CSV contient les en-têtes (noms de colonnes)

            $records = $csv->getRecords(); // Récupère tous les enregistrements après l'en-tête
            $importedCount = 0;
            $errors = []; // Pour stocker les erreurs par ligne

            foreach ($records as $offset => $record) {
                // IMPORTANT : Adaptez les clés du tableau $record aux noms de colonnes de votre CSV.
                // Par exemple, si votre CSV a une colonne nommée "Nom", utilisez $record['Nom'].
                // Si votre CSV utilise des noms différents, ajustez-les ici.
                $data = [
                    'civilite' => $record['civilite'] ?? null,
                    'categorie' => $record['categorie'] ?? null,
                    'nom' => $record['nom'] ?? null,
                    'prenom' => $record['prenom'] ?? null,
                    'email' => $record['email'] ?? null,
                    'mot_de_passe' => $record['mot_de_passe'] ?? null, // Le mot de passe DOIT être présent dans le CSV
                    'telephone' => $record['telephone'] ?? null,
                    'date_de_naissance' => $record['date_de_naissance'] ?? null, // Format attendu : YYYY-MM-DD
                    'ville' => $record['ville'] ?? null,
                    'pays' => $record['pays'] ?? null,
                    'photo' => $record['photo'] ?? null, // Doit être une URL valide
                ];

                // Valider chaque ligne du CSV avant d'insérer
                $validator = Validator::make($data, [
                    'nom' => 'required|string|max:255',
                    'prenom' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:collaborateur,email', // 'unique:table,colonne' est crucial ici pour éviter les doublons
                    'mot_de_passe' => 'required|string|min:8', // Le mot de passe est obligatoire pour les nouvelles créations
                    'civilite' => 'nullable|string|in:Monsieur,Madame,Autre',
                    'categorie' => 'nullable|string|max:255',
                    'telephone' => 'nullable|string|max:20',
                    'date_de_naissance' => 'nullable|date_format:Y-m-d', // Assurez-vous que le format correspond
                    'ville' => 'nullable|string|max:255',
                    'pays' => 'nullable|string|max:255',
                    'photo' => 'nullable|url|max:2048', // Validation pour une URL de photo
                ]);

                if ($validator->fails()) {
                    // Les messages d'erreur sont collectés pour être affichés à l'utilisateur
                    $errors[] = "Ligne " . ($offset + 2) . " (email: " . ($data['email'] ?? 'N/A') . ") : " . implode(', ', $validator->errors()->all());
                    continue; // Passe à la ligne suivante si la validation échoue
                }

                try {
                    // Création du collaborateur si la validation passe
                    Collaborateur::create([
                        'civilite' => $data['civilite'],
                        'categorie' => $data['categorie'],
                        'nom' => $data['nom'],
                        'prenom' => $data['prenom'],
                        'email' => $data['email'],
                        'mot_de_passe' => Hash::make($data['mot_de_passe']), // Hacher le mot de passe est INDISPENSABLE pour la sécurité
                        'telephone' => $data['telephone'],
                        'date_de_naissance' => $data['date_de_naissance'],
                        'ville' => $data['ville'],
                        'pays' => $data['pays'],
                        'photo' => $data['photo'],
                    ]);
                    $importedCount++;
                } catch (\Exception $e) {
                    // Erreur lors de l'insertion en base de données
                    $errors[] = "Erreur SQL à la ligne " . ($offset + 2) . " (email: " . ($data['email'] ?? 'N/A') . ") : " . $e->getMessage();
                }
            }

            // Redirection avec un message de succès ou d'erreur global
            if (empty($errors)) {
                return redirect()->back()->with('success', "$importedCount collaborateurs importés avec succès !");
            } else {
                // Utilisez implode('<br>', $errors) pour que chaque erreur s'affiche sur une nouvelle ligne dans l'alerte
                return redirect()->back()->with('error', "Importation terminée avec des erreurs. $importedCount collaborateurs importés. Détails des erreurs :<br>" . implode('<br>', $errors));
            }

        } catch (\Exception $e) {
            // Erreur générale lors du traitement du fichier (par exemple, fichier non lisible)
            return redirect()->back()->with('error', 'Une erreur est survenue lors du traitement du fichier CSV : ' . $e->getMessage());
        }
    }
}