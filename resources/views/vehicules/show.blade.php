@extends('app')

@section('title', 'Détails du Véhicule')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1><i class="bi bi-car-front"></i> Détails du véhicule</h1>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Immatriculation</h5>
                        <p class="text-primary fs-5"><strong>{{ $vehicule->immatriculation }}</strong></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Marque</h6>
                        <p>{{ $vehicule->marque ?? 'Non renseignée' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Modèle</h6>
                        <p>{{ $vehicule->modele ?? 'Non renseigné' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Couleur</h6>
                        <p>{{ $vehicule->couleur ?? 'Non renseignée' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Année</h6>
                        <p>{{ $vehicule->annee ?? 'Non renseignée' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Kilométrage</h6>
                        <p>{{ $vehicule->kilometrage ? number_format($vehicule->kilometrage, 0, ',', ' ') . ' km' : 'Non renseigné' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Carrosserie</h6>
                        <p>{{ $vehicule->carrosserie ?? 'Non renseignée' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Énergie</h6>
                        <p>{{ $vehicule->energie ?? 'Non renseignée' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Boîte</h6>
                        <p>{{ $vehicule->boite ?? 'Non renseignée' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6>Créé le</h6>
                        <p>{{ $vehicule->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('vehicules.edit', $vehicule) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>
                    <form action="{{ route('vehicules.destroy', $vehicule) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr?')">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    </form>
                    <a href="{{ route('vehicules.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-tools"></i> Réparations</h5>
            </div>
            <div class="card-body">
                @forelse($reparations as $reparation)
                <div class="mb-3 pb-3 border-bottom">
                    <h6 class="mb-1">{{ $reparation->objet_reparation }}</h6>
                    <small class="text-muted">{{ $reparation->date->format('d/m/Y') }}</small>
                    <a href="{{ route('reparations.show', $reparation) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                </div>
                @empty
                <p class="text-muted text-center">Aucune réparation</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection