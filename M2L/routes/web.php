<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RandomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CollaborateurController; // Pour les routes d'administration des collaborateurs


// Route racine qui affiche le formulaire de connexion
Route::get('/', function () {
    return view('auth.login');
})->name('root');

// Routes pour la gestion de l'authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Groupe de routes nécessitant une authentification
Route::middleware(['auth'])->group(function () {

    // Route d'accueil après connexion
    Route::get('/accueil', [RandomController::class, 'index'])->name('accueil');

    // Routes du profil utilisateur (édition et mise à jour)
    Route::get('/profil', [ProfileController::class, 'editProfile'])->name('collaborateur.edit_profile');
    Route::put('/profil', [ProfileController::class, 'updateProfile'])->name('collaborateur.update_profile');

    // Route de la liste des collaborateurs
    // Note: C'est la route qui affichera le bouton "Modifier" pour les admins
    Route::get('/liste', [ListController::class, 'index'])->name('liste');

    // Route de déconnexion
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');

    // Groupe de routes nécessitant le middleware 'admin'
    Route::middleware(['admin'])->group(function () {
        // Route pour afficher le formulaire de création d'un nouveau collaborateur
        Route::get('/create', [CollaborateurController::class, 'create'])->name('collaborateur.create');
        // Route pour sauvegarder le nouveau collaborateur après soumission du formulaire
        Route::post('/collaborateurs', [CollaborateurController::class, 'store'])->name('collaborateur.store');

        // LES NOUVELLES ROUTES POUR LA MODIFICATION :
        // Route pour afficher le formulaire de modification d'un collaborateur spécifique
        // Utilise {collaborateur} pour l'injection de modèle. Laravel trouvera le collaborateur par 'id_collaborateur' car c'est votre primaryKey.
        Route::get('/collaborateurs/{collaborateur}/edit', [CollaborateurController::class, 'edit'])->name('collaborateur.edit');
        // Route pour traiter la soumission du formulaire de modification (mise à jour)
        // Utilise la méthode PUT pour les mises à jour RESTful.
        Route::put('/collaborateurs/{collaborateur}', [CollaborateurController::class, 'update'])->name('collaborateur.update');

        // Route pour la suppression
        Route::delete('/collaborateur/{collaborateur}', [CollaborateurController::class, 'destroy'])
            ->name('collaborateur.destroy')
            ->middleware('auth', 'admin'); // Ce middleware 'auth', 'admin' est déjà appliqué par le groupe.

        // --- AJOUTEZ CETTE LIGNE ICI POUR LA ROUTE D'IMPORTATION CSV ---
        Route::post('/collaborateurs/import-csv', [CollaborateurController::class, 'importCsv'])->name('collaborateurs.import_csv');
        // -----------------------------------------------------------
    });

});