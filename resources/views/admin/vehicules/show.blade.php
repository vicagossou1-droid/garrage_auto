@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold"><i class="bi bi-car-front"></i> Détail Véhicule</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.vehicules.edit', $vehicule) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Éditer
            </a>
            <a href="{{ route('admin.vehicules.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-lg mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informations Véhicule</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Marque</h6>
                            <p><strong>{{ $vehicule->marque }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Modèle</h6>
                            <p>{{ $vehicule->modele }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Plaque Immatriculation</h6>
                            <p><code>{{ $vehicule->plaque_immatriculation }}</code></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Couleur</h6>
                            <p>{{ $vehicule->couleur ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Année</h6>
                            <p>{{ $vehicule->annee }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Kilométrage</h6>
                            <p>{{ number_format($vehicule->kilometrage ?? 0, 0, ',', ' ') }} km</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Énergie</h6>
                            <p>{{ ucfirst($vehicule->energie ?? 'N/A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Numéro Chassis</h6>
                            <p>{{ $vehicule->numero_chassis ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Client Propriétaire</h5>
                </div>
                <div class="card-body">
                    <h6>{{ $vehicule->client->utilisateur->nom_complet }}</h6>
                    <p class="text-muted"><i class="bi bi-envelope"></i> {{ $vehicule->client->utilisateur->email }}</p>
                    <p class="text-muted"><i class="bi bi-telephone"></i> {{ $vehicule->client->utilisateur->telephone ?? 'N/A' }}</p>
                    <hr>
                    <p class="small text-muted">{{ $vehicule->client->adresse ?? 'N/A' }}, {{ $vehicule->client->ville ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="card shadow-lg mt-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Réparations</h5>
                </div>
                <div class="card-body">
                    @if($vehicule->reparations->count() > 0)
                    <ul class="list-unstyled">
                        @foreach($vehicule->reparations->take(5) as $reparation)
                        <li class="mb-2">
                            <small>{{ $reparation->description_panne }}</small>
                            <br>
                            <span class="badge bg-{{ $reparation->statut === 'termine' ? 'success' : 'warning' }}">
                                {{ ucfirst(str_replace('_', ' ', $reparation->statut)) }}
                            </span>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-muted">Aucune réparation</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection