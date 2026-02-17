<?php

namespace App\Services;

class ExportService
{
    /**
     * Exporte les réparations en CSV
     */
    public static function exportReparationsCSV($reparations)
    {
        $csv = "Immatriculation,Marque,Modèle,Client,Technicien,Date Depot,Description,Statut\n";

        foreach ($reparations as $reparation) {
            $techniciens = $reparation->interventions->map(function ($intervention) {
                return $intervention->technicien->utilisateur->nom_complet ?? 'Non assigné';
            })->join(', ') ?: 'Non assigné';

            $csv .= '"' . $reparation->vehicule->plaque_immatriculation . '",' .
                '"' . $reparation->vehicule->marque . '",' .
                '"' . $reparation->vehicule->modele . '",' .
                '"' . $reparation->client->utilisateur->nom_complet . '",' .
                '"' . $techniciens . '",' .
                $reparation->date_depot->format('d/m/Y') . ',' .
                '"' . str_replace('"', '""', $reparation->description_panne) . '",' .
                $reparation->statut . "\n";
        }

        return $csv;
    }

    /**
     * Exporte les véhicules en CSV
     */
    public static function exportVehiculesCSV($vehicules)
    {
        $csv = "Immatriculation,Marque,Modèle,Client,Couleur,Année,Kilométrage,Carrosserie,Énergie\n";

        foreach ($vehicules as $vehicule) {
            $csv .= '"' . $vehicule->plaque_immatriculation . '",' .
                '"' . $vehicule->marque . '",' .
                '"' . $vehicule->modele . '",' .
                '"' . $vehicule->client->utilisateur->nom_complet . '",' .
                '"' . $vehicule->couleur . '",' .
                $vehicule->annee . ',' .
                $vehicule->kilometrage . ',' .
                '"' . $vehicule->type_carrosserie . '",' .
                '"' . $vehicule->energie . '"' . "\n";
        }

        return $csv;
    }

    /**
     * Exporte les techniciens en CSV
     */
    public static function exportTechnicienCSV($techniciens)
    {
        $csv = "Nom,Prénom,Spécialité,Nombre d'interventions\n";

        foreach ($techniciens as $technicien) {
            $csv .= '"' . $technicien->utilisateur->nom . '",' .
                '"' . $technicien->utilisateur->prenom . '",' .
                '"' . $technicien->specialite . '",' .
                ($technicien->interventions_count ?? $technicien->interventions()->count()) . "\n";
        }

        return $csv;
    }
}
