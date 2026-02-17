# 🏎️ Gestion du Garage - Application Laravel

Une application complète et fonctionnelle de gestion d'un garage de réparation automobile, développée avec Laravel.

## 📋 Fonctionnalités

### Véhicules
- ✅ Ajouter, modifier et supprimer des véhicules
- ✅ Gérer les informations complètes du véhicule (marque, modèle, couleur, année, kilométrage, etc.)
- ✅ Visualiser l'historique des réparations pour chaque véhicule
- ✅ Immatriculation unique et obligatoire

### Techniciens
- ✅ Gérer l'équipe de techniciens
- ✅ Attribuer des spécialités (Mécanique, Électricité, Carrosserie, etc.)
- ✅ Voir toutes les réparations assignées à un technicien
- ✅ Modifier ou supprimer les informations des techniciens

### Réparations
- ✅ Créer et gérer les réparations
- ✅ Associer une réparation à un véhicule et un technicien
- ✅ Enregistrer la date, la durée et la description de la réparation
- ✅ Voir l'historique complet des réparations
- ✅ Les réparations peuvent continuer même si un technicien quitte l'équipe

## 🗄️ Structure de la Base de Données

### Table `vehicules`
| Colonne | Type | Description |
|---------|------|-------------|
| id | ID | Clé primaire |
| immatriculation | string | Unique et obligatoire |
| marque | string | Optionnel |
| modele | string | Optionnel |
| couleur | string | Optionnel |
| annee | smallint | Optionnel |
| kilometrage | int | Optionnel |
| carrosserie | string | Optionnel (Berline, SUV, etc.) |
| energie | string | Optionnel (Essence, Diesel, etc.) |
| boite | string | Optionnel (Manuelle, Automatique) |
| created_at / updated_at | timestamp | Gestion automatique |

### Table `techniciens`
| Colonne | Type | Description |
|---------|------|-------------|
| id | ID | Clé primaire |
| nom | string | Obligatoire |
| prenom | string | Obligatoire |
| specialite | string | Optionnel |
| created_at / updated_at | timestamp | Gestion automatique |

### Table `reparations`
| Colonne | Type | Description |
|---------|------|-------------|
| id | ID | Clé primaire |
| vehicule_id | FK | Lien vers le véhicule (CASCADE) |
| technicien_id | FK | Lien vers le technicien (SET NULL) |
| date | date | Date de la réparation |
| duree_main_oeuvre | int | Durée en minutes (optionnel) |
| objet_reparation | text | Description détaillée |
| created_at / updated_at | timestamp | Gestion automatique |

## 🚀 Installation et Configuration

### Prérequis
- PHP 8.1 ou supérieur
- Composer
- MySQL/MariaDB (XAMPP)
- Laravel 11

### Étapes d'installation

1. **Cloner ou accéder au projet**
```bash
cd garage_auto
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configurer le fichier .env**
```bash
# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

4. **Configurer la base de données**

Modifier le fichier `.env` avec vos identifiants MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=garage
DB_USERNAME=root
DB_PASSWORD=
```

5. **Créer la base de données**

Via phpMyAdmin ou en ligne de commande:
```sql
CREATE DATABASE garage CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

6. **Exécuter les migrations**
```bash
php artisan migrate
```

7. **Remplir la base de données avec des données de test**
```bash
php artisan db:seed
```

8. **Lancer le serveur**
```bash
php artisan serve
```

L'application est maintenant accessible à `http://localhost:8000`

## 📁 Architecture du Projet

```
app/
├── Http/
│   └── Controllers/
│       ├── Vehicules/
│       │   └── VehiculeController.php
│       ├── Techniciens/
│       │   └── TechnicienController.php
│       └── Reparations/
│           └── ReparationController.php
└── Models/
    ├── Vehicule.php
    ├── Technicien.php
    └── Reparation.php

database/
├── migrations/
│   ├── 2026_01_15_000001_create_vehicules_table.php
│   ├── 2026_01_15_000002_create_techniciens_table.php
│   └── 2026_01_15_000003_create_reparations_table.php
└── seeders/
    ├── VehiculeSeeder.php
    ├── TechnicienSeeder.php
    └── ReparationSeeder.php

resources/views/
├── app.blade.php (layout principal)
├── accueil.blade.php
├── vehicules/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── techniciens/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
└── reparations/
    ├── index.blade.php
    ├── create.blade.php
    ├── edit.blade.php
    └── show.blade.php

routes/
└── web.php (toutes les routes)
```

## 🔗 Relations entre les Modèles

- **Vehicule** → **Reparations** (One-to-Many)
- **Technicien** → **Reparations** (One-to-Many)
- **Reparation** → **Vehicule** (Many-to-One)
- **Reparation** → **Technicien** (Many-to-One, nullable)

## 🎯 Routes disponibles

| Méthode | Route | Description |
|---------|-------|-------------|
| GET | `/` | Page d'accueil |
| GET | `/vehicules` | Liste des véhicules |
| POST | `/vehicules` | Créer un véhicule |
| GET | `/vehicules/create` | Formulaire de création |
| GET | `/vehicules/{id}` | Détails d'un véhicule |
| PUT | `/vehicules/{id}` | Modifier un véhicule |
| GET | `/vehicules/{id}/edit` | Formulaire d'édition |
| DELETE | `/vehicules/{id}` | Supprimer un véhicule |
| GET | `/techniciens` | Liste des techniciens |
| POST | `/techniciens` | Créer un technicien |
| GET | `/techniciens/create` | Formulaire de création |
| GET | `/techniciens/{id}` | Détails d'un technicien |
| PUT | `/techniciens/{id}` | Modifier un technicien |
| GET | `/techniciens/{id}/edit` | Formulaire d'édition |
| DELETE | `/techniciens/{id}` | Supprimer un technicien |
| GET | `/reparations` | Liste des réparations |
| POST | `/reparations` | Créer une réparation |
| GET | `/reparations/create` | Formulaire de création |
| GET | `/reparations/{id}` | Détails d'une réparation |
| PUT | `/reparations/{id}` | Modifier une réparation |
| GET | `/reparations/{id}/edit` | Formulaire d'édition |
| DELETE | `/reparations/{id}` | Supprimer une réparation |

## 🎨 Interface Utilisateur

- **Bootstrap 5** pour le responsive design
- **Bootstrap Icons** pour les icônes
- Navigation intuitive et cohérente
- Pagination des listes
- Formulaires validés côté serveur
- Messages de succès/erreur

## 📝 Fonctionnalités CRUD

Chaque module (Véhicules, Techniciens, Réparations) inclut les opérations CRUD complètes:
- **Create** (Créer) - Ajouter un nouvel enregistrement
- **Read** (Lire) - Afficher les détails
- **Update** (Mettre à jour) - Modifier un enregistrement
- **Delete** (Supprimer) - Supprimer un enregistrement

## 🔒 Validations

- Immatriculation unique pour les véhicules
- Champs obligatoires validés
- Plages de valeurs vérifiées (année, kilométrage, etc.)
- Gestion des relations avec suppressions en cascade

## 📊 Données de Test

La base de données est pré-remplie avec:
- 5 véhicules de marques différentes
- 5 techniciens avec spécialités variées
- 5 réparations d'exemple

## 🛠️ Technologies Utilisées

- **Framework** : Laravel 11
- **Base de données** : MySQL
- **Frontend** : Blade Templates, Bootstrap 5
- **Serveur de développement** : PHP Artisan

## 📚 Documentation Laravel

- [Documentation Laravel](https://laravel.com/docs)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Blade Templates](https://laravel.com/docs/blade)

## 👤 Auteur

Développé comme activité de formation Laravel

## 📄 Licence

Ce projet est une application éducative.

---

**Note**: Assurez-vous que votre serveur MySQL/XAMPP est en cours d'exécution avant de démarrer l'application.
