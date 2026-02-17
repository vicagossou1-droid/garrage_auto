@extends('app')

@section('title', 'Créer un Technicien')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h1><i class="bi bi-person-badge"></i> Ajouter un nouveau technicien</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('techniciens.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom *</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror"
                            id="nom" name="nom" value="{{ old('nom') }}" required>
                        @error('nom')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom *</label>
                        <input type="text" class="form-control @error('prenom') is-invalid @enderror"
                            id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                        @error('prenom')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="specialite" class="form-label">Spécialité</label>
                        <input type="text" class="form-control @error('specialite') is-invalid @enderror"
                            id="specialite" name="specialite" value="{{ old('specialite') }}"
                            placeholder="Ex: Mécanique, Électricité, Carrosserie">
                        @error('specialite')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Créer
                        </button>
                        <a href="{{ route('techniciens.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection