@extends('app')

@section('title', 'Liste des Véhicules')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-car-front"></i> Véhicules</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('vehicules.export') }}" class="btn btn-success">
            <i class="bi bi-download"></i> Exporter en CSV
        </a>
        <a href="{{ route('vehicules.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Ajouter un véhicule
        </a>
    </div>
</div>

<!-- Recherche et filtres -->
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('vehicules.index') }}" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Rechercher..."
                    value="{{ $search ?? '' }}">
            </div>
            <div class="col-md-3">
                <select name="marque" class="form-control">
                    <option value="">Tous les marques</option>
                    @foreach($marques as $m)
                    <option value="{{ $m }}" {{ ($marque ?? '') === $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="energie" class="form-control">
                    <option value="">Tous les énergies</option>
                    @foreach($energies as $e)
                    <option value="{{ $e }}" {{ ($energie ?? '') === $e ? 'selected' : '' }}>{{ $e }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filtrer
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Immatriculation</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Couleur</th>
                    <th>Année</th>
                    <th>Kilométrage</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicules as $vehicule)
                <tr>
                    <td>
                        <strong>{{ $vehicule->immatriculation }}</strong>
                    </td>
                    <td>{{ $vehicule->marque ?? '-' }}</td>
                    <td>{{ $vehicule->modele ?? '-' }}</td>
                    <td>{{ $vehicule->couleur ?? '-' }}</td>
                    <td>{{ $vehicule->annee ?? '-' }}</td>
                    <td>{{ $vehicule->kilometrage ? number_format($vehicule->kilometrage, 0, ',', ' ') . ' km' : '-' }}</td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('vehicules.show', $vehicule) }}" class="btn btn-info btn-sm" title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('vehicules.edit', $vehicule) }}" class="btn btn-warning btn-sm" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('vehicules.destroy', $vehicule) }}" method="POST" style="display:inline;">
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
                    <td colspan="7" class="text-center text-muted py-4">
                        Aucun véhicule trouvé. <a href="{{ route('vehicules.create') }}">Créer le premier</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $vehicules->links() }}
</div>
@endsection