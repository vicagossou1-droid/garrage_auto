# ⚡ Démarrage Rapide (5 minutes)

## 1️⃣ Prérequis Vérifiés ?

```bash
php -v          # PHP 8.2+
composer -v     # Composer installé
node -v         # Node.js 18+
npm -v          # npm 9+
```

Si un commande ne fonctionne pas → installer le prérequis manquant.

---

## 2️⃣ Cloner / Accéder au Projet

```bash
cd c:\Users\dell\garage_auto
```

Vérifier que vous êtes dans le bon dossier avec `dir`.

---

## 3️⃣ Installer les Dépendances (2-3 min)

```bash
composer install
npm install
```

Attendre que tout s'installe (peut prendre quelques minutes).

---

## 4️⃣ Configurer la Base de Données

### Option A : Si MySQL fonctionne déjà

1. Ouvrir XAMPP Control Panel
2. Cliquer "Start" pour Apache et MySQL
3. Vérifier que le status = "Running"

### Option B : Créer la Base de Données

```bash
# Ouvrir MySQL dans XAMPP
# Ou utiliser ligne de commande :
mysql -u root -p
# (Appuyer sur Entrée si pas de mot de passe)

# Créer la base :
CREATE DATABASE garage;
EXIT;
```

---

## 5️⃣ Configurer `.env`

Éditer le fichier `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=garage
DB_USERNAME=root
DB_PASSWORD=
```

**Important** : Vérifier qu'il n'y a rien après `DB_PASSWORD` si vous n'avez pas de mot de passe XAMPP.

---

## 6️⃣ Exécuter les Migrations

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
```

Vous devriez voir ✅ Created table... pour chaque migration.

---

## 7️⃣ Générer les Assets

```bash
npm run build
```

Cela compile CSS et JavaScript.

---

## 8️⃣ Lancer le Serveur

```bash
php artisan serve
```

Vous verrez : `Server running on [http://127.0.0.1:8000]`

---

## 9️⃣ Accéder à l'Application

Ouvrir navigateur :

```
http://127.0.0.1:8000
```

Vous devriez voir la page d'accueil ! 🎉

---

## 🎯 C'est Fait !

### Vous Pouvez Maintenant :

✅ Cliquer sur **Véhicules** → Liste des 5 véhicules de test  
✅ Cliquer sur **Techniciens** → Liste des 5 techniciens  
✅ Cliquer sur **Réparations** → Liste des 5 réparations  
✅ Cliquer sur **Dashboard** → Statistiques et graphiques  

### Tester les Fonctionnalités :

- **Ajouter** : Cliquer sur "Créer" dans chaque module
- **Chercher** : Utiliser la barre de recherche en haut des listes
- **Filtrer** : Utiliser les dropdowns pour filtrer par marque/énergie
- **Éditer** : Cliquer sur le bouton "Éditer" sur chaque ligne
- **Supprimer** : Cliquer sur "Supprimer" avec confirmation
- **Upload Image** : Dans la création/édition de véhicules
- **Exporter** : Cliquer sur "Exporter CSV" pour télécharger les données

---

## 🛑 Si Quelque Chose Ne Fonctionne Pas

### Erreur : "Connection refused"
```bash
# MySQL n'est pas démarré
# → Ouvrir XAMPP et cliquer "Start" pour MySQL
```

### Erreur : "Command not found: php"
```bash
# PHP n'est pas dans le PATH
# → Ajouter C:\php (ou votre chemin) aux variables d'environnement Windows
```

### Images ne s'affichent pas
```bash
# Relancer le lien de stockage
php artisan storage:link
```

### CSS/JS cassés
```bash
# Recompiler les assets
npm run build
```

### Base de données échouée
```bash
# Réinitialiser tout
php artisan migrate:refresh --seed
```

---

## 📞 Commandes Essentielles à Retenir

| Commande | Quand l'Utiliser |
|----------|------------------|
| `php artisan serve` | Démarrer le serveur (à faire à chaque session) |
| `npm run build` | Après modification de CSS/JS |
| `php artisan migrate` | Après ajout d'une migration |
| `php artisan db:seed` | Pour ajouter des données de test |
| `php artisan optimize:clear` | Si quelque chose semble cassé |

---

## 🎓 Prochaines Étapes

1. **Explorer les Données de Test** :
   - Véhicule : Peugeot 308 (AB-123-CD)
   - Technicien : Jean Dupont (Mécanique générale)

2. **Créer de Nouvelles Entrées** :
   - Ajouter un nouveau véhicule
   - Ajouter un nouveau technicien
   - Créer une réparation

3. **Tester les Recherches** :
   - Chercher "Peugeot" dans les véhicules
   - Filtrer par "Diesel"

4. **Regarder les Graphiques** :
   - Accéder au Dashboard
   - Observer les statistiques

---

**Tout est prêt ! Amusez-vous ! 🚗✨**

Pour plus de détails → Consulter [FEATURES.md](FEATURES.md)
