@extends('app')

@section('title', 'Modifier le Véhicule')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h1><i class="bi bi-car-front"></i> Modifier le véhicule</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('vehicules.update', $vehicule) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="immatriculation" class="form-label">Immatriculation *</label>
                        <input type="text" class="form-control @error('immatriculation') is-invalid @enderror"
                            id="immatriculation" name="immatriculation" value="{{ old('immatriculation', $vehicule->immatriculation) }}" required>
                        @error('immatriculation')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="marque" class="form-label">Marque</label>
                                <input type="text" class="form-control @error('marque') is-invalid @enderror"
                                    id="marque" name="marque" value="{{ old('marque', $vehicule->marque) }}">
                                @error('marque')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modele" class="form-label">Modèle</label>
                                <input type="text" class="form-control @error('modele') is-invalid @enderror"
                                    id="modele" name="modele" value="{{ old('modele', $vehicule->modele) }}">
                                @error('modele')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="couleur" class="form-label">Couleur</label>
                                <input type="text" class="form-control @error('couleur') is-invalid @enderror"
                                    id="couleur" name="couleur" value="{{ old('couleur', $vehicule->couleur) }}">
                                @error('couleur')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="annee" class="form-label">Année</label>
                                <input type="number" class="form-control @error('annee') is-invalid @enderror"
                                    id="annee" name="annee" value="{{ old('annee', $vehicule->annee) }}">
                                @error('annee')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="kilometrage" class="form-label">Kilométrage</label>
                                <input type="number" class="form-control @error('kilometrage') is-invalid @enderror"
                                    id="kilometrage" name="kilometrage" value="{{ old('kilometrage', $vehicule->kilometrage) }}">
                                @error('kilometrage')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="carrosserie" class="form-label">Carrosserie</label>
                                <select class="form-control @error('carrosserie') is-invalid @enderror"
                                    id="carrosserie" name="carrosserie">
                                    <option value="">Sélectionner</option>
                                    <option value="Berline" {{ old('carrosserie', $vehicule->carrosserie) === 'Berline' ? 'selected' : '' }}>Berline</option>
                                    <option value="SUV" {{ old('carrosserie', $vehicule->carrosserie) === 'SUV' ? 'selected' : '' }}>SUV</option>
                                    <option value="Monospace" {{ old('carrosserie', $vehicule->carrosserie) === 'Monospace' ? 'selected' : '' }}>Monospace</option>
                                    <option value="Coupé" {{ old('carrosserie', $vehicule->carrosserie) === 'Coupé' ? 'selected' : '' }}>Coupé</option>
                                    <option value="Cabriolet" {{ old('carrosserie', $vehicule->carrosserie) === 'Cabriolet' ? 'selected' : '' }}>Cabriolet</option>
                                    <option value="Fourgon" {{ old('carrosserie', $vehicule->carrosserie) === 'Fourgon' ? 'selected' : '' }}>Fourgon</option>
                                    <option value="Camion" {{ old('carrosserie', $vehicule->carrosserie) === 'Camion' ? 'selected' : '' }}>Camion</option>
                                </select>
                                @error('carrosserie')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="energie" class="form-label">Énergie</label>
                                <select class="form-control @error('energie') is-invalid @enderror"
                                    id="energie" name="energie">
                                    <option value="">Sélectionner</option>
                                    <option value="Essence" {{ old('energie', $vehicule->energie) === 'Essence' ? 'selected' : '' }}>Essence</option>
                                    <option value="Diesel" {{ old('energie', $vehicule->energie) === 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="Hybride" {{ old('energie', $vehicule->energie) === 'Hybride' ? 'selected' : '' }}>Hybride</option>
                                    <option value="Électrique" {{ old('energie', $vehicule->energie) === 'Électrique' ? 'selected' : '' }}>Électrique</option>
                                </select>
                                @error('energie')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="boite" class="form-label">Boîte</label>
                                <select class="form-control @error('boite') is-invalid @enderror"
                                    id="boite" name="boite">
                                    <option value="">Sélectionner</option>
                                    <option value="Manuelle" {{ old('boite', $vehicule->boite) === 'Manuelle' ? 'selected' : '' }}>Manuelle</option>
                                    <option value="Automatique" {{ old('boite', $vehicule->boite) === 'Automatique' ? 'selected' : '' }}>Automatique</option>
                                </select>
                                @error('boite')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image du véhicule</label>
                        @if($vehicule->image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($vehicule->image) }}" alt="{{ $vehicule->immatriculation }}"
                                style="max-width: 150px; border-radius: 5px;">
                            <p class="text-muted small">Image actuelle</p>
                        </div>
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                            id="image" name="image" accept="image/*">
                        <small class="form-text text-muted">PNG, JPG, GIF (max 2 MB)</small>
                        @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Mettre à jour
                        </button>
                        <a href="{{ route('vehicules.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection