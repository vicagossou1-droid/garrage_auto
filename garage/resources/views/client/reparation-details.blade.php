@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
            <h2 class="fw-bold">
                <i class="bi bi-wrench-adjustable"></i> Détails Réparation
            </h2>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Details -->
        <div class="col-lg-8">
            <!-- Vehicle Information -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-car-front"></i> Véhicule</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Marque & Modèle :</strong> {{ $reparation->vehicule->marque }} {{ $reparation->vehicule->modele }}</p>
                            <p><strong>Année :</strong> {{ $reparation->vehicule->annee }}</p>
                            <p><strong>Couleur :</strong> {{ $reparation->vehicule->couleur }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Plaque :</strong> {{ $reparation->vehicule->plaque_immatriculation }}</p>
                            <p><strong>Kilométrage :</strong> {{ number_format($reparation->vehicule->kilometrage, 0) }} km</p>
                            <p><strong>Énergie :</strong> {{ $reparation->vehicule->energie }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Repair Details -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-wrench"></i> Détails de la Réparation</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Statut :</strong></p>
                            <span class="badge bg-{{ $reparation->statut === 'en_cours' ? 'warning' : ($reparation->statut === 'termine' ? 'success' : ($reparation->statut === 'livre' ? 'info' : 'secondary')) }} fs-6">
                                {{ ucfirst(str_replace('_', ' ', $reparation->statut)) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date Dépôt :</strong> {{ $reparation->date_depot->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <p><strong>Description de la Panne :</strong></p>
                    <p class="text-muted">{{ $reparation->description_panne }}</p>
                </div>
            </div>

            <!-- Interventions -->
            @if ($reparation->interventions && count($reparation->interventions) > 0)
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-person-check"></i> Interventions des Techniciens</h5>
                </div>
                <div class="card-body">
                    @foreach ($reparation->interventions as $intervention)
                    <div class="border-bottom pb-3 mb-3">
                        <p><strong>Technicien :</strong> {{ $intervention->technicien->utilisateur->nom_complet }}</p>
                        <p><strong>Spécialité :</strong> {{ $intervention->technicien->utilisateur->specialite }}</p>
                        <p><strong>Description :</strong> {{ $intervention->description ?? 'Aucune description' }}</p>
                        <p><strong>Durée :</strong> {{ $intervention->duree_heures ?? '-' }} heure(s)</p>
                        <p><strong>Statut :</strong>
                            <span class="badge bg-{{ $intervention->statut === 'en_cours' ? 'warning' : ($intervention->statut === 'terminee' ? 'success' : 'secondary') }}">
                                {{ ucfirst(str_replace('_', ' ', $intervention->statut)) }}
                            </span>
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4">
            <!-- Cost Summary -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-cash-coin"></i> Coûts</h5>
                </div>
                <div class="card-body">
                    @if ($reparation->devis)
                    <p><strong>Montant Estimé :</strong> <span class="text-success fs-5">{{ number_format($reparation->devis->montant_estime, 2, '.', ' ') }} XOF</span></p>
                    @endif
                    @if ($reparation->cout_final)
                    <p><strong>Coût Final :</strong> <span class="text-danger fs-5">{{ number_format($reparation->cout_final, 2, '.', ' ') }} XOF</span></p>
                    @else
                    <p class="text-muted">Coût final à déterminer</p>
                    @endif
                </div>
            </div>

            <!-- Receipt -->
            @if ($reparation->recu)
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-receipt"></i> Reçu</h5>
                </div>
                <div class="card-body">
                    <p><strong>Numéro :</strong> {{ $reparation->recu->numero_recu }}</p>
                    <p><strong>Montant :</strong> {{ number_format($reparation->recu->montant, 2, '.', ' ') }} XOF</p>
                    <p><strong>Date :</strong> {{ $reparation->recu->date_emission->format('d/m/Y') }}</p>
                    @if ($reparation->recu->fichier)
                    <a href="{{ asset('storage/' . $reparation->recu->fichier) }}" class="btn btn-sm btn-primary w-100" download>
                        <i class="bi bi-download"></i> Télécharger Reçu
                    </a>
                    @endif
                </div>
            </div>
            @endif

            <!-- Status Timeline -->
            <div class="card shadow-lg">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="bi bi-timeline"></i> Historique</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <p class="small"><strong>Création :</strong> {{ $reparation->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <p class="small"><strong>Statut actuel :</strong> {{ ucfirst(str_replace('_', ' ', $reparation->statut)) }}</p>
                        </div>
                        @if ($reparation->updated_at->ne($reparation->created_at))
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <p class="small"><strong>Mise à jour :</strong> {{ $reparation->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        padding: 0;
        list-style: none;
    }

    .timeline-item {
        padding-left: 30px;
        position: relative;
        margin-bottom: 15px;
    }

    .timeline-marker {
        position: absolute;
        left: 0;
        top: 5px;
        width: 12px;
        height: 12px;
        background-color: #0d6efd;
        border-radius: 50%;
        border: 2px solid white;
    }

    .timeline-item p {
        margin: 0;
    }
</style>
@endsection