@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold"><i class="bi bi-person-check"></i> Affecter Techniciens - {{ $reparation->vehicule->marque }} {{ $reparation->vehicule->modele }}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Sélectionner un Technicien</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reparations.assign.store', $reparation) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="technicien_id" class="form-label">Technicien à Affecter <span class="text-danger">*</span></label>
                            <select class="form-select @error('technicien_id') is-invalid @enderror" id="technicien_id" name="technicien_id" required>
                                <option value="">-- Sélectionner un technicien --</option>
                                @foreach($techniciens as $technicien)
                                <option value="{{ $technicien->id }}" @selected(old('technicien_id')==$technicien->id)>
                                    {{ $technicien->utilisateur->nom_complet }} - {{ $technicien->specialite ?? 'Généraliste' }}
                                </option>
                                @endforeach
                            </select>
                            @error('technicien_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Affecter
                            </button>
                            <a href="{{ route('admin.reparations.show', $reparation) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-lg">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Techniciens Affectés</h5>
                </div>
                <div class="card-body">
                    @if($reparation->interventions->count() > 0)
                    <div class="list-group">
                        @foreach($reparation->interventions as $intervention)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ $intervention->technicien->utilisateur->nom_complet }}</h6>
                                <small class="text-muted">{{ $intervention->technicien->specialite ?? 'Généraliste' }}</small>
                            </div>
                            <form action="{{ route('admin.reparations.unassign', [$reparation, $intervention->technicien_id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Retirer ce technicien ?')">
                                    <i class="bi bi-x"></i>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted mb-0">Aucun technicien affecté</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection