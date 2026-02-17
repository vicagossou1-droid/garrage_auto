# 🔗 API Routes et Endpoints - Gestion Garage Auto

## 📍 URLs de Base

**Local** : `http://127.0.0.1:8000`  
**Production** : À configurer selon votre serveur

---

## 🏠 Routes de Navigation

### Page d'Accueil
```
GET /
```
Affiche la page d'accueil avec boutons d'accès rapide.

### Dashboard
```
GET /dashboard
```
Affiche statistiques, graphiques et réparations récentes.

---

## 🚗 Routes Véhicules

### Liste des Véhicules
```
GET /vehicules
```
**Paramètres optionnels** :
- `search` : Rechercher par immatriculation, marque, modèle
- `marque` : Filtrer par marque
- `energie` : Filtrer par type d'énergie
- `page` : Numéro de page (défaut: 1)

**Exemple** :
```
GET /vehicules?search=Peugeot&energie=Diesel&page=1
```

### Créer un Véhicule
```
GET /vehicules/create
```
Affiche le formulaire de création.

### Stocker un Véhicule
```
POST /vehicules
Content-Type: multipart/form-data
```

**Champs obligatoires** :
- `immatriculation` : String, unique
- `marque` : String
- `modele` : String
- `couleur` : String
- `annee` : Integer (1900 - année+1)
- `kilometrage` : Integer (>= 0)
- `carrosserie` : String
- `energie` : String (Essence, Diesel, Hybride, Électrique)
- `boite` : String (Manuelle, Automatique)

**Champs optionnels** :
- `image` : File (PNG/JPG/GIF, max 2 MB)

**Exemple cURL** :
```bash
curl -X POST http://127.0.0.1:8000/vehicules \
  -H "Content-Type: multipart/form-data" \
  -F "immatriculation=XY-123-AB" \
  -F "marque=Peugeot" \
  -F "modele=3008" \
  -F "couleur=Noir" \
  -F "annee=2023" \
  -F "kilometrage=15000" \
  -F "carrosserie=SUV" \
  -F "energie=Diesel" \
  -F "boite=Automatique" \
  -F "image=@/path/to/image.jpg"
```

### Voir un Véhicule
```
GET /vehicules/{id}
```
Affiche les détails et l'historique des réparations.

**Exemple** :
```
GET /vehicules/1
```

### Éditer un Véhicule
```
GET /vehicules/{id}/edit
```
Affiche le formulaire d'édition.

### Mettre à Jour un Véhicule
```
PUT /vehicules/{id}
Content-Type: multipart/form-data
```

Mêmes champs que la création.

**Exemple cURL** :
```bash
curl -X PUT http://127.0.0.1:8000/vehicules/1 \
  -H "Content-Type: multipart/form-data" \
  -F "immatriculation=XY-123-AB" \
  -F "marque=Peugeot" \
  ... (autres champs)
```

### Supprimer un Véhicule
```
DELETE /vehicules/{id}
```

**Exemple cURL** :
```bash
curl -X DELETE http://127.0.0.1:8000/vehicules/1 \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN"
```

### Exporter en CSV
```
GET /vehicules/export/csv
```

Télécharge un fichier CSV avec tous les véhicules.

**Exemple** :
```
GET /vehicules/export/csv
```

Fichier généré : `vehicules_2026-01-15_143022.csv`

---

## 👨‍🔧 Routes Techniciens

### Liste des Techniciens
```
GET /techniciens
```
**Paramètres optionnels** :
- `page` : Numéro de page (défaut: 1)

### Créer un Technicien
```
GET /techniciens/create
```

### Stocker un Technicien
```
POST /techniciens
Content-Type: application/x-www-form-urlencoded
```

**Champs obligatoires** :
- `nom` : String
- `prenom` : String

**Champs optionnels** :
- `specialite` : String

**Exemple cURL** :
```bash
curl -X POST http://127.0.0.1:8000/techniciens \
  -d "nom=Dupont&prenom=Jean&specialite=Mécanique"
```

### Voir un Technicien
```
GET /techniciens/{id}
```

### Éditer un Technicien
```
GET /techniciens/{id}/edit
```

### Mettre à Jour un Technicien
```
PUT /techniciens/{id}
```

### Supprimer un Technicien
```
DELETE /techniciens/{id}
```

### Exporter en CSV
```
GET /techniciens/export/csv
```

Fichier généré : `techniciens_2026-01-15_143022.csv`

---

## 🔧 Routes Réparations

### Liste des Réparations
```
GET /reparations
```
**Paramètres optionnels** :
- `page` : Numéro de page (défaut: 1)

### Créer une Réparation
```
GET /reparations/create
```

### Stocker une Réparation
```
POST /reparations
Content-Type: application/x-www-form-urlencoded
```

**Champs obligatoires** :
- `vehicule_id` : Integer (doit exister)
- `date_reparation` : Date (format: YYYY-MM-DD)
- `description` : String

**Champs optionnels** :
- `technicien_id` : Integer (doit exister si fourni)
- `duree_mo` : Integer (minutes, >= 0)

**Exemple cURL** :
```bash
curl -X POST http://127.0.0.1:8000/reparations \
  -d "vehicule_id=1" \
  -d "technicien_id=1" \
  -d "date_reparation=2026-01-15" \
  -d "duree_mo=120" \
  -d "description=Révision complète et changement d'huile"
```

### Voir une Réparation
```
GET /reparations/{id}
```

### Éditer une Réparation
```
GET /reparations/{id}/edit
```

### Mettre à Jour une Réparation
```
PUT /reparations/{id}
```

### Supprimer une Réparation
```
DELETE /reparations/{id}
```

### Exporter en CSV
```
GET /reparations/export/csv
```

Fichier généré : `reparations_2026-01-15_143022.csv`

---

## 🔐 Sécurité des Requêtes

### Token CSRF

Toutes les requêtes POST, PUT, DELETE requièrent un token CSRF.

**Obtenir le token** :
```html
<!-- Dans les formulaires Blade -->
@csrf
<!-- Ou -->
<input type="hidden" name="_token" value="{{ csrf_token() }}">
```

**Avec cURL** :
```bash
# 1. Récupérer le token depuis un formulaire (GET)
curl -c cookies.txt http://127.0.0.1:8000/vehicules/create

# 2. Utiliser le token dans la requête (POST)
curl -b cookies.txt \
  -H "X-CSRF-TOKEN: YOUR_TOKEN" \
  -X POST http://127.0.0.1:8000/vehicules \
  -d "..."
```

### Méthode HTTP

Laravel utilise des routes implicites pour PUT/DELETE :

```html
<!-- Formulaire avec PUT -->
<form method="POST" action="/vehicules/1">
  @csrf
  @method('PUT')
  <!-- champs -->
</form>

<!-- Formulaire avec DELETE -->
<form method="POST" action="/vehicules/1">
  @csrf
  @method('DELETE')
</form>
```

---

## 📊 Formats de Réponse

### Réponses HTML (formulaires)
```
Status: 200 OK
Content-Type: text/html; charset=UTF-8
```

### Réponses CSV (exports)
```
Status: 200 OK
Content-Type: text/csv; charset=utf-8
Content-Disposition: attachment; filename="vehicules_2026-01-15_143022.csv"
```

### Réponses avec Erreurs
```
Status: 422 Unprocessable Entity
Content-Type: text/html; charset=UTF-8
```

Affiche les erreurs de validation dans le formulaire.

---

## 🚀 Exemples Complets

### Créer un Véhicule (cURL)

```bash
curl -X POST http://127.0.0.1:8000/vehicules \
  -H "Content-Type: multipart/form-data" \
  -F "immatriculation=AA-111-BB" \
  -F "marque=BMW" \
  -F "modele=X3" \
  -F "couleur=Bleu" \
  -F "annee=2023" \
  -F "kilometrage=10000" \
  -F "carrosserie=SUV" \
  -F "energie=Diesel" \
  -F "boite=Automatique" \
  -F "image=@car.jpg"
```

### Rechercher des Véhicules (cURL)

```bash
# Recherche par marque
curl "http://127.0.0.1:8000/vehicules?search=BMW"

# Filtre par énergie
curl "http://127.0.0.1:8000/vehicules?energie=Diesel"

# Combinaison
curl "http://127.0.0.1:8000/vehicules?search=BMW&energie=Diesel&page=1"
```

### Exporter Données (cURL)

```bash
# Télécharger les véhicules
curl "http://127.0.0.1:8000/vehicules/export/csv" -O

# Télécharger les techniciens
curl "http://127.0.0.1:8000/techniciens/export/csv" -O

# Télécharger les réparations
curl "http://127.0.0.1:8000/reparations/export/csv" -O
```

---

## 📝 CSV Export Colonnes

### Véhicules CSV
```
ID,Immatriculation,Marque,Modèle,Couleur,Année,Kilométrage,Carrosserie,Énergie,Boîte,Créé le
1,AA-111-BB,BMW,X3,Bleu,2023,10000,SUV,Diesel,Automatique,2026-01-15 10:30:00
```

### Techniciens CSV
```
ID,Nom,Prénom,Spécialité,Nombre de Réparations,Créé le
1,Dupont,Jean,Mécanique générale,5,2026-01-15 10:30:00
```

### Réparations CSV
```
ID,Immatriculation,Marque,Modèle,Technicien,Date Réparation,Durée (minutes),Description,Créé le
1,AA-111-BB,BMW,X3,Jean Dupont,2026-01-15,120,Révision complète,2026-01-15 10:30:00
```

---

## ⚠️ Codes d'Erreur

| Code | Signification | Solution |
|------|---------------|----------|
| 200 | Succès | ✅ Requête correcte |
| 302 | Redirection | Redirection après succès |
| 400 | Requête invalide | Vérifier paramètres |
| 404 | Non trouvé | Ressource n'existe pas |
| 405 | Méthode non autorisée | Vérifier la méthode HTTP |
| 422 | Validation échouée | Vérifier les champs |
| 500 | Erreur serveur | Consulter `storage/logs/laravel.log` |

---

**Documentation API complète et à jour ! 📚**
