@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">
                <i class="bi bi-speedometer2"></i> Dashboard Administrateur
            </h2>
            <p class="text-muted">Bienvenue, {{ auth()->user()->nom_complet }}</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-5">
        <!-- En Attente -->
        <div class="col-md-3">
            <a href="{{ route('admin.reparations.index', ['statut' => 'en_attente']) }}" class="text-decoration-none">
                <div class="card shadow-lg cursor-pointer h-100" style="transition: all 0.3s ease; cursor: pointer;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">En Attente</p>
                                <h3 class="fw-bold">{{ $statistiques['reparations_en_attente'] }}</h3>
                            </div>
                            <i class="bi bi-hourglass-split display-4 text-info"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- En Cours -->
        <div class="col-md-3">
            <a href="{{ route('admin.reparations.index', ['statut' => 'en_cours']) }}" class="text-decoration-none">
                <div class="card shadow-lg cursor-pointer h-100" style="transition: all 0.3s ease; cursor: pointer;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">En Cours</p>
                                <h3 class="fw-bold">{{ $statistiques['reparations_en_cours'] }}</h3>
                            </div>
                            <i class="bi bi-clock-history display-4 text-danger"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Réparations Totales -->
        <div class="col-md-3">
            <a href="{{ route('admin.reparations.index') }}" class="text-decoration-none">
                <div class="card shadow-lg cursor-pointer h-100" style="transition: all 0.3s ease; cursor: pointer;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Réparations<br>Totales</p>
                                <h3 class="fw-bold">{{ $statistiques['reparations_total'] }}</h3>
                            </div>
                            <i class="bi bi-wrench-adjustable display-4 text-warning"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Total Clients -->
        <div class="col-md-3">
            <a href="{{ route('admin.clients.index') }}" class="text-decoration-none">
                <div class="card shadow-lg cursor-pointer h-100" style="transition: all 0.3s ease; cursor: pointer;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Total Clients</p>
                                <h3 class="fw-bold">{{ $statistiques['clients_total'] }}</h3>
                            </div>
                            <i class="bi bi-people display-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Techniciens -->
        <div class="col-md-3">
            <a href="{{ route('admin.techniciens.index') }}" class="text-decoration-none">
                <div class="card shadow-lg cursor-pointer h-100" style="transition: all 0.3s ease; cursor: pointer;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Techniciens</p>
                                <h3 class="fw-bold">{{ $statistiques['techniciens_total'] }}</h3>
                            </div>
                            <i class="bi bi-tools display-4 text-success"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Véhicule fréquent -->
        <div class="col-lg-4">
            <div class="card shadow-lg cursor-pointer h-100" style="transition: all 0.3s ease; cursor: pointer; min-height: 130px; display: flex; flex-direction: column;">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-car-front"></i> Véhicule fréquent</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center flex-grow-1">
                    @if($vehicule_frequent)
                    <p class="fw-bold mb-1">{{ $vehicule_frequent->vehicule->plaque_immatriculation }}</p>
                    <p class="text-muted small">{{ $vehicule_frequent->vehicule->marque }} {{ $vehicule_frequent->vehicule->modele }}</p>
                    <span class="badge bg-warning text-dark">{{ $vehicule_frequent->count }} réparations</span>
                    @else
                    <p class="text-muted">Aucune donnée</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Technicien top -->
        <div class="col-lg-4">
            <div class="card shadow-lg cursor-pointer h-100" style="transition: all 0.3s ease; cursor: pointer; min-height: 130px; display: flex; flex-direction: column;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-person-check"></i> Technicien top</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center flex-grow-1">
                    @if($technicien_top)
                    <p class="fw-bold mb-1">{{ $technicien_top->technicien->utilisateur->nom_complet }}</p>
                    <p class="text-muted small">{{ $technicien_top->technicien->utilisateur->specialite }}</p>
                    <span class="badge bg-success">{{ $technicien_top->count }} interventions</span>
                    @else
                    <p class="text-muted">Aucune donnée</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Repairs - Accordion -->
    <div class="row g-4">
        <!-- Left Column: Actions + Chart -->
        <div class="col-lg-6">
            <!-- Quick Actions -->
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Actions Rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.reparations.create') }}" class="btn btn-outline-primary">
                            <i class="bi bi-plus-circle"></i> Nouvelle Réparation
                        </a>
                        <a href="{{ route('admin.clients.create') }}" class="btn btn-outline-primary">
                            <i class="bi bi-person-plus"></i> Ajouter Client
                        </a>
                        <a href="{{ route('admin.techniciens.create') }}" class="btn btn-outline-primary">
                            <i class="bi bi-wrench"></i> Ajouter Technicien
                        </a>
                        <a href="{{ route('admin.reparations.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-file-pdf"></i> Gérer Réparations
                        </a>
                    </div>
                </div>
            </div>

            <!-- Doughnut Chart -->
            <div class="card shadow-lg mt-4" style="display: flex; flex-direction: column;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Réparations par technicien</h5>
                </div>
                <div class="card-body flex-grow-1 d-flex align-items-center justify-content-center" style="padding: 10px; margin: 0;">
                    <div style="width: 100%; height: 220px; position: relative;">
                        <canvas id="reparationsParTechnicienChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Recent Repairs -->
        <div class="col-lg-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Réparations Récentes</h5>
                </div>
                <div class="card-body p-0">
                    <div class="accordion accordion-flush" id="reparationsAccordion">
                        @forelse ($reparations_recentes as $index => $reparation)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}">
                                    <strong>{{ $reparation->vehicule->marque }} {{ $reparation->vehicule->modele }}</strong>
                                    <span class="ms-3 badge bg-{{ $reparation->statut === 'en_attente' ? 'info' : ($reparation->statut === 'en_cours' ? 'warning' : ($reparation->statut === 'termine' ? 'success' : 'primary')) }}">
                                        @switch($reparation->statut)
                                            @case('en_attente')
                                                En attente
                                                @break
                                            @case('en_cours')
                                                En cours
                                                @break
                                            @case('termine')
                                                Terminé
                                                @break
                                            @case('livre')
                                                Livrée
                                                @break
                                            @default
                                                {{ ucfirst(str_replace('_', ' ', $reparation->statut)) }}
                                        @endswitch
                                    </span>
                                    <span class="ms-3 text-muted small">{{ $reparation->date_depot->format('d/m/Y') }}</span>
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#reparationsAccordion">
                                <div class="accordion-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p><strong>Véhicule :</strong> {{ $reparation->vehicule->marque }} {{ $reparation->vehicule->modele }}</p>
                                            <p><strong>Plaque :</strong> {{ $reparation->vehicule->plaque_immatriculation }}</p>
                                            <p><strong>Client :</strong> {{ $reparation->client->utilisateur->nom_complet }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Statut :</strong> 
                                                <span class="badge bg-{{ $reparation->statut === 'en_attente' ? 'info' : ($reparation->statut === 'en_cours' ? 'warning' : ($reparation->statut === 'termine' ? 'success' : 'primary')) }}">
                                                    @switch($reparation->statut)
                                                        @case('en_attente')
                                                            En attente
                                                            @break
                                                        @case('en_cours')
                                                            En cours
                                                            @break
                                                        @case('termine')
                                                            Terminé
                                                            @break
                                                        @case('livre')
                                                            Livrée
                                                            @break
                                                        @default
                                                            {{ ucfirst(str_replace('_', ' ', $reparation->statut)) }}
                                                    @endswitch
                                                </span>
                                            </p>
                                            <p><strong>Date dépôt :</strong> {{ $reparation->date_depot->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.reparations.show', $reparation) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> Voir Détails
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-3 text-center text-muted">
                            Aucune réparation
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Statistics & Analytics -->
    <div class="row g-4 mt-5 mb-5">
        <!-- Line Chart -->
        <div class="col-lg-12">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-bar-chart-line"></i> Réparations par mois</h5>
                </div>
                <div class="card-body" style="padding: 20px;">
                    <div style="height: 250px; position: relative;">
                        <canvas id="reparationsParMoisChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique Réparations par mois
    const ctxMois = document.getElementById('reparationsParMoisChart').getContext('2d');
    
    // Préparer les données avec ordre garanti
    const moisData = @json($reparations_par_mois);
    const moisLabels = Object.keys(moisData);
    const moisValues = Object.values(moisData);
    
    console.log('Mois Labels:', moisLabels);
    console.log('Mois Values:', moisValues);
    
    new Chart(ctxMois, {
        type: 'line',
        data: {
            labels: moisLabels,
            datasets: [{
                label: 'Réparations',
                data: moisValues,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2,
                pointBackgroundColor: '#0d6efd',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5,
                        callback: function(value) {
                            return value;
                        }
                    }
                },
                x: {
                    display: true,
                    ticks: {
                        maxRotation: 45,
                        minRotation: 0
                    }
                }
            }
        }
    });

    // Graphique Réparations par technicien
    const ctxTechnicien = document.getElementById('reparationsParTechnicienChart').getContext('2d');
    new Chart(ctxTechnicien, {
        type: 'doughnut',
        data: {
            labels: @json(array_keys($reparations_par_technicien->toArray())),
            datasets: [{
                data: @json(array_values($reparations_par_technicien->toArray())),
                backgroundColor: [
                    '#0d6efd',
                    '#198754',
                    '#ffc107',
                    '#dc3545',
                    '#17a2b8',
                    '#e83e8c'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    align: 'center',
                    labels: {
                        padding: 12,
                        font: {
                            size: 11
                        },
                        boxWidth: 12,
                        boxHeight: 12
                    }
                }
            }
        }
    });
</script>
@endsection