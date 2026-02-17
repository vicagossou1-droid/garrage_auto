@extends('app')

@section('title', 'Modifier la Réparation')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h1><i class="bi bi-tools"></i> Modifier la réparation</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('reparations.update', $reparation) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="vehicule_id" class="form-label">Véhicule *</label>
                        <select class="form-control @error('vehicule_id') is-invalid @enderror"
                            id="vehicule_id" name="vehicule_id" required>
                            <option value="">Sélectionner un véhicule</option>
                            @foreach($vehicules as $vehicule)
                            <option value="{{ $vehicule->id }}" {{ old('vehicule_id', $reparation->vehicule_id) === (string)$vehicule->id ? 'selected' : '' }}>
                                {{ $vehicule->immatriculation }} - {{ $vehicule->marque }} {{ $vehicule->modele }}
                            </option>
                            @endforeach
                        </select>
                        @error('vehicule_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="technicien_id" class="form-label">Technicien (optionnel)</label>
                        <select class="form-control @error('technicien_id') is-invalid @enderror"
                            id="technicien_id" name="technicien_id">
                            <option value="">Sélectionner un technicien</option>
                            @foreach($techniciens as $technicien)
                            <option value="{{ $technicien->id }}" {{ old('technicien_id', $reparation->technicien_id) === (string)$technicien->id ? 'selected' : '' }}>
                                {{ $technicien->prenom }} {{ $technicien->nom }}
                                @if($technicien->specialite) ({{ $technicien->specialite }}) @endif
                            </option>
                            @endforeach
                        </select>
                        @error('technicien_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label">Date de réparation *</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    id="date" name="date" value="{{ old('date', $reparation->date->format('Y-m-d')) }}" required>
                                @error('date')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duree_main_oeuvre" class="form-label">Durée main-d'œuvre (minutes)</label>
                                <input type="number" class="form-control @error('duree_main_oeuvre') is-invalid @enderror"
                                    id="duree_main_oeuvre" name="duree_main_oeuvre" value="{{ old('duree_main_oeuvre', $reparation->duree_main_oeuvre) }}" min="0">
                                @error('duree_main_oeuvre')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="objet_reparation" class="form-label">Description de la réparation *</label>
                        <textarea class="form-control @error('objet_reparation') is-invalid @enderror"
                            id="objet_reparation" name="objet_reparation" rows="5" required>{{ old('objet_reparation', $reparation->objet_reparation) }}</textarea>
                        @error('objet_reparation')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Mettre à jour
                        </button>
                        <a href="{{ route('reparations.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection