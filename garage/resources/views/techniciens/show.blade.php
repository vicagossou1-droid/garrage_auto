@extends('app')

@section('title', 'Détails du Technicien')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1><i class="bi bi-person-badge"></i> Détails du technicien</h1>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Nom</h5>
                        <p class="fs-5"><strong>{{ $technicien->nom }}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Prénom</h5>
                        <p class="fs-5"><strong>{{ $technicien->prenom }}</strong></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6>Spécialité</h6>
                        <p>{{ $technicien->specialite ?? 'Non renseignée' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6>Créé le</h6>
                        <p>{{ $technicien->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('techniciens.edit', $technicien) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>
                    <form action="{{ route('techniciens.destroy', $technicien) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr?')">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    </form>
                    <a href="{{ route('techniciens.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-tools"></i> Réparations assignées</h5>
            </div>
            <div class="card-body">
                @forelse($reparations as $reparation)
                <div class="mb-3 pb-3 border-bottom">
                    <h6 class="mb-1">{{ $reparation->vehicule->immatriculation }}</h6>
                    <small class="text-muted">{{ $reparation->date->format('d/m/Y') }}</small>
                    <a href="{{ route('reparations.show', $reparation) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                </div>
                @empty
                <p class="text-muted text-center">Aucune réparation assignée</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection