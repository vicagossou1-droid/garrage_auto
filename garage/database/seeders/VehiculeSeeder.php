<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Vehicule;
use Illuminate\Database\Seeder;

class VehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();

        $vehicules = [
            ['marque' => 'Toyota', 'modele' => 'Corolla', 'plaque_immatriculation' => 'TG-001-AA', 'energie' => 'Essence', 'annee' => 2020],
            ['marque' => 'Honda', 'modele' => 'Civic', 'plaque_immatriculation' => 'TG-002-AA', 'energie' => 'Essence', 'annee' => 2021],
            ['marque' => 'Peugeot', 'modele' => '308', 'plaque_immatriculation' => 'TG-003-AA', 'energie' => 'Diesel', 'annee' => 2019],
            ['marque' => 'Renault', 'modele' => 'Clio', 'plaque_immatriculation' => 'TG-004-AA', 'energie' => 'Essence', 'annee' => 2022],
            ['marque' => 'Hyundai', 'modele' => 'i20', 'plaque_immatriculation' => 'TG-005-AA', 'energie' => 'Essence', 'annee' => 2020],
            ['marque' => 'Mercedes', 'modele' => 'C-Class', 'plaque_immatriculation' => 'TG-006-AA', 'energie' => 'Diesel', 'annee' => 2021],
            ['marque' => 'BMW', 'modele' => '320i', 'plaque_immatriculation' => 'TG-007-AA', 'energie' => 'Essence', 'annee' => 2020],
            ['marque' => 'Toyota', 'modele' => 'Yaris', 'plaque_immatriculation' => 'TG-008-AA', 'energie' => 'Essence', 'annee' => 2019],
        ];

        foreach ($vehicules as $index => $data) {
            $client = $clients[$index % count($clients)];

            Vehicule::create([
                'client_id' => $client->id,
                'marque' => $data['marque'],
                'modele' => $data['modele'],
                'plaque_immatriculation' => $data['plaque_immatriculation'],
                'energie' => $data['energie'],
                'annee' => $data['annee'],
                'kilometrage' => rand(10000, 150000),
                'couleur' => ['Rouge', 'Bleu', 'Noir', 'Blanc', 'Gris', 'Argent'][rand(0, 5)],
                'numero_chassis' => 'VIN-' . strtoupper(substr(uniqid(), -10)),
            ]);
        }
    }
}
