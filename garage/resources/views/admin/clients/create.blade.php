@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold"><i class="bi bi-person-plus"></i> Nouveau Client</h2>
        </div>
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <form action="{{ route('admin.clients.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                        @error('prenom')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom') }}" required>
                        @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone') }}">
                        @error('telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control @error('adresse') is-invalid @enderror" id="adresse" name="adresse" value="{{ old('adresse') }}">
                    @error('adresse')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="ville" class="form-label">Ville</label>
                    <input type="text" class="form-control @error('ville') is-invalid @enderror" id="ville" name="ville" value="{{ old('ville') }}">
                    @error('ville')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="code_postal" class="form-label">Code Postal</label>
                    <input type="text" class="form-control @error('code_postal') is-invalid @enderror" id="code_postal" name="code_postal" value="{{ old('code_postal') }}">
                    @error('code_postal')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-car-front"></i> Informations du Véhicule <span class="text-danger">*</span></h5>

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
                        <label for="plaque_immatriculation" class="form-label">Plaque d'Immatriculation <span class="text-danger">*</span></label>
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
                        <label for="kilometrage" class="form-label">Kilométrage <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('kilometrage') is-invalid @enderror" id="kilometrage" name="kilometrage" value="{{ old('kilometrage') }}" required>
                        @error('kilometrage')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="type_carrosserie" class="form-label">Type de Carrosserie</label>
                        <input type="text" class="form-control @error('type_carrosserie') is-invalid @enderror" id="type_carrosserie" name="type_carrosserie" value="{{ old('type_carrosserie') }}">
                        @error('type_carrosserie')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="energie" class="form-label" Énergie <span class="text-danger">*</span></label>
                        <select class="form-select @error('energie') is-invalid @enderror" id="energie" name="energie" required>
                            <option value="">Sélectionner...</option>
                            <option value="Essence" @selected(old('energie')=='Essence' )>Essence</option>
                            <option value="Diesel" @selected(old('energie')=='Diesel' )>Diesel</option>
                            <option value="Hybride" @selected(old('energie')=='Hybride' )>Hybride</option>
                            <option value="Électrique" @selected(old('energie')=='Électrique' )>Électrique</option>
                            <option value="Autre" @selected(old('energie')=='Autre' )>Autre</option>
                        </select>
                        @error('energie')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="numero_chassis" class="form-label">Numéro de Châssis</label>
                    <input type="text" class="form-control @error('numero_chassis') is-invalid @enderror" id="numero_chassis" name="numero_chassis" value="{{ old('numero_chassis') }}">
                    @error('numero_chassis')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Créer Client
                    </button>
                    <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection