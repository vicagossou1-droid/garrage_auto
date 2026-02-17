@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold"><i class="bi bi-wrench"></i> Détail Réparation</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.reparations.assign', $reparation) }}" class="btn btn-success">
                <i class="bi bi-person-check"></i> Affecter Techniciens
            </a>
            <a href="{{ route('admin.reparations.edit', $reparation) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Éditer
            </a>
            <a href="{{ route('admin.reparations.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-lg mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informations Réparation</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Statut</h6>
                            <span class="badge bg-{{ $reparation->statut === 'en_attente' ? 'info' : ($reparation->statut === 'en_cours' ? 'warning' : ($reparation->statut === 'termine' ? 'success' : 'primary')) }} fs-5">
                                {{ ucfirst(str_replace('_', ' ', $reparation->statut)) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Date Début</h6>
                            <p>{{ $reparation->date_depot->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Estimation Coût</h6>
                            <p class="fw-bold">{{ $reparation->estimation_cout ? number_format($reparation->estimation_cout, 2, ',', ' ') . ' XOF' : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Coût Final</h6>
                            <p class="fw-bold">{{ $reparation->cout_final ? number_format($reparation->cout_final, 2, ',', ' ') . ' XOF' : 'En attente' }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">Description Panne</h6>
                        <p>{{ $reparation->description_panne }}</p>
                    </div>

                    @if($reparation->notes_admin)
                    <div class="mb-3">
                        <h6 class="text-muted">Notes Admin</h6>
                        <p>{{ $reparation->notes_admin }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-lg mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Véhicule</h5>
                </div>
                <div class="card-body">
                    <p><strong>{{ $reparation->vehicule->marque }} {{ $reparation->vehicule->modele }}</strong></p>
                    <p><small class="text-muted">Immatriculation: {{ $reparation->vehicule->plaque_immatriculation }}</small></p>
                    <p><small>Année: {{ $reparation->vehicule->annee }}</small></p>
                    <p><small>Kilométrage: {{ number_format($reparation->vehicule->kilometrage, 0, ',', ' ') }} km</small></p>
                </div>
            </div>

            <div class="card shadow-lg">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Client</h5>
                </div>
                <div class="card-body">
                    <p><strong>{{ $reparation->client->utilisateur->nom_complet }}</strong></p>
                    <p><small class="text-muted">{{ $reparation->client->utilisateur->email }}</small></p>
                    <p><small>{{ $reparation->client->utilisateur->telephone }}</small></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection