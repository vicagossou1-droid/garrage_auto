@extends('app')

@section('title', 'Liste des Techniciens')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-person-badge"></i> Techniciens</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('techniciens.export') }}" class="btn btn-success">
            <i class="bi bi-download"></i> Exporter en CSV
        </a>
        <a href="{{ route('techniciens.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Ajouter un technicien
        </a>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Spécialité</th>
                    <th>Nombre de réparations</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($techniciens as $technicien)
                <tr>
                    <td>{{ $technicien->nom }}</td>
                    <td>{{ $technicien->prenom }}</td>
                    <td>{{ $technicien->specialite ?? '-' }}</td>
                    <td>
                        <span class="badge bg-secondary">
                            {{ $technicien->reparations_count ?? $technicien->reparations()->count() }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('techniciens.show', $technicien) }}" class="btn btn-info btn-sm" title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('techniciens.edit', $technicien) }}" class="btn btn-warning btn-sm" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('techniciens.destroy', $technicien) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Supprimer" onclick="return confirm('Êtes-vous sûr?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Aucun technicien trouvé. <a href="{{ route('techniciens.create') }}">Créer le premier</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $techniciens->links() }}
</div>
@endsection