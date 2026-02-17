@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">
                <i class="bi bi-person-circle"></i> Mon Espace
            </h2>
            <p class="text-muted">Bienvenue, {{ auth()->user()->nom_complet }}</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted">Mes Véhicules</p>
                            <h3 class="fw-bold">{{ $statistiques['vehicules'] }}</h3>
                        </div>
                        <i class="bi bi-car-front-fill display-4 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted">Réparations En Cours</p>
                            <h3 class="fw-bold">{{ $statistiques['reparations_en_cours'] }}</h3>
                        </div>
                        <i class="bi bi-tools display-4 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted">Réparations Terminées</p>
                            <h3 class="fw-bold">{{ $statistiques['reparations_terminees'] }}</h3>
                        </div>
                        <i class="bi bi-check-circle display-4 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs for Repairs and Vehicles -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="reparations-tab" data-bs-toggle="tab" data-bs-target="#reparations" type="button">
                <i class="bi bi-wrench-adjustable"></i> Mes Réparations
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="vehicules-tab" data-bs-toggle="tab" data-bs-target="#vehicules" type="button">
                <i class="bi bi-car-front-fill"></i> Mes Véhicules
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Repairs Tab -->
        <div class="tab-pane fade show active" id="reparations" role="tabpanel">
            <div class="card shadow-lg">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Véhicule</th>
                                    <th>Description</th>
                                    <th>Statut</th>
                                    <th>Date Dépôt</th>
                                    <th>Coût</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reparations as $reparation)
                                <tr>
                                    <td>
                                        <strong>{{ $reparation->vehicule->marque }} {{ $reparation->vehicule->modele }}</strong><br>
                                        <small class="text-muted">{{ $reparation->vehicule->plaque_immatriculation }}</small>
                                    </td>
                                    <td>{{ substr($reparation->description_panne, 0, 50) }}...</td>
                                    <td>
                                        <span class="badge bg-{{ $reparation->statut === 'en_cours' ? 'warning' : ($reparation->statut === 'termine' ? 'success' : 'info') }}">
                                            {{ ucfirst($reparation->statut) }}
                                        </span>
                                    </td>
                                    <td>{{ $reparation->date_depot->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($reparation->cout_final)
                                        <strong>{{ number_format($reparation->cout_final, 2, '.', ' ') }} XOF</strong>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('client.reparations.show', $reparation) }}" class="btn btn-sm btn-primary">Détails</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox"></i> Aucune réparation
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if ($reparations->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $reparations->links() }}
            </div>
            @endif
        </div>

        <!-- Vehicles Tab -->
        <div class="tab-pane fade" id="vehicules" role="tabpanel">
            <div class="row g-4">
                @forelse ($vehicules as $vehicule)
                <div class="col-md-6">
                    <a href="{{ route('client.vehicules.show', $vehicule) }}" class="text-decoration-none">
                        <div class="card shadow-lg h-100" style="transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(0, 0, 0, 0.12)';">
                            @if ($vehicule->image)
                            <img src="{{ asset('storage/' . $vehicule->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-car-front-fill display-4 text-muted"></i>
                            </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $vehicule->annee }} {{ $vehicule->marque }} {{ $vehicule->modele }}</h5>
                                <p class="card-text">
                                    <small class="text-muted">
                                        <i class="bi bi-palette"></i> {{ $vehicule->couleur }}<br>
                                        <i class="bi bi-speedometer"></i> {{ number_format($vehicule->kilometrage, 0) }} km<br>
                                        <i class="bi bi-fuel-pump"></i> {{ $vehicule->energie }}<br>
                                        <i class="bi bi-hash"></i> {{ $vehicule->plaque_immatriculation }}
                                    </small>
                                </p>
                                <a href="{{ route('client.vehicules.show', $vehicule) }}" class="btn btn-sm btn-primary">Voir Détails</a>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle"></i> Aucun véhicule enregistré
                    </div>
                </div>
                @endforelse
            </div>

            @if ($vehicules->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $vehicules->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Style for nav tabs titles */
    .nav-tabs .nav-link {
        color: black !important;
    }

    .nav-tabs .nav-link.active {
        color: black !important;
    }

    .nav-tabs .nav-link:hover {
        color: black !important;
    }
</style>
@endsection