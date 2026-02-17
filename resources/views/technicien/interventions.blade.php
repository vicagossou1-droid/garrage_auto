@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold">
                        <i class="bi bi-tools"></i> Toutes Mes Interventions
                    </h2>
                    <p class="text-muted">Total: {{ $interventions->total() }} interventions</p>
                </div>
                <a href="{{ route('technicien.dashboard') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Retour au Tableau de Bord
                </a>
            </div>
        </div>
    </div>

    <!-- Interventions Table -->
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-list-check"></i> Interventions
            </h5>
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
                            <td>
                                <strong>{{ $intervention->reparation->client->utilisateur->nom_complet }}</strong><br>
                                <small class="text-muted">{{ $intervention->reparation->client->utilisateur->telephone ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <small>{{ substr($intervention->reparation->description_panne, 0, 50) }}...</small>
                            </td>
                            <td>
                                <strong>{{ $intervention->created_at->format('d/m/Y') }}</strong><br>
                                <small class="text-muted">{{ $intervention->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                @if ($intervention->duree_minutes)
                                <strong>{{ intdiv($intervention->duree_minutes, 60) }}h {{ $intervention->duree_minutes % 60 }}m</strong>
                                @else
                                <span class="text-muted">À déterminer</span>
                                @endif
                            </td>
                            <td>
                                @php
                                $statut = $intervention->reparation->statut ?? 'assignee';
                                @endphp

                                @if ($statut === 'assignee')
                                <form action="{{ route('technicien.reparations.start', $intervention->reparation->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" title="Démarrer la réparation">
                                        <i class="bi bi-play-fill"></i> Démarrer
                                    </button>
                                </form>
                                @elseif ($statut === 'en_cours')
                                <form action="{{ route('technicien.reparations.complete', $intervention->reparation->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary" title="Marquer comme terminé">
                                        <i class="bi bi-check-circle"></i> Terminer
                                    </button>
                                </form>
                                @else
                                <span class="badge bg-success">
                                    <i class="bi bi-check-all"></i> Terminée
                                </span>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Détails Intervention -->
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
                                                    <strong>Année:</strong> {{ $intervention->reparation->vehicule->annee }}
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="fw-bold text-primary mb-3">Informations Client</h6>
                                                <p>
                                                    <strong>Nom:</strong> {{ $intervention->reparation->client->utilisateur->nom_complet }}<br>
                                                    <strong>Email:</strong> {{ $intervention->reparation->client->utilisateur->email }}<br>
                                                    <strong>Tél:</strong> {{ $intervention->reparation->client->utilisateur->telephone ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                        <h6 class="fw-bold text-primary mb-3">Panne Signalée</h6>
                                        <p>{{ $intervention->reparation->description_panne }}</p>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold text-primary mb-3">Date Assignation</h6>
                                                <p>{{ $intervention->created_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="fw-bold text-primary mb-3">Durée Prévue</h6>
                                                <p>
                                                    @if ($intervention->duree_minutes)
                                                    {{ intdiv($intervention->duree_minutes, 60) }}h {{ $intervention->duree_minutes % 60 }}m
                                                    @else
                                                    À déterminer
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="fw-bold text-primary mb-3">Statut Actuel</h6>
                                                <p>
                                                    @php
                                                    $statutBadgeClass = match($statut) {
                                                    'assignee' => 'bg-warning text-dark',
                                                    'en_cours' => 'bg-info',
                                                    'termine' => 'bg-success',
                                                    default => 'bg-secondary'
                                                    };
                                                    $statutLabel = match($statut) {
                                                    'assignee' => 'Assignée',
                                                    'en_cours' => 'En cours',
                                                    'termine' => 'Terminée',
                                                    default => 'Unknown'
                                                    };
                                                    @endphp
                                                    <span class="badge {{ $statutBadgeClass }}">{{ $statutLabel }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        @if ($statut === 'assignee')
                                        <form action="{{ route('technicien.reparations.start', $intervention->reparation->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-play-fill"></i> Démarrer la Réparation
                                            </button>
                                        </form>
                                        @elseif ($statut === 'en_cours')
                                        <form action="{{ route('technicien.reparations.complete', $intervention->reparation->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-check-circle"></i> Terminer la Réparation
                                            </button>
                                        </form>
                                        @endif
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox"></i> Aucune intervention assignée
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($interventions->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $interventions->links() }}
    </div>
    @endif
</div>
@endsection