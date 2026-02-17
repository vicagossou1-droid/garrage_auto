# 🔧 Guide Complet de Troubleshooting

## 🚨 Problèmes Courants et Solutions

---

## ❌ Erreurs de Démarrage

### 1. "php: command not found" ou "php is not recognized"

**Cause** : PHP n'est pas installé ou pas dans le PATH.

**Solutions** :

#### Windows
```powershell
# Vérifier l'installation
php -v

# Si erreur, ajouter PHP au PATH :
# 1. Chercher où PHP est installé (ex: C:\xampp\php)
# 2. Ajouter ce chemin aux variables d'environnement Windows
# 3. Redémarrer le terminal

# Ou utiliser le chemin complet
C:\xampp\php\php.exe -v

# Ajouter alias dans PowerShell ($PROFILE)
function php { & 'C:\xampp\php\php.exe' @args }
```

#### Linux/Mac
```bash
# Installer PHP 8.2+
sudo apt-get install php8.2-cli php8.2-mysql php8.2-gd php8.2-curl

# Ou utiliser Homebrew (Mac)
brew install php
```

---

### 2. "composer: command not found"

**Cause** : Composer n'est pas installé.

**Solution** :
```bash
# Vérifier l'installation
composer -v

# Si absent, installer depuis https://getcomposer.org/download/

# Windows : utiliser l'installer .exe
# Linux/Mac :
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
```

---

### 3. "npm: command not found"

**Cause** : Node.js/npm non installé.

**Solution** :
```bash
# Vérifier
node -v
npm -v

# Si absent, installer depuis https://nodejs.org/
# Recommandé : Version LTS (18+)

# Après installation, vérifier
node -v      # v18.x.x ou supérieur
npm -v       # 9.x.x ou supérieur
```

---

## 💾 Erreurs Base de Données

### 4. "SQLSTATE[HY000] [2002] Connection refused"

**Cause** : MySQL n'est pas en cours d'exécution.

**Solutions** :

#### XAMPP
```bash
# Ouvrir XAMPP Control Panel
# Chercher MySQL
# Cliquer "Start"
# Attendre 5-10 secondes

# Vérifier la connexion
mysql -u root -p
# (Appuyer sur Entrée si pas de mot de passe)
```

#### Windows (sans XAMPP)
```powershell
# Vérifier le service MySQL
Get-Service MySQL*

# Démarrer le service
Start-Service MySQL80  # ou MySQL57, etc.

# Ou via MySQL Server Instance Config Wizard
net start MySQL80
```

#### Linux
```bash
# Vérifier le service
sudo systemctl status mysql

# Démarrer le service
sudo systemctl start mysql

# Vérifier la connexion
mysql -u root -p
```

---

### 5. "SQLSTATE[HY000] [1045] Access denied"

**Cause** : Identifiants MySQL incorrects.

**Solutions** :

```bash
# Vérifier les identifiants dans .env
DB_USERNAME=root
DB_PASSWORD=          # vide pour XAMPP par défaut

# Tester la connexion directement
mysql -u root -p
# Appuyer sur Entrée si pas de mot de passe

# Si vous avez un mot de passe
mysql -u root -p"votre_mot_de_passe"

# Si l'utilisateur n'existe pas, le créer
mysql -u root
CREATE USER 'garage'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON garage.* TO 'garage'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

### 6. "SQLSTATE[HY000] [2003] Can't connect to MySQL server on 'localhost'"

**Cause** : MySQL écoute sur un port différent ou n'est pas accessible.

**Solutions** :

```bash
# Vérifier le port MySQL (défaut 3306)
mysql -h 127.0.0.1 -u root -p

# Vérifier le port dans .env si différent
DB_HOST=127.0.0.1
DB_PORT=3306

# Tester la connexion au port spécifique
mysql -h 127.0.0.1 -P 3306 -u root -p
```

---

### 7. "Base de données 'garage' n'existe pas"

**Cause** : La base de données n'a pas été créée.

**Solutions** :

```bash
# Créer la base de données
mysql -u root -p
CREATE DATABASE garage;
SHOW DATABASES;  # Vérifier
EXIT;

# Ou via terminal
mysql -u root -p -e "CREATE DATABASE garage;"

# Vérifier dans .env que le nom correspond
DB_DATABASE=garage
```

---

### 8. "Duplicate entry 'XX-123-YY' for key 'vehicules.immatriculation'"

**Cause** : L'immatriculation existe déjà.

**Solutions** :

```bash
# Utiliser une immatriculation unique
# Format : AA-123-BB (2 lettres, 3 chiffres, 2 lettres)

# Vérifier les immatriculations existantes
mysql -u root -p garage
SELECT immatriculation FROM vehicules;

# Ou réinitialiser la base
php artisan migrate:refresh --seed
# ⚠️ Cela supprime TOUTES les données
```

---

## 🎨 Erreurs CSS/JS

### 9. "Les assets ne se chargent pas" ou CSS/JS cassés

**Cause** : Assets non compilés ou lien incorrect.

**Solutions** :

```bash
# 1. Compiler les assets
npm install
npm run build

# 2. Vérifier le APP_URL dans .env
APP_URL=http://127.0.0.1:8000

# 3. Vider le cache Laravel
php artisan optimize:clear
php artisan cache:clear
php artisan view:clear

# 4. Mode développement avec hot reload
npm run dev
# (À côté du serveur Laravel dans un autre terminal)
```

---

### 10. "Fichiers CSS/JS dans les assets vides"

**Cause** : Vite ou webpack n'a pas compilé.

**Solutions** :

```bash
# Réinstaller les dépendances
rm -rf node_modules package-lock.json
npm install
npm run build

# Ou sur Windows
rmdir /s node_modules
del package-lock.json
npm install
npm run build

# Vérifier public/build/
# Doit contenir : manifest.json, assets/
```

---

## 🖼️ Erreurs Images

### 11. "Les images ne s'affichent pas"

**Cause** : Lien de stockage non créé ou permissions manquantes.

**Solutions** :

```bash
# 1. Créer le lien de stockage
php artisan storage:link
# Crée : public/storage → storage/app/public

# 2. Vérifier les permissions (Linux/Mac)
chmod -R 775 storage/app/public
chmod -R 775 storage/logs

# 3. Vérifier que public/storage existe
ls -la public/storage  # Linux/Mac
dir public\storage     # Windows

# 4. Tester l'upload d'une image
# Aller sur /vehicules/create
# Uploader une image
# Si erreur : vérifier storage/logs/laravel.log
```

---

### 12. "Erreur lors de l'upload : 'File' => [0] => 'The image field must be a file'"

**Cause** : Formulaire sans `enctype="multipart/form-data"`.

**Solutions** :

```blade
<!-- Vérifier dans les vues edit/create.blade.php -->
<form method="POST" action="..." enctype="multipart/form-data">
  @csrf
  <input type="file" name="image" accept="image/*">
</form>
```

---

### 13. "Erreur : 'uploaded file size exceeds the limit'"

**Cause** : Image > 2 MB ou limite serveur.

**Solutions** :

```bash
# Vérifier le validateur dans le contrôleur
$validated = $request->validate([
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //                                                        ↑ max 2 MB
]);

# Si besoin d'augmenter, modifier php.ini
upload_max_filesize = 10M
post_max_size = 10M

# Redémarrer Apache/PHP après modification
```

---

## 🔌 Erreurs Laravel

### 14. "Class 'DashboardController' not found"

**Cause** : Namespace incorrect ou autoload non mis à jour.

**Solutions** :

```bash
# 1. Vérifier le chemin du fichier
app/Http/Controllers/Dashboard/DashboardController.php
# Le namespace doit être : App\Http\Controllers\Dashboard

# 2. Mettre à jour l'autoload Composer
composer dump-autoload

# 3. Vider le cache
php artisan cache:clear
php artisan optimize:clear

# 4. Vérifier l'import dans routes/web.php
use App\Http\Controllers\Dashboard\DashboardController;
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
```

---

### 15. "CSRF token mismatch"

**Cause** : Formulaire sans token CSRF ou token expiré.

**Solutions** :

```blade
<!-- Ajouter @csrf à tous les formulaires -->
<form method="POST" action="/vehicules">
  @csrf  <!-- ← Important ! -->
  <input type="text" name="marque">
</form>

<!-- Ou via input caché -->
<input type="hidden" name="_token" value="{{ csrf_token() }}">
```

---

### 16. "Method POST not allowed" ou "405 Method Not Allowed"

**Cause** : Route mal définie ou méthode HTTP incorrecte.

**Solutions** :

```php
// ❌ Mauvais
Route::get('/vehicules', [VehiculeController::class, 'store']);

// ✅ Correct
Route::post('/vehicules', [VehiculeController::class, 'store']);

// Ou utiliser les ressources
Route::resource('vehicules', VehiculeController::class);
// Génère automatiquement les routes POST/PUT/DELETE

// Vérifier la méthode du formulaire
<form method="POST" action="/vehicules">  <!-- ← POST -->
  @csrf
</form>
```

---

### 17. "Undefined variable" dans une vue

**Cause** : Variable non passée du contrôleur à la vue.

**Solutions** :

```php
// ❌ Mauvais dans le contrôleur
public function index() {
    return view('vehicules.index');  // Sans passer $vehicules
}

// ✅ Correct
public function index() {
    $vehicules = Vehicule::paginate(10);
    return view('vehicules.index', ['vehicules' => $vehicules]);
    // Ou :
    return view('vehicules.index', compact('vehicules'));
}
```

---

### 18. "View [vehicules.index] not found"

**Cause** : Fichier vue dans le mauvais dossier.

**Solutions** :

```bash
# Vérifier le chemin
# Contrôleur appelle : view('vehicules.index')
# Fichier doit être : resources/views/vehicules/index.blade.php

# Créer si absent
mkdir resources/views/vehicules
touch resources/views/vehicules/index.blade.php
```

---

## 🔍 Erreurs Eloquent

### 19. "Call to undefined method Vehicule::search()"

**Cause** : Trait Searchable pas utilisé dans le modèle.

**Solutions** :

```php
// Dans app/Models/Vehicule.php
use App\Traits\Searchable;  // ← Importer

class Vehicule extends Model
{
    use Searchable;  // ← Utiliser le trait
    // ...
}

// Ensuite dans le contrôleur
$vehicules = Vehicule::search($search, ['marque', 'modele'])->paginate(10);
```

---

### 20. "No query results for model"

**Cause** : L'ID n'existe pas dans la base de données.

**Solutions** :

```php
// ❌ Mauvais (lève une exception)
$vehicule = Vehicule::findOrFail(999);  // L'ID 999 n'existe pas

// ✅ Correct (gère l'absence)
$vehicule = Vehicule::find(999);
if (!$vehicule) {
    return redirect()->route('vehicules.index')->with('error', 'Véhicule non trouvé');
}
```

---

## 🔐 Erreurs de Permissions

### 21. "Permission denied" sur les fichiers

**Cause** : Permissions fichiers insuffisantes.

**Solutions** :

#### Linux/Mac
```bash
# Donner les permissions au dossier storage
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Plus permissif (à utiliser avec précaution)
chmod -R 777 storage
chmod -R 777 bootstrap/cache
```

#### Windows
```powershell
# Vérifier les propriétés du dossier
# Clique droit > Propriétés > Sécurité

# Donner les droits à l'utilisateur courant
icacls storage /grant %USERNAME%:(F) /t
icacls bootstrap\cache /grant %USERNAME%:(F) /t
```

---

## 📊 Problèmes Migration

### 22. "SQLSTATE[42S02]: Table doesn't exist"

**Cause** : Migrations non exécutées.

**Solutions** :

```bash
# Exécuter les migrations
php artisan migrate

# Voir le statut des migrations
php artisan migrate:status

# Exécuter une migration spécifique
php artisan migrate --path=database/migrations/2026_01_15_000004_add_image_to_vehicules_table.php

# Si erreur de colonne, vérifier la migration
# Le fichier doit créer ou modifier les colonnes correctement
```

---

### 23. "Migration rolled back due to exception"

**Cause** : Erreur SQL dans la migration.

**Solutions** :

```bash
# 1. Vérifier le fichier migration
cat database/migrations/YYYY_MM_DD_XXXXXX_*.php

# 2. Corriger l'erreur SQL

# 3. Relancer
php artisan migrate:refresh --seed

# 4. Voir les logs si erreur
cat storage/logs/laravel.log
```

---

## 📝 Erreurs Validation

### 24. "The image field is required"

**Cause** : Champ image obligatoire mais vide.

**Solutions** :

```php
// Dans le contrôleur, rendre l'image optionnelle
$validated = $request->validate([
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //       ↑ nullable = optionnel
]);

// Dans la vue, le champ n'est pas obligatoire
<input type="file" name="image">  <!-- Pas de required -->
```

---

### 25. "The immatriculation field must be unique"

**Cause** : L'immatriculation existe déjà.

**Solutions** :

```php
// Utiliser une immatriculation unique ou modifier
// Format : AA-123-BB

// Vérifier les immatriculations existantes
Vehicule::pluck('immatriculation');

// Réinitialiser si besoin
php artisan migrate:refresh --seed
```

---

## 🔍 Problèmes Débogage

### 26. "Impossible de trouver l'erreur"

**Solutions de débogage** :

```bash
# 1. Vérifier les logs
tail -f storage/logs/laravel.log

# 2. Utiliser Tinker (shell Laravel)
php artisan tinker
>>> $vehicule = Vehicule::first();
>>> $vehicule->reparations;

# 3. Ajouter des var_dump
dd($variable);  // dump et die
dump($variable);  // dump seulement

# 4. Utiliser xdebug avec VSCode
# Voir documentation Laravel

# 5. Lire l'erreur complètement
# Les messages d'erreur Laravel sont détaillés
```

---

### 27. "Page blanche sans erreur"

**Cause** : Erreur fatale PHP mais logs désactivés.

**Solutions** :

```bash
# 1. Activer le debug
# Dans .env
APP_DEBUG=true

# 2. Vérifier les logs
tail -f storage/logs/laravel.log

# 3. Vérifier le navigateur (console F12)

# 4. Vérifier le serveur
# Erreur peut venir de PHP-FPM ou Apache
php artisan serve  # Mode verbose
```

---

## ✅ Checklist Rapide

Si quelque chose ne fonctionne pas :

- [ ] MySQL est-il démarré ? (XAMPP Panel)
- [ ] Les migrations sont-elles exécutées ? (`php artisan migrate:status`)
- [ ] Les assets sont-ils compilés ? (`npm run build`)
- [ ] Le serveur fonctionne-t-il ? (`php artisan serve`)
- [ ] Les logs ont-ils des erreurs ? (`storage/logs/laravel.log`)
- [ ] Le cache est-il vidé ? (`php artisan optimize:clear`)
- [ ] Les permissions sont-elles correctes ? (`chmod -R 775 storage`)

---

## 📞 Demander de l'Aide

Si les solutions ci-dessus ne fonctionnent pas :

1. **Copier le message d'erreur complet**
2. **Vérifier les logs** : `storage/logs/laravel.log`
3. **Consulter** :
   - [Laravel Docs](https://laravel.com/docs)
   - [Stack Overflow](https://stackoverflow.com/questions/tagged/laravel)
   - [Laravel Community](https://laravel.io)

---

**Application bien debuggée ! 🎉**
