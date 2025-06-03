<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function editProfile()
    {
        $collaborateur = Auth::user();
        return view('profil', compact('collaborateur'));
    }

    public function updateProfile(Request $request)
    {
        $collaborateur = Auth::user();

        $rules = [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('collaborateur', 'email')->ignore($collaborateur->id_collaborateur, 'id_collaborateur'),
            ],
            'civilite' => ['nullable', 'string', 'max:50'],
            'categorie' => ['nullable', 'string', 'max:255'],
            // MODIFICATION ICI : Règle de validation pour le téléphone
            'telephone' => ['nullable', 'string', 'max:20', 'regex:/^\+?[0-9\s\-().]{7,20}$/'],
            // Explication de la regex :
            // ^              : Début de la chaîne
            // \+?            : Optionnellement un signe '+' au début (pour les indicatifs internationaux)
            // [0-9\s\-().]+  : Un ou plusieurs chiffres, espaces, tirets, parenthèses ou points
            // {7,20}         : La longueur totale (chiffres + séparateurs) doit être entre 7 et 20 caractères
            //                  (ajustez cette plage si nécessaire pour vos formats)
            // $              : Fin de la chaîne
            // Pour n'autoriser QUE des chiffres (aucun espace/tiret/parenthèse): 'regex:/^[0-9]{7,20}$/'
            // Pour n'autoriser QUE des chiffres et un '+' initial : 'regex:/^\+?[0-9]{7,20}$/'
            // Pour n'autoriser que des chiffres, des espaces et des tirets : 'regex:/^[0-9\s\-]{7,20}$/'
            // Choisissez la regex qui correspond le mieux aux formats de téléphone que vous acceptez.


            'date_de_naissance' => ['nullable', 'date'],
            'ville' => ['nullable', 'string', 'max:255'],
            'pays' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'url', 'max:2048'],
            'mot_de_passe' => ['nullable', 'string', 'min:8', 'confirmed'],
            'current_password' => ['nullable', 'string'],
        ];

        if ($request->filled('mot_de_passe')) {
            $rules['current_password'] = ['required', 'string'];
        }

        $validatedData = $request->validate($rules);

        // ... Le reste du contrôleur (gestion mot de passe, photo, save) reste identique ...

        // Traitement du mot de passe
        if (!empty($validatedData['mot_de_passe'])) {
            if (!Hash::check($validatedData['current_password'], $collaborateur->mot_de_passe)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.'])->withInput();
            }
            $collaborateur->mot_de_passe = $validatedData['mot_de_passe'];
        }
        unset($validatedData['mot_de_passe']);
        unset($validatedData['mot_de_passe_confirmation']);
        unset($validatedData['current_password']);

        // Mettre à jour les autres informations du collaborateur
        $collaborateur->fill($validatedData);

        $collaborateur->save();

        return redirect()->route('collaborateur.edit_profile')->with('success', 'Votre profil a été mis à jour avec succès !');
    }
}