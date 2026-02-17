@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold"><i class="bi bi-tools"></i> Gestion des Techniciens</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.techniciens.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouveau Technicien
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
                            <th>Spécialité</th>
                            <th>Email</th>
                            <th>Taux Horaire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($techniciens as $technicien)
                        <tr>
                            <td><strong>{{ $technicien->utilisateur->nom_complet }}</strong></td>
                            <td>{{ $technicien->specialite ?? 'N/A' }}</td>
                            <td>{{ $technicien->utilisateur->email }}</td>
                            <td>{{ $technicien->taux_horaire }} XOF/h</td>
                            <td>
                                <a href="{{ route('admin.techniciens.show', $technicien) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Voir
                                </a>
                                <a href="{{ route('admin.techniciens.edit', $technicien) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Éditer
                                </a>
                                <form action="{{ route('admin.techniciens.destroy', $technicien) }}" method="POST" style="display:inline;">
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
                            <td colspan="5" class="text-center text-muted py-4">Aucun technicien trouvé</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $techniciens->links() }}
    </div>
</div>
@endsection