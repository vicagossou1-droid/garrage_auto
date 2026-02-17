<?php

namespace Database\Seeders;

use App\Models\Reparation;
use App\Models\Vehicule;
use App\Models\Technicien;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReparationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicules = Vehicule::all();
        $techniciens = Technicien::all();

        $descriptions = [
            'Révision complète (vidange, filtres)',
            'Remplacement des plaquettes de frein',
            'Remplacement des pneus',
            'Réparation climatisation',
            'Changement courroie de distribution',
            'Diagnostic moteur',
            'Réparation électrique',
            'Entretien général',
            'Changement batterie',
            'Remplacement amortisseurs',
        ];

        $statuts = ['en_attente', 'en_cours', 'termine', 'livree'];

        foreach ($vehicules as $vehicule) {
            for ($i = 0; $i < rand(1, 3); $i++) {
                $statut = $statuts[rand(0, count($statuts) - 1)];
                $dateDebut = now()->subDays(rand(1, 60));
                $dateFin = ($statut === 'termine' || $statut === 'livree') ? $dateDebut->copy()->addDays(rand(1, 15)) : null;

                $reparation = Reparation::create([
                    'vehicule_id' => $vehicule->id,
                    'client_id' => $vehicule->client_id,
                    'description_panne' => $descriptions[rand(0, count($descriptions) - 1)],
                    'statut' => $statut,
                    'date_depot' => $dateDebut,
                    'date_fin_prevue' => $dateDebut->copy()->addDays(5),
                    'date_fin_reelle' => $dateFin,
                    'estimation_cout' => rand(1000, 2000000),
                    'cout_final' => ($statut === 'termine' || $statut === 'livree') ? rand(1000, 2000000) : null,
                    'notes_admin' => 'Test',
                ]);

                // Assigner un technicien si la réparation est en cours ou terminée
                if (($statut === 'en_cours' || $statut === 'termine' || $statut === 'livree') && count($techniciens) > 0) {
                    $reparation->interventions()->create([
                        'technicien_id' => $techniciens[rand(0, count($techniciens) - 1)]->id,
                        'date_debut' => $dateDebut,
                        'date_fin' => $dateFin,
                        'duree_minutes' => rand(120, 2400),
                    ]);
                }
            }
        }
    }
}
