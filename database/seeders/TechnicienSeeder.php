<?php

namespace Database\Seeders;

use App\Models\Technicien;
use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TechnicienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $techniciens = [
            [
                'nom' => 'Mensah',
                'prenom' => 'Kofi',
                'email' => 'kofi.mensah@akva-auto.tg',
                'telephone' => '+228 90111111',
                'specialite' => 'Mécanique générale',
            ],
            [
                'nom' => 'Edokpadzi',
                'prenom' => 'Gbedegbe',
                'email' => 'gbedegbe.edokpadzi@akva-auto.tg',
                'telephone' => '+228 90222222',
                'specialite' => 'Électricité automobile',
            ],
            [
                'nom' => 'Agbégabé',
                'prenom' => 'Kossi',
                'email' => 'kossi.agbégabé@akva-auto.tg',
                'telephone' => '+228 90333333',
                'specialite' => 'Carrosserie et peinture',
            ],
        ];

        foreach ($techniciens as $data) {
            $utilisateur = Utilisateur::create([
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'email' => $data['email'],
                'telephone' => $data['telephone'],
                'password' => Hash::make('technicien123'),
                'type_utilisateur' => 'technicien',
                'statut' => 'actif',
            ]);

            Technicien::create([
                'utilisateur_id' => $utilisateur->id,
                'specialite' => $data['specialite'],
                'taux_horaire' => rand(15, 30),
            ]);
        }
    }
}
