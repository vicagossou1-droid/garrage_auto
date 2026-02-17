# Architecture du Projet AKVA-Auto

## 📋 Structure Globale

```
garage_auto/
├── 📄 Documents de Révision (NOUVEAUX)
│   ├── REVISION_COMPLETE.md
│   ├── RESUME_REVISION.md
│   ├── TEST_PLAN.md
│   ├── PROCHAINES_TACHES.md
│   ├── PROCHAINES_ETAPES.md
│   └── REVISION_SUMMARY.json
│
├── 🔧 Code Application
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Kernel.php (Middleware config)
│   │   │   ├── Controllers/ (8 contrôleurs)
│   │   │   │   ├── Auth/ (Login, Register)
│   │   │   │   ├── Admin/ (Réparations, Clients, Techniciens, Véhicules)
│   │   │   │   ├── Client/ (Dashboard)
│   │   │   │   └── Technicien/ (Dashboard)
│   │   │   └── Middleware/ (3 middleware de rôle)
│   │   ├── Models/ (14 modèles)
│   │   │   ├── Utilisateur
│   │   │   ├── Client
│   │   │   ├── Technicien
│   │   │   ├── Vehicule
│   │   │   ├── Reparation
│   │   │   ├── InterventionTechnicien
│   │   │   ├── Devis
│   │   │   ├── Recu
│   │   │   ├── AvisClient
│   │   │   ├── Conseil
│   │   │   ├── MessageContact
│   │   │   ├── Notification
│   │   │   └── User (legacy)
│   │   ├── Services/
│   │   │   └── ExportService.php
│   │   ├── Traits/
│   │   │   └── Searchable.php
│   │   └── Providers/ (AppServiceProvider, AuthServiceProvider)
│   │
│   ├── database/
│   │   ├── migrations/
│   │   │   ├── 0001_01_01_000000_create_users_table.php
│   │   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   │   ├── 0001_01_01_000005_add_affectation_to_interventions.php
│   │   │   └── 2026_01_15_000100_create_akva_auto_tables.php ✅ MODIFIÉ
│   │   ├── seeders/
│   │   │   ├── AdminSeeder.php ✅ MODIFIÉ
│   │   │   ├── ClientSeeder.php ✅ MODIFIÉ
│   │   │   ├── TechnicienSeeder.php ✅ MODIFIÉ
│   │   │   ├── VehiculeSeeder.php
│   │   │   ├── ReparationSeeder.php
│   │   │   ├── ConseilSeeder.php
│   │   │   ├── AvisClientSeeder.php
│   │   │   └── DatabaseSeeder.php
│   │   └── factories/ (UserFactory)
│   │
│   ├── resources/
│   │   ├── views/
│   │   │   ├── auth/
│   │   │   │   ├── login.blade.php ✅ MODIFIÉ
│   │   │   │   └── register.blade.php ✅ MODIFIÉ
│   │   │   ├── admin/
│   │   │   │   ├── dashboard.blade.php
│   │   │   │   ├── reparations/ (5 vues)
│   │   │   │   ├── clients/ (4 vues)
│   │   │   │   ├── techniciens/ (4 vues)
│   │   │   │   └── vehicules/ (4 vues)
│   │   │   ├── client/
│   │   │   │   └── dashboard.blade.php
│   │   │   ├── technicien/
│   │   │   │   └── dashboard.blade.php
│   │   │   ├── layouts/
│   │   │   │   └── app.blade.php
│   │   │   ├── components/
│   │   │   ├── home.blade.php
│   │   │   └── contact.blade.php
│   │   ├── css/
│   │   │   └── app.css
│   │   └── js/
│   │
│   ├── routes/
│   │   ├── web.php (Routes principales)
│   │   └── console.php
│   │
│   ├── config/
│   │   ├── app.php
│   │   ├── auth.php (Utilise Utilisateur::class) ✅ VÉRIFIÉ
│   │   ├── database.php
│   │   ├── mail.php
│   │   └── ... (autres configs)
│   │
│   ├── bootstrap/
│   │   ├── app.php
│   │   └── cache/
│   │
│   ├── public/
│   │   └── index.php
│   │
│   ├── storage/
│   │   └── logs/
│   │
│   ├── tests/
│   │   ├── Feature/
│   │   ├── Unit/
│   │   └── TestCase.php
│   │
│   ├── vendor/ (dépendances)
│   │
│   ├── artisan
│   ├── composer.json
│   ├── phpunit.xml
│   ├── vite.config.js
│   ├── .env (à configurer)
│   ├── .env.example
│   └── .gitignore
│
└── 📚 Documentation
    ├── README.md
    ├── INSTALLATION.md
    ├── DOCUMENTATION.md
    ├── API_ROUTES.md
    ├── PROJECT_STRUCTURE.md
    ├── DEVELOPER_GUIDE.md
    ├── FEATURES.md
    └── ... (autres docs)
```

---

## 🔄 Diagramme des Relations

```
┌─────────────────────────────────────────────────────────────┐
│                    UTILISATEURS                              │
│  (Authentification - COLUMN: password)                       │
└──────────────┬────────────────────────────────┬──────────────┘
               │                                 │
          ┌────▼────┐                      ┌─────▼─────┐
          │ CLIENT   │                      │ TECHNICIEN│
          └────┬────┘                      └─────┬─────┘
               │                                 │
          ┌────▼──────────────┐           ┌──────▼──────────┐
          │   VEHICULE        │           │ INTERVENTION    │
          │ (Client peut      │           │ TECHNICIEN      │
          │  avoir plusieurs) │           │ (Assign à       │
          └────┬──────────────┘           │  Reparation)    │
               │                          └──────▲──────────┘
               └────────────┬─────────────────────┘
                            │
                       ┌────▼─────────┐
                       │  REPARATION   │
                       │               │
                       ├─ DEVIS        │
                       ├─ RECU         │
                       └─ AVISLIENT    │

AUTRES:
├─ CONSEIL (Standalone)
├─ MESSAGECONTACT (Standalone)
└─ NOTIFICATION (Utilisateur)
```

---

## 🎯 Flux de Requête Principal

```
HTTP Request
    ↓
Router (routes/web.php)
    ↓
Middleware (auth, admin/client/technicien)
    ↓
Controller (ProcessInput, ValidateData)
    ↓
Model (Database operations via Eloquent)
    ↓
Database
    ↓
Model (Return data)
    ↓
Controller (Format response)
    ↓
View (Render template)
    ↓
HTTP Response
```

---

## 🔐 Authentification et Autorisation

```
Utilisateur (table: utilisateurs)
├─ Colonne: password (standardisée Laravel)
├─ Colonne: type_utilisateur (admin, client, technicien)
└─ Colonne: statut (actif, inactif, suspendu)

Middleware:
├─ EnsureAdminRole ← Vérifie type_utilisateur === 'admin'
├─ EnsureClientRole ← Vérifie type_utilisateur === 'client'
└─ EnsureTechnicienRole ← Vérifie type_utilisateur === 'technicien'

Routes:
├─ /admin/* ← admin middleware
├─ /client/* ← client middleware
└─ /technicien/* ← technicien middleware
```

---

## 📊 Modèles et Leurs Relations

| Modèle                     | Relations                                                           | Fillable                                                                                                                     |
| -------------------------- | ------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------- |
| **Utilisateur**            | → Client, Technicien, Notification                                  | nom, prenom, email, telephone, password, type_utilisateur, statut                                                            |
| **Client**                 | → Utilisateur, Vehicule, Reparation, AvisClient                     | utilisateur_id, adresse, ville, code_postal, numero_client                                                                   |
| **Technicien**             | → Utilisateur, InterventionTechnicien                               | utilisateur_id, specialite, taux_horaire, competences, statut                                                                |
| **Vehicule**               | → Client, Reparation                                                | client_id, marque, modele, plaque_immatriculation, couleur, annee, kilometrage, type_carrosserie, energie, numero_chassis    |
| **Reparation**             | → Vehicule, Client, InterventionTechnicien, Devis, Recu, AvisClient | vehicule_id, client_id, date_depot, date_fin_prevue, date_fin_reelle, description_panne, statut, estimation_cout, cout_final |
| **InterventionTechnicien** | → Reparation, Technicien                                            | reparation_id, technicien_id, date_debut, date_fin, duree_minutes, commentaires, cout_intervention                           |
| **Devis**                  | → Reparation                                                        | reparation_id, description_travaux, montant_total, date_emission, validite_jours, statut                                     |
| **Recu**                   | → Reparation                                                        | reparation_id, numero_recu, montant_total, methode_paiement, date_paiement                                                   |
| **AvisClient**             | → Client, Reparation                                                | client_id, reparation_id, note, commentaire, date_avis                                                                       |
| **Conseil**                | Standalone                                                          | titre, contenu, categorie, image, statut                                                                                     |
| **MessageContact**         | Standalone                                                          | nom, email, telephone, sujet, message, statut                                                                                |
| **Notification**           | → Utilisateur                                                       | utilisateur_id, titre, message, type, reparation_id                                                                          |

---

## 📈 Points Clés de l'Architecture

### ✅ Validé et Fonctionnel:

1. Authentification avec Utilisateur (pas User)
2. Relations correctes entre modèles
3. Middleware d'autorisation par rôle
4. Routes protégées
5. CRUD complets pour entités principales
6. Exports CSV fonctionnels
7. Formulaires de contact
8. Système de notifications prêt

### ⏳ À Implémenter:

1. Workflow complet Devis → Recu
2. Tableaux de bord avancés
3. Notifications en temps réel
4. Rapports et statistiques
5. Tests automatisés
6. API REST

### 🔒 Sécurité:

- ✅ Hash password
- ✅ CSRF protection
- ✅ Session auth
- ✅ Role-based access
- ⏳ Rate limiting
- ⏳ Input validation avancée
- ⏳ API authentication

---

## 🚀 Commandes Principales

```bash
# Base de données
php artisan migrate:fresh --seed      # Réinitialiser DB
php artisan migrate                   # Appliquer migrations
php artisan db:seed                   # Charger les seeders

# Serveur
php artisan serve                     # Démarrer serveur dev
php artisan tinker                    # Shell interactif

# Tests
php artisan test                      # Exécuter tests
php artisan test --coverage           # Tests avec coverage

# Cache
php artisan cache:clear               # Vider cache
php artisan config:cache              # Cache config
```

---

**Dernier Audit:** 1 février 2026  
**Status:** ✅ COHÉRENT ET FONCTIONNEL
