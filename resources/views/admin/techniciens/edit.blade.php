@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold"><i class="bi bi-pencil"></i> Éditer Technicien</h2>
        </div>
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <form action="{{ route('admin.techniciens.update', $technicien) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="{{ old('prenom', $technicien->utilisateur->prenom) }}" required>
                        @error('prenom')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $technicien->utilisateur->nom) }}" required>
                        @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $technicien->utilisateur->email) }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone', $technicien->utilisateur->telephone) }}">
                        @error('telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="specialite" class="form-label">Spécialité</label>
                        <input type="text" class="form-control @error('specialite') is-invalid @enderror" id="specialite" name="specialite" value="{{ old('specialite', $technicien->specialite) }}">
                        @error('specialite')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="taux_horaire" class="form-label">Taux Horaire (XOF/h)</label>
                        <input type="number" class="form-control @error('taux_horaire') is-invalid @enderror" id="taux_horaire" name="taux_horaire" step="0.01" value="{{ old('taux_horaire', $technicien->taux_horaire) }}">
                        @error('taux_horaire')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Mettre à Jour
                    </button>
                    <a href="{{ route('admin.techniciens.show', $technicien) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection