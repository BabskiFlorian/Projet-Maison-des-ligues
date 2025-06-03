<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('collaborateur', function (Blueprint $table) {
            $table->enum('civilite', ['Homme', 'Femme', 'Autre'])->nullable()->after('mot_de_passe');
            $table->enum('categorie', ['Développement', 'Marketing', 'Vente', 'Ressources Humaines', 'Informatique'])->nullable()->after('civilite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collaborateur', function (Blueprint $table) {
            $table->dropColumn(['civilite', 'categorie']);
        });
    }
};