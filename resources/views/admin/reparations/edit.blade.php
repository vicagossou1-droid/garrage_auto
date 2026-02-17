@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold"><i class="bi bi-pencil"></i> Éditer Réparation</h2>
        </div>
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <form action="{{ route('admin.reparations.update', $reparation) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="vehicule_id" class="form-label">Véhicule <span class="text-danger">*</span></label>
                    <select class="form-select @error('vehicule_id') is-invalid @enderror" id="vehicule_id" name="vehicule_id" required>
                        <option value="">Sélectionner un véhicule</option>
                        @foreach($vehicules as $vehicule)
                        <option value="{{ $vehicule->id }}" @selected(old('vehicule_id', $reparation->vehicule_id) == $vehicule->id)>
                            {{ $vehicule->client->utilisateur->nom_complet }} - {{ $vehicule->marque }} {{ $vehicule->modele }} ({{ $vehicule->plaque_immatriculation }})
                        </option>
                        @endforeach
                    </select>
                    @error('vehicule_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description_panne" class="form-label">Description Panne <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description_panne') is-invalid @enderror" id="description_panne" name="description_panne" rows="4" required>{{ old('description_panne', $reparation->description_panne) }}</textarea>
                    @error('description_panne')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="statut" class="form-label">Statut <span class="text-danger">*</span></label>
                        <select class="form-select @error('statut') is-invalid @enderror" id="statut" name="statut" required>
                            <option value="en_attente" @selected(old('statut', $reparation->statut) == 'en_attente')>En Attente</option>
                            <option value="en_cours" @selected(old('statut', $reparation->statut) == 'en_cours')>En Cours</option>
                            <option value="termine" @selected(old('statut', $reparation->statut) == 'termine')>Terminée</option>
                            <option value="livree" @selected(old('statut', $reparation->statut) == 'livree')>Livrée</option>
                            <option value="annulee" @selected(old('statut', $reparation->statut) == 'annulee')>Annulée</option>
                        </select>
                        @error('statut')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="estimation_cout" class="form-label">Estimation Coût (XOF)</label>
                        <input type="number" class="form-control @error('estimation_cout') is-invalid @enderror" id="estimation_cout" name="estimation_cout" step="0.01" value="{{ old('estimation_cout', $reparation->estimation_cout) }}">
                        @error('estimation_cout')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cout_final" class="form-label">Coût Final (XOF)</label>
                        <input type="number" class="form-control @error('cout_final') is-invalid @enderror" id="cout_final" name="cout_final" step="0.01" value="{{ old('cout_final', $reparation->cout_final) }}">
                        @error('cout_final')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="date_fin_prevue" class="form-label">Date Fin Prévue</label>
                        <input type="date" class="form-control @error('date_fin_prevue') is-invalid @enderror" id="date_fin_prevue" name="date_fin_prevue" value="{{ old('date_fin_prevue', $reparation->date_fin_prevue?->format('Y-m-d')) }}">
                        @error('date_fin_prevue')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="date_fin_reelle" class="form-label">Date Fin Réelle</label>
                    <input type="date" class="form-control @error('date_fin_reelle') is-invalid @enderror" id="date_fin_reelle" name="date_fin_reelle" value="{{ old('date_fin_reelle', $reparation->date_fin_reelle?->format('Y-m-d')) }}">
                    @error('date_fin_reelle')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="technicien_id" class="form-label">Technicien <span class="text-danger">*</span></label>
                    <select class="form-select @error('technicien_id') is-invalid @enderror" id="technicien_id" name="technicien_id" required>
                        <option value="">Sélectionner un technicien</option>
                        @foreach($techniciens as $technicien)
                        <option value="{{ $technicien->id }}" @selected(old('technicien_id', $current_technicien)==$technicien->id)>
                            {{ $technicien->utilisateur->nom_complet }} - {{ $technicien->specialite ?? 'Sans spécialité' }}
                        </option>
                        @endforeach
                    </select>
                    @error('technicien_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Mettre à Jour
                    </button>
                    <a href="{{ route('admin.reparations.show', $reparation) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection