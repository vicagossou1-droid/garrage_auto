@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
            <h2 class="fw-bold">
                <i class="bi bi-car-front"></i> Détails Véhicule
            </h2>
        </div>
    </div>

    <div class="row g-4">
        <!-- Vehicle Info -->
        <div class="col-lg-8">
            <!-- Vehicle Details Card -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-car-front"></i> Informations Générales</h5>
                </div>
                <div class="card-body">
                    @if ($vehicule->image)
                    <img src="{{ asset('storage/' . $vehicule->image) }}" class="img-fluid rounded mb-4" style="max-height: 300px; width: 100%; object-fit: cover;">
                    @else
                    <div class="bg-light d-flex align-items-center justify-content-center mb-4 rounded" style="height: 300px;">
                        <i class="bi bi-car-front-fill display-1 text-muted"></i>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Marque :</strong> {{ $vehicule->marque }}</p>
                            <p><strong>Modèle :</strong> {{ $vehicule->modele }}</p>
                            <p><strong>Année :</strong> {{ $vehicule->annee }}</p>
                            <p><strong>Couleur :</strong> {{ $vehicule->couleur }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Plaque :</strong> <span class="badge bg-secondary fs-6">{{ $vehicule->plaque_immatriculation }}</span></p>
                            <p><strong>Kilométrage :</strong> {{ number_format($vehicule->kilometrage, 0) }} km</p>
                            <p><strong>Énergie :</strong> {{ $vehicule->energie }}</p>
                            <p><strong>Numéro VIN :</strong> {{ $vehicule->numero_vin ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Repairs History -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-wrench-adjustable"></i> Historique des Réparations</h5>
                </div>
                <div class="card-body p-0">
                    @if (count($reparations) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Description</th>
                                    <th>Statut</th>
                                    <th>Date Dépôt</th>
                                    <th>Coût</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reparations as $rep)
                                <tr>
                                    <td>{{ substr($rep->description_panne, 0, 50) }}...</td>
                                    <td>
                                        <span class="badge bg-{{ $rep->statut === 'en_cours' ? 'warning' : ($rep->statut === 'termine' ? 'success' : ($rep->statut === 'livre' ? 'info' : 'secondary')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $rep->statut)) }}
                                        </span>
                                    </td>
                                    <td>{{ $rep->date_depot->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($rep->cout_final)
                                        {{ number_format($rep->cout_final, 2, '.', ' ') }} XOF
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('client.reparations.show', $rep) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> Détails
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox"></i> Aucune réparation
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($reparations->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $reparations->links() }}
                    </div>
                    @endif
                    @else
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-inbox display-4"></i>
                        <p class="mt-3">Aucune réparation enregistrée pour ce véhicule</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4">
            <!-- Statistics -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-speedometer2"></i> Statistiques</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h3 class="fw-bold text-primary">{{ count($reparations) }}</h3>
                            <p class="small text-muted">Réparations</p>
                        </div>
                        <div class="col-6">
                            <h3 class="fw-bold text-success">{{ $reparations->where('statut', 'termine')->count() }}</h3>
                            <p class="small text-muted">Terminées</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informations</h5>
                </div>
                <div class="card-body">
                    <p class="small">
                        <strong>Enregistré le :</strong> {{ $vehicule->created_at->format('d/m/Y') }}
                    </p>
                    <p class="small">
                        <strong>Dernière mise à jour :</strong> {{ $vehicule->updated_at->format('d/m/Y') }}
                    </p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-wrench"></i> Gestion Véhicule</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('client.vehicules.edit', $vehicule) }}" class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i> Modifier Infos
                        </a>
                        <a href="{{ route('client.vehicules.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Ajouter Véhicule
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection