@extends('app')

@section('title', 'Dashboard')

@section('content')
<h1 class="mb-4"><i class="bi bi-graph-up"></i> Dashboard</h1>

<!-- Statistiques principales -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-center border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title text-muted mb-2">Véhicules</h6>
                <h2 class="text-primary mb-0">{{ $totalVehicules }}</h2>
                <small class="text-muted">Enregistrés</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title text-muted mb-2">Techniciens</h6>
                <h2 class="text-success mb-0">{{ $totalTechniciens }}</h2>
                <small class="text-muted">En équipe</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title text-muted mb-2">Réparations</h6>
                <h2 class="text-warning mb-0">{{ $totalReparations }}</h2>
                <small class="text-muted">Total</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title text-muted mb-2">Ce mois</h6>
                <h2 class="text-info mb-0">{{ $reparationsThisMonth }}</h2>
                <small class="text-muted">Réparations</small>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Réparations récentes -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Réparations récentes</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Véhicule</th>
                                <th>Technicien</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reparationsRecentes as $reparation)
                            <tr>
                                <td>
                                    <strong>{{ $reparation->vehicule->immatriculation }}</strong><br>
                                    <small class="text-muted">{{ $reparation->vehicule->marque }} {{ $reparation->vehicule->modele }}</small>
                                </td>
                                <td>
                                    @if($reparation->technicien)
                                    {{ $reparation->technicien->prenom }} {{ $reparation->technicien->nom }}
                                    @else
                                    <span class="text-muted">Non assigné</span>
                                    @endif
                                </td>
                                <td>{{ $reparation->date->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('reparations.show', $reparation) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Aucune réparation</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light border-0">
                <a href="{{ route('reparations.index') }}" class="text-decoration-none">Voir toutes les réparations →</a>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0"><i class="bi bi-tools"></i> Ce mois</h5>
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <strong>Durée totale :</strong>
                    <span class="badge bg-info">
                        {{ $dureeTotaleMois ? intdiv($dureeTotaleMois, 60) . 'h ' . ($dureeTotaleMois % 60) . 'min' : 'N/A' }}
                    </span>
                </p>
                <p class="mb-2">
                    <strong>Moyenne par réparation :</strong>
                    <span class="badge bg-primary">
                        @if($reparationsThisMonth > 0)
                        {{ round($dureeTotaleMois / $reparationsThisMonth) }} min
                        @else
                        N/A
                        @endif
                    </span>
                </p>
            </div>
        </div>

        @if($technicienPlusOccupe)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0"><i class="bi bi-person-badge"></i> Technicien top</h5>
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <strong>{{ $technicienPlusOccupe->prenom }} {{ $technicienPlusOccupe->nom }}</strong><br>
                    <small class="text-muted">{{ $technicienPlusOccupe->specialite ?? 'N/A' }}</small>
                </p>
                <p class="mb-0">
                    <span class="badge bg-success">{{ $technicienPlusOccupe->reparations_count }} réparations</span>
                </p>
            </div>
        </div>
        @endif

        @if($vehiculeLesPlusRepare)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0"><i class="bi bi-car-front"></i> Véhicule fréquent</h5>
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <strong>{{ $vehiculeLesPlusRepare->immatriculation }}</strong><br>
                    <small class="text-muted">{{ $vehiculeLesPlusRepare->marque }} {{ $vehiculeLesPlusRepare->modele }}</small>
                </p>
                <p class="mb-0">
                    <span class="badge bg-warning">{{ $vehiculeLesPlusRepare->reparations_count }} réparations</span>
                </p>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Graphiques -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Réparations par mois</h5>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 250px;">
                    <canvas id="moisChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Réparations par technicien</h5>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 250px;">
                    <canvas id="technicienChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php
$moisLabels = json_encode(array_keys($reparationsParMois ?? []));
$moisData = json_encode(array_values($reparationsParMois ?? []));
$technicienLabels = json_encode(array_keys($reparationsParTechnicien ?? []));
$technicienData = json_encode(array_values($reparationsParTechnicien ?? []));
$hasTechnicien = !empty($reparationsParTechnicien);
?>
<script>
    // Données préparées en PHP
    var moisLabels = <?php echo $moisLabels; ?>;
    var moisData = <?php echo $moisData; ?>;
    var technicienLabels = <?php echo $technicienLabels; ?>;
    var technicienData = <?php echo $technicienData; ?>;
    var hasTechnicien = <?php echo json_encode($hasTechnicien); ?>;

    document.addEventListener('DOMContentLoaded', function() {
        // Graphique réparations par mois
        var moisCtx = document.getElementById('moisChart');
        if (moisCtx) {
            new Chart(moisCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: moisLabels,
                    datasets: [{
                        label: 'Réparations',
                        data: moisData,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
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
                            max: (moisData.length > 0 ? Math.max.apply(null, moisData) : 10) + 2
                        }
                    }
                }
            });
        }

        // Graphique réparations par technicien
        if (hasTechnicien) {
            var technicienCtx = document.getElementById('technicienChart');
            if (technicienCtx) {
                new Chart(technicienCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: technicienLabels,
                        datasets: [{
                            data: technicienData,
                            backgroundColor: [
                                '#0d6efd',
                                '#28a745',
                                '#ffc107',
                                '#17a2b8',
                                '#dc3545',
                                '#6f42c1'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        }
    });
</script>
@endsection