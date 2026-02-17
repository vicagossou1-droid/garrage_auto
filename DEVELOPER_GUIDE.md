# 🛠️ Guide Développeur - Étendre le Projet

## 📖 Pour les Développeurs

Ce guide montre comment ajouter de nouvelles fonctionnalités au projet.

---

## 🎯 Ajouter une Nouvelle Entité (Exemple: Pièces Détachées)

### Étape 1 : Créer la Migration

```bash
php artisan make:migration create_pieces_table
```

Éditer le fichier généré dans `database/migrations/` :

```php
// database/migrations/2026_01_15_000005_create_pieces_table.php

public function up(): void
{
    Schema::create('pieces', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->string('reference')->unique();
        $table->text('description')->nullable();
        $table->decimal('prix', 8, 2);
        $table->integer('quantite')->default(0);
        $table->foreignId('reparation_id')->nullable()->constrained('reparations')->onDelete('set null');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('pieces');
}
```

---

### Étape 2 : Créer le Modèle

```bash
php artisan make:model Piece
```

Éditer `app/Models/Piece.php` :

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    protected $table = 'pieces';
    protected $fillable = [
        'nom',
        'reference',
        'description',
        'prix',
        'quantite',
        'reparation_id'
    ];

    // Relations
    public function reparation()
    {
        return $this->belongsTo(Reparation::class);
    }

    // Ajouter trait si besoin de recherche
    use \App\Traits\Searchable;
}
```

Mettre à jour `app/Models/Reparation.php` :

```php
// Ajouter dans la classe Reparation
public function pieces()
{
    return $this->hasMany(Piece::class);
}
```

---

### Étape 3 : Créer le Contrôleur

```bash
php artisan make:controller Pieces/PieceController -r
```

Éditer `app/Http/Controllers/Pieces/PieceController.php` :

```php
namespace App\Http\Controllers\Pieces;

use App\Models\Piece;
use App\Models\Reparation;
use Illuminate\Http\Request;

class PieceController extends Controller
{
    public function index()
    {
        $pieces = Piece::paginate(10);
        return view('pieces.index', compact('pieces'));
    }

    public function create()
    {
        $reparations = Reparation::all();
        return view('pieces.create', compact('reparations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'reference' => 'required|unique:pieces',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'quantite' => 'required|integer|min:0',
            'reparation_id' => 'nullable|exists:reparations,id'
        ]);

        Piece::create($validated);

        return redirect()->route('pieces.index')
            ->with('success', 'Pièce créée avec succès');
    }

    public function show(Piece $piece)
    {
        return view('pieces.show', compact('piece'));
    }

    public function edit(Piece $piece)
    {
        $reparations = Reparation::all();
        return view('pieces.edit', compact('piece', 'reparations'));
    }

    public function update(Request $request, Piece $piece)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'reference' => 'required|unique:pieces,reference,' . $piece->id,
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'quantite' => 'required|integer|min:0',
            'reparation_id' => 'nullable|exists:reparations,id'
        ]);

        $piece->update($validated);

        return redirect()->route('pieces.show', $piece)
            ->with('success', 'Pièce modifiée avec succès');
    }

    public function destroy(Piece $piece)
    {
        $piece->delete();

        return redirect()->route('pieces.index')
            ->with('success', 'Pièce supprimée avec succès');
    }
}
```

---

### Étape 4 : Ajouter les Routes

Éditer `routes/web.php` :

```php
use App\Http\Controllers\Pieces\PieceController;

Route::resource('pieces', PieceController::class);
```

---

### Étape 5 : Créer les Vues

#### `resources/views/pieces/index.blade.php`

```blade
@extends('app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>📦 Pièces Détachées</h1>
        <a href="{{ route('pieces.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Créer
        </a>
    </div>

    @if ($pieces->count())
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Référence</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Réparation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pieces as $piece)
                <tr>
                    <td>{{ $piece->nom }}</td>
                    <td><code>{{ $piece->reference }}</code></td>
                    <td>{{ number_format($piece->prix, 2) }} €</td>
                    <td>{{ $piece->quantite }}</td>
                    <td>
                        @if ($piece->reparation)
                            <a href="{{ route('reparations.show', $piece->reparation) }}">
                                Réparation #{{ $piece->reparation->id }}
                            </a>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('pieces.edit', $piece) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Éditer
                        </a>
                        <form method="POST" action="{{ route('pieces.destroy', $piece) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Confirmer ?')">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $pieces->links() }}
    @else
        <div class="alert alert-info">Aucune pièce trouvée.</div>
    @endif
</div>
@endsection
```

#### `resources/views/pieces/create.blade.php`

```blade
@extends('app')

@section('content')
<div class="container mt-4">
    <h1>📦 Créer une Pièce Détachée</h1>

    <form method="POST" action="{{ route('pieces.store') }}" class="mt-4">
        @csrf

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" 
                   value="{{ old('nom') }}" required>
            @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="reference" class="form-label">Référence</label>
            <input type="text" name="reference" class="form-control @error('reference') is-invalid @enderror" 
                   value="{{ old('reference') }}" required>
            @error('reference') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix (€)</label>
            <input type="number" name="prix" step="0.01" class="form-control @error('prix') is-invalid @enderror" 
                   value="{{ old('prix') }}" required>
            @error('prix') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="quantite" class="form-label">Quantité</label>
            <input type="number" name="quantite" class="form-control @error('quantite') is-invalid @enderror" 
                   value="{{ old('quantite', 0) }}" required>
            @error('quantite') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="reparation_id" class="form-label">Réparation (optionnel)</label>
            <select name="reparation_id" class="form-select">
                <option value="">-- Sélectionner --</option>
                @foreach ($reparations as $reparation)
                <option value="{{ $reparation->id }}">Réparation #{{ $reparation->id }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
        <a href="{{ route('pieces.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
```

Similar pour `edit.blade.php` et `show.blade.php`

---

### Étape 6 : Ajouter au Seeder

Créer : `database/seeders/PieceSeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Models\Piece;
use Illuminate\Database\Seeder;

class PieceSeeder extends Seeder
{
    public function run(): void
    {
        Piece::create([
            'nom' => 'Plaquettes de frein',
            'reference' => 'PF-001',
            'description' => 'Plaquettes avant haute qualité',
            'prix' => 45.99,
            'quantite' => 10,
            'reparation_id' => 1
        ]);

        Piece::create([
            'nom' => 'Filtre à air',
            'reference' => 'FA-002',
            'description' => 'Filtre à air moteur',
            'prix' => 12.50,
            'quantite' => 25,
            'reparation_id' => 2
        ]);

        // Ajouter d'autres pièces...
    }
}
```

Mettre à jour `DatabaseSeeder.php` :

```php
public function run(): void
{
    $this->call([
        VehiculeSeeder::class,
        TechnicienSeeder::class,
        ReparationSeeder::class,
        PieceSeeder::class,  // ← Ajouter
    ]);
}
```

---

### Étape 7 : Ajouter au Layout

Éditer `resources/views/app.blade.php` :

```blade
<li class="nav-item">
    <a class="nav-link" href="{{ route('pieces.index') }}">
        <i class="bi bi-cube"></i> Pièces
    </a>
</li>
```

---

### Étape 8 : Exécuter les Migrations

```bash
php artisan migrate
php artisan db:seed --class=PieceSeeder

# Ou réinitialiser completement
php artisan migrate:refresh --seed
```

---

## 📝 Ajouter une Fonctionnalité de Recherche

Pour le modèle `Piece`, utiliser le trait `Searchable` :

```php
// Dans app/Models/Piece.php
use \App\Traits\Searchable;

class Piece extends Model
{
    use Searchable;
    // ...
}
```

Dans le contrôleur :

```php
public function index(Request $request)
{
    $search = $request->input('search');
    $pieces = Piece::search($search, ['nom', 'reference'])
                   ->paginate(10);
    
    return view('pieces.index', compact('pieces'));
}
```

Dans la vue :

```blade
<form method="GET" action="{{ route('pieces.index') }}" class="mb-3">
    <input type="text" name="search" placeholder="Rechercher..." 
           value="{{ request('search') }}" class="form-control">
    <button type="submit" class="btn btn-primary mt-2">Rechercher</button>
</form>
```

---

## 💾 Ajouter un Export CSV

Ajouter dans `app/Services/ExportService.php` :

```php
public static function exportPiecesCSV($pieces)
{
    $headers = ['ID', 'Nom', 'Référence', 'Prix', 'Quantité', 'Créé le'];
    
    $csv = implode(',', array_map(function($h) {
        return '"' . str_replace('"', '""', $h) . '"';
    }, $headers)) . "\n";
    
    foreach ($pieces as $piece) {
        $row = [
            $piece->id,
            $piece->nom,
            $piece->reference,
            $piece->prix,
            $piece->quantite,
            $piece->created_at
        ];
        
        $csv .= implode(',', array_map(function($v) {
            return '"' . str_replace('"', '""', $v) . '"';
        }, $row)) . "\n";
    }
    
    return $csv;
}
```

Dans le contrôleur :

```php
use App\Services\ExportService;

public function exportCSV()
{
    $pieces = Piece::all();
    $csv = ExportService::exportPiecesCSV($pieces);
    
    return response($csv, 200, [
        'Content-Type' => 'text/csv; charset=utf-8',
        'Content-Disposition' => 'attachment; filename="pieces_' . now()->format('Y-m-d_His') . '.csv"',
    ]);
}
```

Dans les routes :

```php
Route::get('/pieces/export/csv', [PieceController::class, 'exportCSV']);
```

---

## 🧪 Ajouter des Tests

```bash
php artisan make:test PieceTest --unit
php artisan make:test PieceFeatureTest --feature
```

Tests unitaires `tests/Unit/PieceTest.php` :

```php
<?php

namespace Tests\Unit;

use App\Models\Piece;
use Tests\TestCase;

class PieceTest extends TestCase
{
    public function test_piece_can_be_created()
    {
        $piece = Piece::create([
            'nom' => 'Test',
            'reference' => 'TEST-001',
            'prix' => 10.00,
            'quantite' => 5
        ]);

        $this->assertDatabaseHas('pieces', [
            'nom' => 'Test'
        ]);
    }
}
```

Exécuter les tests :

```bash
php artisan test
```

---

## 🎨 Ajouter une Relation Many-to-Many

Exemple : Relier Pièces à Réparations (plusieurs pièces par réparation) :

### Créer la table pivot

```bash
php artisan make:migration create_piece_reparation_table
```

```php
public function up(): void
{
    Schema::create('piece_reparation', function (Blueprint $table) {
        $table->id();
        $table->foreignId('piece_id')->constrained('pieces')->onDelete('cascade');
        $table->foreignId('reparation_id')->constrained('reparations')->onDelete('cascade');
        $table->integer('quantite_utilisee')->default(1);
        $table->timestamps();
        
        $table->unique(['piece_id', 'reparation_id']);
    });
}
```

### Mettre à jour les modèles

```php
// Dans Piece
public function reparations()
{
    return $this->belongsToMany(Reparation::class)
                ->withPivot('quantite_utilisee')
                ->withTimestamps();
}

// Dans Reparation
public function pieces()
{
    return $this->belongsToMany(Piece::class)
                ->withPivot('quantite_utilisee')
                ->withTimestamps();
}
```

### Utilisation

```php
// Attacher une pièce à une réparation
$reparation->pieces()->attach($piece->id, ['quantite_utilisee' => 2]);

// Récupérer toutes les pièces d'une réparation
$reparation->pieces;

// Détacher
$reparation->pieces()->detach($piece->id);
```

---

## 🚀 Bonnes Pratiques

### 1. Toujours Valider les Données

```php
$validated = $request->validate([
    'nom' => 'required|string|max:255',
    'prix' => 'required|numeric|min:0|max:999999.99',
]);
```

### 2. Utiliser les Relations Eloquent

```php
// ✅ Bien
$piece->reparation->date_reparation;

// ❌ Mauvais
Reparation::find($piece->reparation_id)->date_reparation;
```

### 3. Utiliser Eager Loading

```php
// ✅ Évite N+1 problem
$pieces = Piece::with('reparation')->paginate(10);

// ❌ Provoque N+1 queries
$pieces = Piece::paginate(10);
foreach ($pieces as $piece) {
    echo $piece->reparation->id;  // Query à chaque itération!
}
```

### 4. Utiliser les Collections pour Filtrer

```php
// ✅ Bon
$pieces = Piece::where('prix', '>', 10)->get();

// ❌ Mauvais (charge tout en mémoire)
$pieces = Piece::all()->where('prix', '>', 10);
```

### 5. Toujours Ajouter des Messages de Feedback

```php
return redirect()->route('pieces.index')
    ->with('success', 'Pièce créée avec succès');
```

---

## 🔐 Sécurité

### 1. Validation des Identifiants

```php
// ✅ Bien (constraint en BD)
$piece = Piece::findOrFail($id);

// ❌ Mauvais (peut planter)
$piece = Piece::find($id);
if (!$piece) return error;
```

### 2. Autorisation

```php
// Ajouter dans le contrôleur
$this->authorize('update', $piece);

// Ou dans les policies
php artisan make:policy PiecePolicy --model=Piece
```

### 3. CSRF Protection

```blade
<!-- Automatique dans les formulaires -->
<form method="POST">
    @csrf
</form>
```

---

## 📚 Ressources

- [Laravel Models](https://laravel.com/docs/eloquent)
- [Laravel Migrations](https://laravel.com/docs/migrations)
- [Laravel Controllers](https://laravel.com/docs/controllers)
- [Laravel Validation](https://laravel.com/docs/validation)
- [Laravel Testing](https://laravel.com/docs/testing)

---

**Prêt à étendre le projet ! 🚀**
