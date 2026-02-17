<?php

namespace Database\Seeders;

use App\Models\Conseil;
use Illuminate\Database\Seeder;

class ConseilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conseils = [
            [
                'titre' => 'Révision régulière pour une meilleure longévité',
                'contenu' => 'Une révision régulière de votre véhicule est essentielle pour maintenir ses performances et sa sécurité. Nous recommandons une révision tous les 15 000 km ou tous les 6 mois.',
                'categorie' => 'Entretien',
            ],
            [
                'titre' => 'Comment prendre soin de vos pneus',
                'contenu' => 'Vérifiez régulièrement la pression de vos pneus, l\'usure de la bande de roulement et l\'alignement de vos roues. Des pneus bien entretenus garantissent votre sécurité et une meilleure économie de carburant.',
                'categorie' => 'Sécurité',
            ],
            [
                'titre' => 'L\'importance de la batterie',
                'contenu' => 'La batterie est le cœur de votre véhicule. Assurez-vous qu\'elle est bien chargée et vérifiez ses bornes régulièrement. Une batterie faible peut causer de nombreux problèmes de démarrage.',
                'categorie' => 'Électricité',
            ],
            [
                'titre' => 'Économies de carburant: nos conseils',
                'contenu' => 'Pour économiser du carburant: maintenez une vitesse stable, évitez les accélérations brusques, assurez-vous que la pression des pneus est correcte et maintenez votre véhicule en bon état.',
                'categorie' => 'Consommation',
            ],
            [
                'titre' => 'Climatisation: comment l\'entretenir',
                'contenu' => 'Faites vérifier votre climatisation au moins une fois par an. Un système de climatisation bien entretenu refroidit mieux et consomme moins d\'énergie.',
                'categorie' => 'Climatisation',
            ],
            [
                'titre' => 'Freins: un élément crucial pour la sécurité',
                'contenu' => 'Vérifiez l\'état de vos plaquettes et disques de frein régulièrement. Si vous remarquez une usure anormale ou des bruits, faites réviser votre système de freinage immédiatement.',
                'categorie' => 'Sécurité',
            ],
            [
                'titre' => 'Huile moteur: le cœur du moteur',
                'contenu' => 'Changez votre huile moteur selon le kilométrage recommandé par le fabricant. Une bonne lubrification du moteur est essentielle pour sa longévité.',
                'categorie' => 'Entretien',
            ],
            [
                'titre' => 'Préparation avant un long voyage',
                'contenu' => 'Avant un long trajet: vérifiez les niveaux de fluides, l\'état des pneus, des freins, et assurez-vous que tous les feux fonctionnent correctement.',
                'categorie' => 'Voyages',
            ],
        ];

        foreach ($conseils as $data) {
            Conseil::create([
                'titre' => $data['titre'],
                'contenu' => $data['contenu'],
                'categorie' => $data['categorie'],
                'statut' => 'publie',
            ]);
        }
    }
}
