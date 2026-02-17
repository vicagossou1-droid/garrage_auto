<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Boot the authentication / authorization services.
     */
    public function boot(): void
    {
        // Configuration de l'authentification avec le modèle Utilisateur
    }
}
