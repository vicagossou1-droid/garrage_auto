<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'nom' => 'Koffi',
                'prenom' => 'Jean',
                'email' => 'jean.koffi@email.tg',
                'telephone' => '+228 90123456',
                'adresse' => 'Avenue de France, Lomé',
            ],
            [
                'nom' => 'Mensah',
                'prenom' => 'Marie',
                'email' => 'marie.mensah@email.tg',
                'telephone' => '+228 90234567',
                'adresse' => 'Boulevard de la Paix, Lomé',
            ],
            [
                'nom' => 'Agbo',
                'prenom' => 'Pierre',
                'email' => 'pierre.agbo@email.tg',
                'telephone' => '+228 90345678',
                'adresse' => 'Rue du Marché, Lomé',
            ],
            [
                'nom' => 'Nossow',
                'prenom' => 'Yvette',
                'email' => 'yvette.nossow@email.tg',
                'telephone' => '+228 90456789',
                'adresse' => 'Avenue de Coolona, Lomé',
            ],
            [
                'nom' => 'Kodjo',
                'prenom' => 'André',
                'email' => 'andre.kodjo@email.tg',
                'telephone' => '+228 90567890',
                'adresse' => 'Rue de la Gare, Lomé',
            ],
        ];

        foreach ($clients as $data) {
            $utilisateur = Utilisateur::create([
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'email' => $data['email'],
                'telephone' => $data['telephone'],
                'password' => Hash::make('client123'),
                'type_utilisateur' => 'client',
                'statut' => 'actif',
            ]);

            Client::create([
                'utilisateur_id' => $utilisateur->id,
                'adresse' => $data['adresse'],
                'ville' => 'Lomé',
                'code_postal' => '00228',
            ]);
        }
    }
}
