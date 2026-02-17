@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold"><i class="bi bi-car-front"></i> Gestion des Véhicules</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.vehicules.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouveau Véhicule
            </a>
        </div>
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Marque</th>
                            <th>Modèle</th>
                            <th>Plaque</th>
                            <th>Client</th>
                            <th>Année</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vehicules as $vehicule)
                        <tr>
                            <td><strong>{{ $vehicule->marque }}</strong></td>
                            <td>{{ $vehicule->modele }}</td>
                            <td><code>{{ $vehicule->plaque_immatriculation }}</code></td>
                            <td>{{ $vehicule->client->utilisateur->nom_complet }}</td>
                            <td>{{ $vehicule->annee }}</td>
                            <td>
                                <a href="{{ route('admin.vehicules.show', $vehicule) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Voir
                                </a>
                                <a href="{{ route('admin.vehicules.edit', $vehicule) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Éditer
                                </a>
                                <form action="{{ route('admin.vehicules.destroy', $vehicule) }}" method="POST" style="display:inline;">
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
                            <td colspan="6" class="text-center text-muted py-4">Aucun véhicule trouvé</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $vehicules->links() }}
    </div>
</div>
@endsection