@extends('layouts.app')

@section('content')
<style>
    .stat-card {
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15) !important;
    }
</style>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">
                <i class="bi bi-tools"></i> Mon Tableau de Bord Technicien
            </h2>
            <p class="text-muted">Bienvenue, {{ auth()->user()->nom_complet }}</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <a href="{{ route('technicien.interventions') }}" class="text-decoration-none">
                <div class="card shadow-lg h-100 stat-card" style="cursor: pointer; transition: all 0.3s ease;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted">Total Interventions</p>
                                <h3 class="fw-bold">{{ $statistiques['interventions_total'] }}</h3>
                            </div>
                            <i class="bi bi-wrench-adjustable display-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted">Heures Travaillées</p>
                            <h3 class="fw-bold">{{ number_format($statistiques['heures_travaillees'], 1) }}h</h3>
                        </div>
                        <i class="bi bi-clock-history display-4 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <a href="{{ route('technicien.reparations-assignees') }}" class="text-decoration-none">
                <div class="card shadow-lg h-100 stat-card" style="cursor: pointer; transition: all 0.3s ease;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted">Réparations Assignées</p>
                                <h3 class="fw-bold">{{ $statistiques['reparations_assignees'] }}</h3>
                            </div>
                            <i class="bi bi-tools display-4 text-warning"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Interventions -->
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Mes Interventions</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Véhicule</th>
                            <th>Client</th>
                            <th>Panne</th>
                            <th>Date Début</th>
                            <th>Durée</th>
                            <th>Coût</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($interventions as $intervention)
                        <tr>
                            <td>
                                <strong>{{ $intervention->reparation->vehicule->marque }} {{ $intervention->reparation->vehicule->modele }}</strong><br>
                                <small class="text-muted">{{ $intervention->reparation->vehicule->plaque_immatriculation }}</small>
                            </td>
                            <td>{{ $intervention->reparation->client->utilisateur->nom_complet }}</td>
                            <td>
                                <small>{{ substr($intervention->reparation->description_panne, 0, 40) }}...</small>
                            </td>
                            <td>{{ $intervention->date_debut ? $intervention->date_debut->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                @if ($intervention->duree_minutes)
                                {{ intdiv($intervention->duree_minutes, 60) }}h {{ $intervention->duree_minutes % 60 }}m
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($intervention->cout_intervention)
                                {{ number_format($intervention->cout_intervention, 2, '.', ' ') }} XOF
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#interventionModal{{ $intervention->id }}">
                                    Détails
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox"></i> Aucune intervention assignée
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modales Détails Intervention -->
    @forelse ($interventions as $intervention)
    <div class="modal fade" id="interventionModal{{ $intervention->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Détails de l'Intervention</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">Informations Véhicule</h6>
                            <p>
                                <strong>Marque:</strong> {{ $intervention->reparation->vehicule->marque }}<br>
                                <strong>Modèle:</strong> {{ $intervention->reparation->vehicule->modele }}<br>
                                <strong>Plaque:</strong> {{ $intervention->reparation->vehicule->plaque_immatriculation }}<br>
                                <strong>Année:</strong> {{ $intervention->reparation->vehicule->annee }}<br>
                                <strong>Couleur:</strong> {{ $intervention->reparation->vehicule->couleur }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">Informations Client</h6>
                            <p>
                                <strong>Nom:</strong> {{ $intervention->reparation->client->utilisateur->nom_complet }}<br>
                                <strong>Téléphone:</strong> {{ $intervention->reparation->client->utilisateur->telephone }}<br>
                                <strong>Email:</strong> {{ $intervention->reparation->client->utilisateur->email }}<br>
                                <strong>Adresse:</strong> {{ $intervention->reparation->client->utilisateur->adresse }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">Panne & Réparation</h6>
                            <p>
                                <strong>Description Panne:</strong><br>
                                {{ $intervention->reparation->description_panne }}<br><br>
                                <strong>Statut:</strong>
                                <span class="badge
                                    @if($intervention->reparation->statut == 'en_attente') bg-warning
                                    @elseif($intervention->reparation->statut == 'en_cours') bg-info
                                    @elseif($intervention->reparation->statut == 'termine') bg-success
                                    @elseif($intervention->reparation->statut == 'livree') bg-primary
                                    @else bg-secondary
                                    @endif
                                ">
                                    {{ ucfirst(str_replace('_', ' ', $intervention->reparation->statut)) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">Détails Intervention</h6>
                            <p>
                                <strong>Date Début:</strong> {{ $intervention->date_debut ? $intervention->date_debut->format('d/m/Y H:i') : 'Non définie' }}<br>
                                <strong>Date Fin:</strong> {{ $intervention->date_fin ? $intervention->date_fin->format('d/m/Y H:i') : 'Non terminée' }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <!-- Formulaire éditable pour la durée -->
                    <h6 class="fw-bold text-primary mb-3">Modifier la Durée & le Coût</h6>
                    <form action="{{ route('technicien.interventions.updateDuration', $intervention->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-3">
                                <label for="heures{{ $intervention->id }}" class="form-label">Heures</label>
                                <input type="number" id="heures{{ $intervention->id }}" name="heures" class="form-control"
                                    value="{{ intdiv($intervention->duree_minutes ?? 0, 60) }}" min="0" required>
                            </div>
                            <div class="col-md-3">
                                <label for="minutes{{ $intervention->id }}" class="form-label">Minutes</label>
                                <input type="number" id="minutes{{ $intervention->id }}" name="minutes" class="form-control"
                                    value="{{ ($intervention->duree_minutes ?? 0) % 60 }}" min="0" max="59" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cout{{ $intervention->id }}" class="form-label">Coût Intervention (XOF)</label>
                                <input type="number" id="cout{{ $intervention->id }}" name="cout_intervention" class="form-control"
                                    value="{{ $intervention->cout_intervention ?? '' }}" min="0" step="0.01" placeholder="Ex: 50000">
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-check-lg"></i> Enregistrer
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    @empty
    @endforelse

    @if ($interventions->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $interventions->links() }}
    </div>
    @endif
</div>

<!-- Quick Start Timer -->
<div class="position-fixed bottom-0 end-0 p-4">
    <div class="card shadow-lg" style="width: 300px;">
        <div class="card-body text-center">
            <h5>Chronomètre</h5>
            <div class="display-6 font-monospace mb-3">
                <span id="timer">00:00:00</span>
            </div>
            <div class="btn-group w-100" role="group">
                <button type="button" class="btn btn-sm btn-success" onclick="startTimer()">
                    <i class="bi bi-play-fill"></i>
                </button>
                <button type="button" class="btn btn-sm btn-warning" onclick="pauseTimer()">
                    <i class="bi bi-pause-fill"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="resetTimer()">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let timerInterval;
    let seconds = 0;

    function updateDisplay() {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const secs = seconds % 60;

        document.getElementById('timer').textContent =
            String(hours).padStart(2, '0') + ':' +
            String(minutes).padStart(2, '0') + ':' +
            String(secs).padStart(2, '0');
    }

    function startTimer() {
        if (!timerInterval) {
            timerInterval = setInterval(() => {
                seconds++;
                updateDisplay();
            }, 1000);
        }
    }

    function pauseTimer() {
        clearInterval(timerInterval);
        timerInterval = null;
    }

    function resetTimer() {
        pauseTimer();
        seconds = 0;
        updateDisplay();
    }
</script>
@endsection