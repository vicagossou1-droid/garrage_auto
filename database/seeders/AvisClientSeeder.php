<?php

namespace Database\Seeders;

use App\Models\AvisClient;
use App\Models\Reparation;
use Illuminate\Database\Seeder;

class AvisClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reparations = Reparation::where('statut', '!=', 'en_attente')->get();

        $commentaires = [
            'Excellent service, très professionnel!',
            'Très satisfait de la réparation, à bientôt.',
            'Service rapide et efficace.',
            'Bon accueil et travail de qualité.',
            'Recommande vivement AKVA-Auto.',
            'Travail impeccable, merci!',
            'Service client au top, à recommander.',
            'Réparation bien faite, prix raisonnable.',
            'Très content du résultat.',
            'Techniciens compétents et aimables.',
        ];

        foreach ($reparations as $reparation) {
            if (rand(0, 1)) {
                AvisClient::create([
                    'client_id' => $reparation->client_id,
                    'reparation_id' => $reparation->id,
                    'note' => rand(4, 5),
                    'commentaire' => $commentaires[rand(0, count($commentaires) - 1)],
                    'date_avis' => now()->subDays(rand(1, 90)),
                ]);
            }
        }
    }
}
