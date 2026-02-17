@extends('app')

@section('title', 'Liste des Réparations')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-tools"></i> Réparations</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('reparations.export') }}" class="btn btn-success">
            <i class="bi bi-download"></i> Exporter en CSV
        </a>
        <a href="{{ route('reparations.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Ajouter une réparation
        </a>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Véhicule (Immatriculation)</th>
                    <th>Technicien</th>
                    <th>Objet de la réparation</th>
                    <th>Date</th>
                    <th>Durée (min)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reparations as $reparation)
                <tr>
                    <td>
                        <a href="{{ route('vehicules.show', $reparation->vehicule) }}">
                            {{ $reparation->vehicule->immatriculation }}
                        </a>
                    </td>
                    <td>
                        @if($reparation->technicien)
                        <a href="{{ route('techniciens.show', $reparation->technicien) }}">
                            {{ $reparation->technicien->prenom }} {{ $reparation->technicien->nom }}
                        </a>
                        @else
                        <span class="text-muted">Non assigné</span>
                        @endif
                    </td>
                    <td>{{ Str::limit($reparation->objet_reparation, 50) }}</td>
                    <td>{{ $reparation->date->format('d/m/Y') }}</td>
                    <td>{{ $reparation->duree_main_oeuvre ?? '-' }}</td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('reparations.show', $reparation) }}" class="btn btn-info btn-sm" title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('reparations.edit', $reparation) }}" class="btn btn-warning btn-sm" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('reparations.destroy', $reparation) }}" method="POST" style="display:inline;">
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
                    <td colspan="6" class="text-center text-muted py-4">
                        Aucune réparation trouvée. <a href="{{ route('reparations.create') }}">Créer la première</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $reparations->links() }}
</div>
@endsection