@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('client.vehicules.show', $vehicule) }}" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Annuler
            </a>
            <h2 class="fw-bold">
                <i class="bi bi-pencil-square"></i> Modifier Véhicule
            </h2>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8 offset-lg-2">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-car-front"></i> Informations du Véhicule</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.vehicules.update', $vehicule) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Image -->
                        <div class="mb-4">
                            <label for="image" class="form-label"><i class="bi bi-image"></i> Photo du Véhicule</label>
                            @if ($vehicule->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $vehicule->image) }}" class="img-fluid rounded" style="max-height: 300px;">
                            </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">Format accepté : JPEG, PNG, GIF (Max 2MB)</small>
                        </div>

                        <div class="row">
                            <!-- Marque -->
                            <div class="col-md-6 mb-3">
                                <label for="marque" class="form-label">Marque *</label>
                                <input type="text" class="form-control @error('marque') is-invalid @enderror" id="marque" name="marque" value="{{ old('marque', $vehicule->marque) }}" required>
                                @error('marque')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Modèle -->
                            <div class="col-md-6 mb-3">
                                <label for="modele" class="form-label">Modèle *</label>
                                <input type="text" class="form-control @error('modele') is-invalid @enderror" id="modele" name="modele" value="{{ old('modele', $vehicule->modele) }}" required>
                                @error('modele')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Année -->
                            <div class="col-md-6 mb-3">
                                <label for="annee" class="form-label">Année *</label>
                                <input type="number" class="form-control @error('annee') is-invalid @enderror" id="annee" name="annee" value="{{ old('annee', $vehicule->annee) }}" min="1900" max="{{ date('Y') }}" required>
                                @error('annee')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Couleur -->
                            <div class="col-md-6 mb-3">
                                <label for="couleur" class="form-label">Couleur</label>
                                <input type="text" class="form-control @error('couleur') is-invalid @enderror" id="couleur" name="couleur" value="{{ old('couleur', $vehicule->couleur) }}">
                                @error('couleur')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Plaque d'immatriculation -->
                            <div class="col-md-6 mb-3">
                                <label for="plaque_immatriculation" class="form-label">Plaque d'Immatriculation *</label>
                                <input type="text" class="form-control @error('plaque_immatriculation') is-invalid @enderror" id="plaque_immatriculation" name="plaque_immatriculation" value="{{ old('plaque_immatriculation', $vehicule->plaque_immatriculation) }}" required>
                                @error('plaque_immatriculation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kilométrage -->
                            <div class="col-md-6 mb-3">
                                <label for="kilometrage" class="form-label">Kilométrage (km) *</label>
                                <input type="number" class="form-control @error('kilometrage') is-invalid @enderror" id="kilometrage" name="kilometrage" value="{{ old('kilometrage', $vehicule->kilometrage) }}" min="0" required>
                                @error('kilometrage')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Énergie -->
                            <div class="col-md-6 mb-3">
                                <label for="energie" class="form-label">Énergie *</label>
                                <select class="form-select @error('energie') is-invalid @enderror" id="energie" name="energie" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="Essence" {{ old('energie', $vehicule->energie) === 'Essence' ? 'selected' : '' }}>Essence</option>
                                    <option value="Diesel" {{ old('energie', $vehicule->energie) === 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="Hybride" {{ old('energie', $vehicule->energie) === 'Hybride' ? 'selected' : '' }}>Hybride</option>
                                    <option value="Électrique" {{ old('energie', $vehicule->energie) === 'Électrique' ? 'selected' : '' }}>Électrique</option>
                                    <option value="Gaz" {{ old('energie', $vehicule->energie) === 'Gaz' ? 'selected' : '' }}>Gaz</option>
                                </select>
                                @error('energie')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Numéro VIN -->
                            <div class="col-md-6 mb-3">
                                <label for="numero_vin" class="form-label">Numéro VIN</label>
                                <input type="text" class="form-control @error('numero_vin') is-invalid @enderror" id="numero_vin" name="numero_vin" value="{{ old('numero_vin', $vehicule->numero_vin) }}">
                                @error('numero_vin')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Enregistrer Modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection