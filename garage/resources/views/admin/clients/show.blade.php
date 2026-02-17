@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold"><i class="bi bi-person"></i> Détail Client</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Éditer
            </a>
            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-lg mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informations Personnelles</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Nom Complet</h6>
                            <p>{{ $client->utilisateur->nom_complet }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Email</h6>
                            <p>{{ $client->utilisateur->email }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Téléphone</h6>
                            <p>{{ $client->utilisateur->telephone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Statut</h6>
                            <span class="badge bg-{{ $client->utilisateur->statut === 'actif' ? 'success' : 'danger' }}">
                                {{ ucfirst($client->utilisateur->statut) }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Adresse</h6>
                            <p>{{ $client->adresse ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Ville</h6>
                            <p>{{ $client->ville ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Véhicules ({{ $client->vehicules->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($client->vehicules->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Marque/Modèle</th>
                                    <th>Immatriculation</th>
                                    <th>Année</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($client->vehicules as $vehicule)
                                <tr>
                                    <td>{{ $vehicule->marque }} {{ $vehicule->modele }}</td>
                                    <td>{{ $vehicule->plaque_immatriculation }}</td>
                                    <td>{{ $vehicule->annee }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted">Aucun véhicule enregistré</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Réparations ({{ $client->reparations->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($client->reparations->count() > 0)
                    <ul class="list-unstyled">
                        @foreach($client->reparations->take(5) as $reparation)
                        <li class="mb-2">
                            <small class="text-muted">{{ $reparation->date_depot->format('d/m/Y') }}</small>
                            <br>
                            <small>{{ $reparation->description_panne }}</small>
                        </li>
                        @endforeach
                    </ul>
                    @if($client->reparations->count() > 5)
                    <small class="text-muted">... et {{ $client->reparations->count() - 5 }} autres</small>
                    @endif
                    @else
                    <p class="text-muted">Aucune réparation</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection