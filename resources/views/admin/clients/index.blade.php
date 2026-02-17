@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold"><i class="bi bi-people"></i> Gestion des Clients</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouveau Client
            </a>
        </div>
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Véhicules</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                        <tr>
                            <td><strong>{{ $client->utilisateur->nom_complet }}</strong></td>
                            <td>{{ $client->utilisateur->email }}</td>
                            <td>{{ $client->utilisateur->telephone ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $client->vehicules->count() }} véhicule(s)</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.clients.show', $client) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Voir
                                </a>
                                <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Éditer
                                </a>
                                <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" style="display:inline;">
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
                            <td colspan="5" class="text-center text-muted py-4">Aucun client trouvé</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $clients->links() }}
    </div>
</div>
@endsection