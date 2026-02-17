# 📁 Structure du Projet - Guide Complet

## 🌳 Arborescence du Projet

```
garage_auto/
│
├── 📄 QUICKSTART.md              ⭐ Lire en premier !
├── 📄 FEATURES.md                Fonctionnalités détaillées
├── 📄 API_ROUTES.md              Routes et endpoints
├── 📄 DEPLOYMENT.md              Guide de déploiement
├── 📄 README.md                  Documentation officielle
│
├── 📂 app/                       Code de l'application
│   ├── 📂 Http/
│   │   └── 📂 Controllers/       Contrôleurs (logique métier)
│   │       ├── 📂 Dashboard/
│   │       │   └── DashboardController.php        ✨ Nouveau
│   │       ├── 📂 Vehicules/
│   │       │   └── VehiculeController.php         ✨ Amélioré
│   │       ├── 📂 Techniciens/
│   │       │   └── TechnicienController.php       ✨ Amélioré
│   │       └── 📂 Reparations/
│   │           └── ReparationController.php       ✨ Amélioré
│   │
│   ├── 📂 Models/                Modèles Eloquent
│   │   ├── Vehicule.php          Modèle véhicule (hasMany reparations)
│   │   ├── Technicien.php        Modèle technicien (hasMany reparations)
│   │   └── Reparation.php        Modèle réparation (belongsTo vehicule, technicien)
│   │
│   ├── 📂 Services/              Services métier ✨ Nouveau
│   │   └── ExportService.php     Génération CSV pour export
│   │
│   ├── 📂 Traits/                Traits réutilisables ✨ Nouveau
│   │   └── Searchable.php        Search et filter generiques
│   │
│   └── 📂 Providers/
│       └── AppServiceProvider.php Configuration app
│
├── 📂 bootstrap/                 Bootstrap Laravel
│   ├── app.php                   Application instance
│   └── 📂 cache/                 Cache compilé
│
├── 📂 config/                    Configuration
│   ├── app.php                   Configuration générale
│   ├── auth.php                  Configuration authentification
│   ├── cache.php                 Configuration cache
│   ├── database.php              Configuration base de données
│   └── ... (autres configs)
│
├── 📂 database/                  Base de données
│   ├── 📂 migrations/            Schéma de la BD
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_01_15_000000_create_vehicules_table.php
│   │   ├── 2026_01_15_000001_create_techniciens_table.php
│   │   ├── 2026_01_15_000002_create_reparations_table.php
│   │   └── 2026_01_15_000004_add_image_to_vehicules_table.php ✨ Nouveau
│   │
│   ├── 📂 seeders/               Données de test
│   │   ├── DatabaseSeeder.php    Seeder principal
│   │   ├── VehiculeSeeder.php    5 véhicules de test
│   │   ├── TechnicienSeeder.php  5 techniciens de test
│   │   └── ReparationSeeder.php  5 réparations de test
│   │
│   └── 📂 factories/             Factory pour tests
│       └── UserFactory.php
│
├── 📂 public/                    Dossier public (web root)
│   ├── index.php                 Point d'entrée de l'app
│   └── robots.txt                Directives pour les bots
│
├── 📂 resources/                 Ressources (CSS/JS/Vues)
│   ├── 📂 css/
│   │   └── app.css               Styles personnalisés
│   │
│   ├── 📂 js/
│   │   ├── app.js                Point d'entrée JS
│   │   └── bootstrap.js          Bootstrap d'application
│   │
│   └── 📂 views/                 Templates Blade
│       ├── app.blade.php         Layout principal
│       ├── accueil.blade.php     Page d'accueil
│       │
│       ├── 📂 dashboard/         ✨ Nouveau
│       │   └── index.blade.php   Dashboard avec graphiques
│       │
│       ├── 📂 vehicules/         CRUD Véhicules
│       │   ├── index.blade.php   Liste paginée + recherche
│       │   ├── create.blade.php  Formulaire créer
│       │   ├── edit.blade.php    Formulaire éditer
│       │   └── show.blade.php    Détails + historique
│       │
│       ├── 📂 techniciens/       CRUD Techniciens
│       │   ├── index.blade.php   Liste paginée
│       │   ├── create.blade.php  Formulaire créer
│       │   ├── edit.blade.php    Formulaire éditer
│       │   └── show.blade.php    Détails + réparations
│       │
│       └── 📂 reparations/       CRUD Réparations
│           ├── index.blade.php   Liste complète
│           ├── create.blade.php  Formulaire créer
│           ├── edit.blade.php    Formulaire éditer
│           └── show.blade.php    Détails complets
│
├── 📂 routes/                    Définition des routes
│   ├── web.php                   Routes web (ressources + export)
│   └── console.php               Commands Artisan
│
├── 📂 storage/                   Stockage fichiers
│   ├── 📂 app/
│   │   ├── 📂 private/           Fichiers privés
│   │   └── 📂 public/
│   │       └── 📂 vehicules/     Images des véhicules ✨ Nouveau
│   │
│   ├── 📂 framework/
│   │   ├── 📂 cache/             Cache fichiers
│   │   ├── 📂 sessions/          Sessions fichiers
│   │   ├── 📂 testing/           Fichiers tests
│   │   └── 📂 views/             Vues compilées
│   │
│   └── 📂 logs/
│       └── laravel.log           Logs d'application
│
├── 📂 tests/                     Tests unitaires et features
│   ├── Feature/
│   │   └── ExampleTest.php
│   └── Unit/
│       └── ExampleTest.php
│
├── 📂 vendor/                    Dépendances Composer
│   └── autoload.php              Autoload PHP
│
├── .env                          ⚠️ Configuration (NE PAS COMMITER)
├── .env.example                  ✅ Template .env
├── .gitignore                    Fichiers ignorés par Git
├── artisan                       CLI Laravel
├── composer.json                 Dépendances PHP
├── composer.lock                 Versions lockées (commit)
├── package.json                  Dépendances Node.js
├── package-lock.json             Versions lockées (commit)
├── phpunit.xml                   Configuration tests
└── vite.config.js                Configuration Vite (bundler)
```

---

## 🔑 Fichiers Importants

### Configuration
| Fichier | Usage | Modifier ? |
|---------|-------|-----------|
| `.env` | Variables d'environnement | ✅ OUI (local) |
| `.env.example` | Template | ❌ Non |
| `config/app.php` | Config générale | ⚠️ Rarement |
| `config/database.php` | Config BD | ⚠️ Rarement |

### Application
| Fichier | Usage | Modifier ? |
|---------|-------|-----------|
| `routes/web.php` | Routes/ressources | ✅ Pour ajouter features |
| `app/Http/Controllers/` | Logique métier | ✅ Souvent |
| `app/Models/` | Schéma données | ✅ Pour ajouter relations |
| `resources/views/` | Interface utilisateur | ✅ Souvent |

### Base de Données
| Fichier | Usage | Modifier ? |
|---------|-------|-----------|
| `database/migrations/` | Schéma tables | ✅ Pour ajouter colonnes |
| `database/seeders/` | Données initiales | ✅ Pour changer données |

---

## 📊 Dépendances Principales

### PHP (Composer)
```json
{
  "laravel/framework": "^11.0",
  "laravel/tinker": "^2.8",
  "fakerphp/faker": "^1.21",
  "phpunit/phpunit": "^10.4"
}
```

### JavaScript (npm)
```json
{
  "bootstrap": "^5.3",
  "bootstrap-icons": "^1.11",
  "chart.js": "^4.4"
}
```

---

## 🔄 Flux de Requête (Request Lifecycle)

```
1. Navigateur → http://127.0.0.1:8000/vehicules
                 ↓
2. public/index.php (point d'entrée)
                 ↓
3. bootstrap/app.php (crée l'application)
                 ↓
4. routes/web.php (trouve la route)
   Route::resource('vehicules', VehiculeController::class)
                 ↓
5. app/Http/Controllers/Vehicules/VehiculeController.php
   public function index() { ... }
                 ↓
6. app/Models/Vehicule.php
   Récupère les données avec Eloquent
                 ↓
7. database/ (SQL queries via migrations schema)
   SELECT * FROM vehicules LIMIT 10
                 ↓
8. resources/views/vehicules/index.blade.php
   Affiche les données en HTML
                 ↓
9. resources/css/app.css + Chart.js
   Applique styles et graphiques
                 ↓
10. Navigateur affiche la page ✅
```

---

## 🗂️ Organisation des Dossiers par Feature

### Pour Ajouter une Nouvelle Entité (ex: Pièces Détachées)

```
1. Créer migration
   database/migrations/2026_01_15_000005_create_pieces_table.php

2. Créer modèle
   app/Models/Piece.php (avec relations)

3. Créer contrôleur
   app/Http/Controllers/Pieces/PieceController.php

4. Créer vues
   resources/views/pieces/
   ├── index.blade.php
   ├── create.blade.php
   ├── edit.blade.php
   └── show.blade.php

5. Ajouter routes
   routes/web.php : Route::resource('pieces', PieceController::class)

6. Ajouter au seeder
   database/seeders/DatabaseSeeder.php
   database/seeders/PieceSeeder.php

7. Mettre à jour layout
   resources/views/app.blade.php (ajouter lien menu)
```

---

## 💾 Migrations - Ordre d'Exécution

```
1. 0001_01_01_000000_create_users_table
2. 0001_01_01_000001_create_cache_table
3. 0001_01_01_000002_create_jobs_table
4. 2026_01_15_000000_create_vehicules_table (NO FK)
5. 2026_01_15_000001_create_techniciens_table (NO FK)
6. 2026_01_15_000002_create_reparations_table (FK vehicule_id, technicien_id)
7. 2026_01_15_000004_add_image_to_vehicules_table (ALTER TABLE)
```

**Important** : Les migrations s'exécutent dans l'ordre chronologique !

---

## 🔐 Fichiers à Ne PAS Commiter sur Git

```
.env                           (contient mots de passe)
storage/logs/                  (logs sensibles)
storage/app/public/vehicules/  (images volumineuses)
node_modules/                  (réinstallables)
vendor/                        (réinstallables via composer)
.vscode/                       (settings locaux)
```

Voir `.gitignore` pour la liste complète.

---

## 📝 Conventions de Nommage

### Contrôleurs
```php
// Nom : SingularResourceController
class VehiculeController { }
class TechnicienController { }
class ReparationController { }

// Dossiers : PluralControllerFolder
app/Http/Controllers/Vehicules/
app/Http/Controllers/Techniciens/
app/Http/Controllers/Reparations/
```

### Modèles
```php
// Nom : Singular PascalCase
class Vehicule { }
class Technicien { }
class Reparation { }

// Tables : plural snake_case
vehicles → vehicules
technicians → techniciens
repairs → reparations
```

### Routes
```php
// Ressources : plural lowercase
Route::resource('vehicules', VehiculeController::class);
Route::resource('techniciens', TechnicienController::class);
Route::resource('reparations', ReparationController::class);

// URLs générées :
GET    /vehicules              (index)
POST   /vehicules              (store)
GET    /vehicules/create       (create)
GET    /vehicules/{id}         (show)
GET    /vehicules/{id}/edit    (edit)
PUT    /vehicules/{id}         (update)
DELETE /vehicules/{id}         (destroy)
```

### Vues
```
resources/views/vehicules/
├── index.blade.php       (liste)
├── create.blade.php      (formulaire créer)
├── edit.blade.php        (formulaire éditer)
└── show.blade.php        (détails)

Nommage : {resource}.{action}.blade.php
```

---

## 🚀 Points d'Entrée Clés

| Point d'Entrée | Chemin | Rôle |
|---|---|---|
| Index.php | `public/index.php` | Point d'entrée web |
| Artisan | `artisan` | CLI Laravel |
| App Instance | `bootstrap/app.php` | Création application |
| Autoloader | `vendor/autoload.php` | Chargement classes |
| Vite Config | `vite.config.js` | Bundling CSS/JS |

---

## 📦 Génération de Fichiers CLI

```bash
# Créer une migration
php artisan make:migration create_pieces_table

# Créer un modèle
php artisan make:model Piece -m  # -m crée migration

# Créer un contrôleur
php artisan make:controller PieceController -r  # -r ajoute resource methods

# Créer un seeder
php artisan make:seeder PieceSeeder

# Créer un trait
php artisan make:trait Searchable

# Créer un service
mkdir app/Services && touch app/Services/MyService.php
```

---

**Structure complète et bien organisée ! 📚**
