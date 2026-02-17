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
        // La table interventions_technicien existe déjà
        // On ajoute juste une colonne pour tracker l'affectation
        if (Schema::hasTable('interventions_technicien') && !Schema::hasColumn('interventions_technicien', 'statut_affectation')) {
            Schema::table('interventions_technicien', function (Blueprint $table) {
                $table->enum('statut_affectation', ['non_assigne', 'assigne', 'en_cours', 'termine'])->default('non_assigne')->after('date_debut');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('interventions_technicien') && Schema::hasColumn('interventions_technicien', 'statut_affectation')) {
            Schema::table('interventions_technicien', function (Blueprint $table) {
                $table->dropColumn('statut_affectation');
            });
        }
    }
};
