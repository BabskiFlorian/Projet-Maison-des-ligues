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
        DB::table('collaborateur')
            ->where('civilite', 'Homme')
            ->update(['civilite' => 'Monsieur']);

        DB::table('collaborateur')
            ->where('civilite', 'Femme')
            ->update(['civilite' => 'Madame']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Optionnel: Définir la logique pour revenir en arrière
        // Si vous n'êtes pas sûr, vous pouvez laisser vide ou juste mettre un message d'erreur
        // car inverser cette opération (Madame -> Femme) peut être risqué si de nouvelles données sont entrées.
        // Pour un cas simple comme celui-ci, ce n'est pas toujours nécessaire d'avoir un down() parfait.
        DB::table('collaborateur')
            ->where('civilite', 'Monsieur')
            ->update(['civilite' => 'Homme']);

        DB::table('collaborateur')
            ->where('civilite', 'Madame')
            ->update(['civilite' => 'Femme']);
    }
};