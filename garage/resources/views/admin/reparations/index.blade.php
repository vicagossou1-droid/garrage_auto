@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold"><i class="bi bi-wrench"></i> Gestion des Réparations</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.reparations.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouvelle Réparation
            </a>
        </div>
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Véhicule</th>
                            <th>Client</th>
                            <th>Statut</th>
                            <th>Date Début</th>
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
                            <td>{{ $reparation->client->utilisateur->nom_complet }}</td>
                            <td>
                                <span class="badge bg-{{ $reparation->statut === 'en_attente' ? 'info' : ($reparation->statut === 'en_cours' ? 'warning' : ($reparation->statut === 'termine' ? 'success' : 'primary')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $reparation->statut)) }}
                                </span>
                            </td>
                            <td>{{ $reparation->date_depot->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.reparations.show', $reparation) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Voir
                                </a>
                                <a href="{{ route('admin.reparations.edit', $reparation) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Éditer
                                </a>
                                <form action="{{ route('admin.reparations.destroy', $reparation) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Aucune réparation trouvée</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $reparations->links() }}
    </div>
</div>
@endsection