@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold"><i class="bi bi-tools"></i> Détail Technicien</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.techniciens.edit', $technicien) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Éditer
            </a>
            <a href="{{ route('admin.techniciens.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informations Technicien</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="text-muted">Nom Complet</h6>
                    <p>{{ $technicien->utilisateur->nom_complet }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Email</h6>
                    <p>{{ $technicien->utilisateur->email }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="text-muted">Spécialité</h6>
                    <p>{{ $technicien->specialite ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Taux Horaire</h6>
                    <p>{{ $technicien->taux_horaire }} XOF/h</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-muted">Téléphone</h6>
                    <p>{{ $technicien->utilisateur->telephone ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Statut</h6>
                    <span class="badge bg-{{ $technicien->utilisateur->statut === 'actif' ? 'success' : 'danger' }}">
                        {{ ucfirst($technicien->utilisateur->statut) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection