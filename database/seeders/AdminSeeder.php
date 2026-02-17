<?php

namespace Database\Seeders;

use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Utilisateur::create([
            'nom' => 'Admin',
            'prenom' => 'AKVA',
            'email' => 'admin@akva-auto.tg',
            'telephone' => '+228 90000000',
            'password' => Hash::make('admin123'),
            'type_utilisateur' => 'admin',
            'statut' => 'actif',
        ]);
    }
}
