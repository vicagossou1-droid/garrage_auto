@extends('app')

@section('title', 'Détails de la Réparation')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1><i class="bi bi-tools"></i> Détails de la réparation</h1>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Véhicule</h6>
                        <p class="fs-5">
                            <a href="{{ route('vehicules.show', $reparation->vehicule) }}" class="text-primary">
                                <strong>{{ $reparation->vehicule->immatriculation }}</strong>
                                ({{ $reparation->vehicule->marque }} {{ $reparation->vehicule->modele }})
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Technicien</h6>
                        <p class="fs-5">
                            @if($reparation->technicien)
                            <a href="{{ route('techniciens.show', $reparation->technicien) }}" class="text-primary">
                                <strong>{{ $reparation->technicien->prenom }} {{ $reparation->technicien->nom }}</strong>
                            </a>
                            @else
                            <span class="text-muted">Non assigné</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <h6>Date de réparation</h6>
                        <p>{{ $reparation->date->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6>Durée main-d'œuvre</h6>
                        <p>{{ $reparation->duree_main_oeuvre ? $reparation->duree_main_oeuvre . ' minutes' : 'Non renseignée' }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6>Créée le</h6>
                        <p>{{ $reparation->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <h6>Description de la réparation</h6>
                    <div class="alert alert-light border">
                        <p>{{ nl2br($reparation->objet_reparation) }}</p>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('reparations.edit', $reparation) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>
                    <form action="{{ route('reparations.destroy', $reparation) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr?')">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    </form>
                    <a href="{{ route('reparations.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection