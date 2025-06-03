<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // N'oubliez pas d'importer DB

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Étape 1: Ajouter les nouvelles valeurs à l'ENUM existant
        // Nous allons d'abord ajouter 'Monsieur' et 'Madame' aux valeurs autorisées
        // pour éviter le "Data truncated" lorsque nous ferons la mise à jour des données.
        DB::statement("ALTER TABLE collaborateur CHANGE COLUMN civilite civilite ENUM('Homme', 'Femme', 'Autre', 'Monsieur', 'Madame') NULL DEFAULT NULL;");

        // Étape 2: Mettre à jour les données existantes
        // Maintenant que 'Monsieur' et 'Madame' sont des options valides,
        // vous pouvez convertir les anciennes valeurs.
        DB::table('collaborateur')
            ->where('civilite', 'Homme')
            ->update(['civilite' => 'Monsieur']);

        DB::table('collaborateur')
            ->where('civilite', 'Femme')
            ->update(['civilite' => 'Madame']);

        // Étape 3 (Optionnel mais recommandé): Retirer les anciennes valeurs de l'ENUM
        // Une fois que toutes les données sont converties, vous pouvez nettoyer l'ENUM
        // pour n'avoir que les valeurs finales désirées.
        // ATTENTION: N'exécutez cette étape que si vous êtes certain
        // que toutes les données 'Homme' et 'Femme' ont été converties.
        DB::statement("ALTER TABLE collaborateur CHANGE COLUMN civilite civilite ENUM('Monsieur', 'Madame', 'Autre') NULL DEFAULT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Logique pour revenir en arrière
        // ATTENTION: Cela peut être risqué si de nouvelles données ont été ajoutées
        // avec 'Monsieur' ou 'Madame'.
        DB::table('collaborateur')
            ->where('civilite', 'Monsieur')
            ->update(['civilite' => 'Homme']);

        DB::table('collaborateur')
            ->where('civilite', 'Madame')
            ->update(['civilite' => 'Femme']);

        // Revenir à l'ENUM original
        DB::statement("ALTER TABLE collaborateur CHANGE COLUMN civilite civilite ENUM('Homme', 'Femme', 'Autre') NULL DEFAULT NULL;");
    }
};