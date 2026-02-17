<?php

namespace App\Http\Controllers\Admin;

use App\Models\Utilisateur;
use App\Models\Client;
use App\Models\Technicien;
use App\Models\Reparation;
use App\Models\Vehicule;
use App\Models\InterventionTechnicien;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $statistiques = [
            'clients_total' => Client::count(),
            'techniciens_total' => Technicien::count(),
            'reparations_total' => Reparation::count(),
            'reparations_en_cours' => Reparation::where('statut', 'en_cours')->count(),
            'reparations_en_attente' => Reparation::where('statut', 'en_attente')->count(),
            'vehicules_total' => Vehicule::count(),
        ];

        // Réparations par mois (derniers 6 mois)
        $reparations_par_mois = [];
        $mois_array = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $mois_array[] = [
                'label' => $date->format('M Y'),
                'count' => Reparation::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            ];
        }

        // Créer un tableau ordonné avec labels et données alignés
        foreach ($mois_array as $mois) {
            $reparations_par_mois[$mois['label']] = $mois['count'];
        }

        // Réparations par technicien
        $reparations_par_technicien = InterventionTechnicien::with('technicien.utilisateur')
            ->selectRaw('technicien_id, COUNT(*) as count')
            ->groupBy('technicien_id')
            ->get()
            ->mapWithKeys(fn($item) => [
                $item->technicien->utilisateur->nom_complet => $item->count
            ]);

        // Statistiques ce mois
        $debut_mois = now()->startOfMonth();
        $fin_mois = now()->endOfMonth();
        $reparations_mois = Reparation::whereBetween('created_at', [$debut_mois, $fin_mois])->get();

        // Durée totale des réparations ce mois (en minutes)
        $duree_totale = $reparations_mois->sum(function ($r) {
            if ($r->date_depot && $r->date_fin_prevue) {
                return $r->date_depot->diffInMinutes($r->date_fin_prevue);
            }
            return 0;
        });

        // Moyenne par réparation
        $moyenne_par_reparation = $reparations_mois->count() > 0
            ? intdiv($duree_totale, $reparations_mois->count())
            : 0;

        // Technicien avec le plus d'interventions
        $technicien_top = InterventionTechnicien::with('technicien.utilisateur')
            ->selectRaw('technicien_id, COUNT(*) as count')
            ->groupBy('technicien_id')
            ->orderByRaw('COUNT(*) DESC')
            ->first();

        // Véhicule le plus réparé
        $vehicule_frequent = Reparation::with('vehicule')
            ->selectRaw('vehicule_id, COUNT(*) as count')
            ->groupBy('vehicule_id')
            ->orderByRaw('COUNT(*) DESC')
            ->first();

        $reparations_recentes = Reparation::with('client', 'vehicule')
            ->orderByRaw("CASE 
                WHEN statut = 'en_attente' THEN 1
                WHEN statut = 'en_cours' THEN 2
                WHEN statut = 'termine' THEN 3
                WHEN statut = 'livre' THEN 4
                ELSE 5
            END")
            ->orderBy('date_depot', 'desc')
            ->take(10)
            ->get();

        $clients = Client::with('utilisateur')->paginate(15);
        $techniciens = Technicien::with('utilisateur')->paginate(15);

        return view('admin.dashboard', compact(
            'statistiques',
            'reparations_recentes',
            'clients',
            'techniciens',
            'reparations_par_mois',
            'reparations_par_technicien',
            'duree_totale',
            'moyenne_par_reparation',
            'technicien_top',
            'vehicule_frequent'
        ));
    }
}
