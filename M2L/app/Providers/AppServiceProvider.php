<?php

namespace App\Providers;

use App\View\Composers\UserProfileComposer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router; // <-- N'oubliez pas d'importer la classe Router !
use App\Http\Middleware\AdminMiddleware; // <-- N'oubliez pas d'importer votre middleware !

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @param  \Illuminate\Routing\Router  $router // <-- Injectez le Router ici
     * @return void
     */
    public function boot(Router $router) // <-- Injectez le Router dans la méthode boot
    {
        DB::listen(function ($query) {
            Log::info("SQL Query: " . $query->sql);
            Log::info("SQL Bindings: " . json_encode($query->bindings));
            Log::info("SQL Time: " . $query->time);
        });

        // Ajoutez cette ligne pour enregistrer votre View Composer pour toutes les vues
        View::composer('*', UserProfileComposer::class);

        // Enregistrez votre middleware 'admin' ici
        // Cela va créer l'alias 'admin' que vous pourrez utiliser dans routes/web.php
        $router->aliasMiddleware('admin', AdminMiddleware::class); // <-- AJOUTEZ CETTE LIGNE

        // Ou pour des vues spécifiques :
        // View::composer(['accueil', 'profil', 'liste', 'layouts.app'], UserProfileComposer::class);
    }
}