<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Supprimer les anciennes tables si elles existent
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('messages_contact');
        Schema::dropIfExists('conseils');
        Schema::dropIfExists('avis_clients');
        Schema::dropIfExists('recus');
        Schema::dropIfExists('devis');
        Schema::dropIfExists('interventions_technicien');
        Schema::dropIfExists('reparations');
        Schema::dropIfExists('vehicules');
        Schema::dropIfExists('techniciens');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('utilisateurs');
        Schema::dropIfExists('users');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('telephone')->nullable();
            $table->string('password');
            $table->enum('type_utilisateur', ['client', 'technicien', 'admin'])->default('client');
            $table->enum('statut', ['actif', 'inactif', 'suspendu'])->default('actif');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->string('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('numero_client')->unique()->nullable();
            $table->timestamp('date_inscription')->useCurrent();
            $table->timestamps();
        });

        Schema::create('techniciens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->string('specialite')->nullable();
            $table->decimal('taux_horaire', 8, 2)->default(0);
            $table->text('competences')->nullable();
            $table->enum('statut', ['disponible', 'occupe', 'conge'])->default('disponible');
            $table->timestamps();
        });

        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('marque');
            $table->string('modele');
            $table->string('plaque_immatriculation')->unique();
            $table->string('couleur')->nullable();
            $table->integer('annee')->nullable();
            $table->integer('kilometrage')->default(0);
            $table->string('type_carrosserie')->nullable();
            $table->enum('energie', ['Essence', 'Diesel', 'Hybride', 'Électrique', 'Autre'])->default('Essence');
            $table->string('numero_chassis')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('reparations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicule_id')->constrained('vehicules')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->timestamp('date_depot')->useCurrent();
            $table->timestamp('date_fin_prevue')->nullable();
            $table->timestamp('date_fin_reelle')->nullable();
            $table->text('description_panne');
            $table->enum('statut', ['en_attente', 'en_cours', 'termine', 'livree', 'annulee'])->default('en_attente');
            $table->decimal('estimation_cout', 10, 2)->nullable();
            $table->decimal('cout_final', 10, 2)->nullable();
            $table->text('notes_admin')->nullable();
            $table->timestamps();
        });

        Schema::create('interventions_technicien', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reparation_id')->constrained('reparations')->onDelete('cascade');
            $table->foreignId('technicien_id')->constrained('techniciens')->onDelete('cascade');
            $table->timestamp('date_debut')->nullable();
            $table->timestamp('date_fin')->nullable();
            $table->integer('duree_minutes')->default(0);
            $table->text('commentaires')->nullable();
            $table->decimal('cout_intervention', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reparation_id')->constrained('reparations')->onDelete('cascade');
            $table->text('description_travaux');
            $table->decimal('montant_total', 10, 2);
            $table->timestamp('date_emission')->useCurrent();
            $table->integer('validite_jours')->default(15);
            $table->enum('statut', ['brouillon', 'envoye', 'accepte', 'refuse', 'depasse'])->default('brouillon');
            $table->timestamp('date_acceptation')->nullable();
            $table->timestamps();
        });

        Schema::create('recus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reparation_id')->constrained('reparations')->onDelete('cascade');
            $table->string('numero_recu')->unique();
            $table->decimal('montant_total', 10, 2);
            $table->enum('methode_paiement', ['especes', 'cheque', 'carte', 'virement', 'mobile_money'])->nullable();
            $table->text('details')->nullable();
            $table->timestamp('date_paiement')->useCurrent();
            $table->timestamps();
        });

        Schema::create('avis_clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('reparation_id')->constrained('reparations')->onDelete('cascade');
            $table->integer('note')->min(1)->max(5);
            $table->text('commentaire')->nullable();
            $table->timestamp('date_avis')->useCurrent();
            $table->timestamps();
        });

        Schema::create('conseils', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('contenu');
            $table->string('categorie');
            $table->string('image')->nullable();
            $table->enum('statut', ['brouillon', 'publie'])->default('publie');
            $table->timestamps();
        });

        Schema::create('messages_contact', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email');
            $table->string('telephone')->nullable();
            $table->string('sujet');
            $table->text('message');
            $table->enum('statut', ['non_lu', 'lu', 'repondu'])->default('non_lu');
            $table->timestamp('date_message')->useCurrent();
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->string('titre');
            $table->text('message');
            $table->string('type')->default('info');
            $table->unsignedBigInteger('reparation_id')->nullable();
            $table->foreign('reparation_id')->references('id')->on('reparations')->onDelete('set null');
            $table->timestamp('date_lecture')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('messages_contact');
        Schema::dropIfExists('conseils');
        Schema::dropIfExists('avis_clients');
        Schema::dropIfExists('recus');
        Schema::dropIfExists('devis');
        Schema::dropIfExists('interventions_technicien');
        Schema::dropIfExists('reparations');
        Schema::dropIfExists('vehicules');
        Schema::dropIfExists('techniciens');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('utilisateurs');
    }
};
