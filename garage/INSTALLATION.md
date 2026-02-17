# 🚀 Guide d'Installation Rapide - Gestion du Garage

## ⚡ Installation en 5 étapes

### Étape 1 : Préparation
```bash
# Vérifiez que vous êtes dans le dossier du projet
cd c:\Users\dell\garage_auto

# Installez les dépendances
composer install
```

### Étape 2 : Configuration MySQL
1. Ouvrez XAMPP Control Panel
2. Démarrez Apache et MySQL
3. Ouvrez phpMyAdmin (http://localhost/phpmyadmin)
4. Créez une nouvelle base de données nommée `garage`

### Étape 3 : Configuration de l'environnement
```bash
# Générez la clé d'application
php artisan key:generate

# Le fichier .env est déjà configuré pour MySQL
# Vérifiez que les identifiants correspondent:
# DB_DATABASE=garage
# DB_USERNAME=root
# DB_PASSWORD= (vide si pas de mot de passe)
```

### Étape 4 : Initialisation de la base de données
```bash
# Exécutez les migrations
php artisan migrate

# Remplissez avec les données de test
php artisan db:seed
```

### Étape 5 : Lancement
```bash
# Démarrez le serveur Laravel
php artisan serve

# L'application est accessible à http://localhost:8000
```

## 📋 Commandes Utiles

```bash
# Vider les migrations et recommencer
php artisan migrate:fresh

# Vider la base et réappliquer les seeds
php artisan migrate:fresh --seed

# Voir les routes disponibles
php artisan route:list

# Accéder à la console Tinker
php artisan tinker

# Vérifier l'état des migrations
php artisan migrate:status
```

## ❌ Résolution des problèmes

### Erreur de connexion à la base de données
- Vérifiez que MySQL est en cours d'exécution
- Vérifiez le nom de la base de données dans .env
- Assurez-vous que la base `garage` existe

### Erreur "Class not found"
```bash
composer dump-autoload
```

### Les vues ne s'affichent pas correctement
```bash
php artisan view:clear
```

### Permissions insuffisantes sur les dossiers
```bash
# Sur Windows, généralement pas nécessaire
# Sur Linux/Mac:
chmod -R 775 storage bootstrap/cache
```

## 🧪 Test des Fonctionnalités

### Accueil
- Visitez http://localhost:8000
- Vous devriez voir la page d'accueil avec 3 boutons

### Véhicules
- Allez à http://localhost:8000/vehicules
- Vous verrez 5 véhicules de test
- Essayez d'en créer, modifier, supprimer

### Techniciens
- Allez à http://localhost:8000/techniciens
- Vous verrez 5 techniciens avec leurs spécialités
- Essayez de gérer les techniciens

### Réparations
- Allez à http://localhost:8000/reparations
- Vous verrez 5 réparations d'exemple
- Essayez d'en créer de nouvelles et de les associer à des véhicules et techniciens

## 📊 Données de Test Incluses

**Véhicules** :
- Peugeot 308 (AB-123-CD) - Blanc, Diesel
- Renault Clio (EF-456-GH) - Bleu, Essence
- Citroën C3 (IJ-789-KL) - Gris, Essence
- Toyota Yaris (MN-012-OP) - Rouge, Hybride
- Volkswagen Golf (QR-345-ST) - Noir, Diesel

**Techniciens** :
- Jean Dupont - Mécanique générale
- Pierre Martin - Électricité automobile
- Marie Lefevre - Carrosserie
- Claude Bernard - Suspension et freinage
- Luc Gautier - Peinture automobile

**Réparations** : 5 réparations d'exemple liées aux véhicules et techniciens

## 🎯 Points Importants

✅ **Validations** :
- L'immatriculation d'un véhicule doit être unique
- Tous les champs obligatoires sont validés
- Les relations sont maintenues (cascades, sets null)

✅ **Sécurité** :
- Protection CSRF sur tous les formulaires
- Validation côté serveur obligatoire
- Messages d'erreur utilisateur-friendly

✅ **Base de données** :
- Relations correctement configurées
- Suppressions en cascade pour les véhicules
- Techniciens peuvent être supprimés sans perdre les réparations

## 📱 Navigateur Supportés

- Chrome/Edge (dernières versions)
- Firefox (dernières versions)
- Safari (dernières versions)
- Responsive design mobile inclus

## 🔄 Mettre à jour les données de test

Pour recommencer avec des données fraîches :
```bash
php artisan migrate:fresh --seed
```

Cela supprimera tout et recréera la structure + les données.

---

**L'application est prête à être utilisée ! 🎉**
