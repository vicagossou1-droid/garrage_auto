@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold"><i class="bi bi-car-front-fill"></i> Nouveau Véhicule</h2>
        </div>
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <form action="{{ route('admin.vehicules.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="client_id" class="form-label">Client <span class="text-danger">*</span></label>
                    <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                        <option value="">-- Sélectionner un client --</option>
                        @foreach($clients as $client)
                        <option value="{{ $client->id }}" @selected(old('client_id')==$client->id)>
                            {{ $client->utilisateur->nom_complet }}
                        </option>
                        @endforeach
                    </select>
                    @error('client_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="marque" class="form-label">Marque <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('marque') is-invalid @enderror" id="marque" name="marque" value="{{ old('marque') }}" required>
                        @error('marque')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="modele" class="form-label">Modèle <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('modele') is-invalid @enderror" id="modele" name="modele" value="{{ old('modele') }}" required>
                        @error('modele')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="plaque_immatriculation" class="form-label">Plaque Immatriculation <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('plaque_immatriculation') is-invalid @enderror" id="plaque_immatriculation" name="plaque_immatriculation" value="{{ old('plaque_immatriculation') }}" required>
                        @error('plaque_immatriculation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="couleur" class="form-label">Couleur</label>
                        <input type="text" class="form-control @error('couleur') is-invalid @enderror" id="couleur" name="couleur" value="{{ old('couleur') }}">
                        @error('couleur')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="annee" class="form-label">Année <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('annee') is-invalid @enderror" id="annee" name="annee" value="{{ old('annee') }}" required>
                        @error('annee')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="kilometrage" class="form-label">Kilométrage</label>
                        <input type="number" class="form-control @error('kilometrage') is-invalid @enderror" id="kilometrage" name="kilometrage" value="{{ old('kilometrage') }}">
                        @error('kilometrage')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="energie" class="form-label">Énergie</label>
                    <select class="form-select @error('energie') is-invalid @enderror" id="energie" name="energie">
                        <option value="">-- Sélectionner --</option>
                        <option value="essence" @selected(old('energie')=='essence' )>Essence</option>
                        <option value="diesel" @selected(old('energie')=='diesel' )>Diesel</option>
                        <option value="hybride" @selected(old('energie')=='hybride' )>Hybride</option>
                        <option value="electrique" @selected(old('energie')=='electrique' )>Électrique</option>
                    </select>
                    @error('energie')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Créer Véhicule
                    </button>
                    <a href="{{ route('admin.vehicules.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection