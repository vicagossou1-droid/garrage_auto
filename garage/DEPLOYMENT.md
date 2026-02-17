# 🚀 Guide de Déploiement et Bonnes Pratiques

## 📋 Checklist Pré-Déploiement

### Avant de Mettre en Production

- [ ] Tester toutes les fonctionnalités localement
- [ ] Vérifier que toutes les migrations s'exécutent
- [ ] Tester les uploads de fichiers
- [ ] Tester la recherche et les filtres
- [ ] Vérifier les exports CSV
- [ ] Tester les graphiques du dashboard
- [ ] Exécuter les tests (si présents)
- [ ] Vérifier les logs pour les erreurs

```bash
# Lancer un test complet
php artisan migrate:refresh --seed
php artisan test
```

---

## 🔧 Configuration Production

### Fichier `.env` Production

```env
APP_NAME="Gestion Garage"
APP_ENV=production
APP_KEY=base64:... (même clé qu'en local)
APP_DEBUG=false
APP_URL=https://votredomaine.com

# Base de données production
DB_CONNECTION=mysql
DB_HOST=db.votrehote.com
DB_PORT=3306
DB_DATABASE=garage_prod
DB_USERNAME=user_prod
DB_PASSWORD=strong_password_here

# Cache et session
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=database

# Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_email@example.com
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@garage.com

# Logging
LOG_CHANNEL=single
LOG_LEVEL=warning
```

### Optimisations Production

```bash
# Optimiser l'autoloader
composer install --optimize-autoloader --no-dev

# Optimiser le cache
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Compiler les assets
npm run build

# Nettoyer les anciens fichiers
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## 🖥️ Déploiement sur Serveur (exemple avec Shared Hosting)

### 1. Préparer les Fichiers

```bash
# Créer un fichier de déploiement
zip -r garage.zip app/ bootstrap/ config/ database/ public/ resources/ routes/ \
  storage/ vendor/ .env composer.json package.json artisan

# Télécharger sur le serveur via FTP
# (Voir votre fournisseur d'hébergement)
```

### 2. Sur le Serveur

```bash
# Extraire les fichiers
unzip garage.zip

# Installer les dépendances
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Générer la clé (ou copier du .env.local)
php artisan key:generate

# Exécuter les migrations
php artisan migrate --force

# Charger les seeders (optionnel)
php artisan db:seed --force

# Créer le lien de stockage
php artisan storage:link

# Définir les permissions
chmod -R 775 storage bootstrap/cache
chmod -R 775 storage/app/public

# Cache et optimisation
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Configuration Apache / Nginx

**Apache** (`.htaccess` dans `/public`) :
```apache
<IfModule mod_rewrite.c>
  <IfModule mod_negotiation.c>
    Options -MultiViews
  </IfModule>

  RewriteEngine On
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^ index.php [L]
</IfModule>
```

**Nginx** (`server` block) :
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
    fastcgi_pass unix:/var/run/php-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    include fastcgi_params;
}
```

---

## 🔐 Sécurité Production

### 1. Protéger les Fichiers Sensibles

```bash
# Fichiers à ne pas partager
.env (contient les identifiants)
storage/logs/ (logs sensibles)
database/ (structure sensible)
```

### 2. Certificat SSL/TLS

```env
# Forcer HTTPS
APP_URL=https://votredomaine.com

# Laravel va rediriger HTTP → HTTPS
```

### 3. Authentification (Recommandé)

Implémenter une authentification pour sécuriser l'accès :

```php
// Dans routes/web.php
Route::middleware('auth')->group(function () {
    Route::resource('vehicules', VehiculeController::class);
    Route::resource('techniciens', TechnicienController::class);
    Route::resource('reparations', ReparationController::class);
});

// Installer avec : php artisan make:auth
```

### 4. Validation et Sanitization

Toutes les entrées sont validées côté serveur.

```php
// Exemple dans le contrôleur
$validated = $request->validate([
    'immatriculation' => 'required|unique:vehicules',
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
]);
```

### 5. Protection CSRF

Tous les formulaires ont un token CSRF automatique.

---

## 📊 Surveillance et Maintenance

### Logs

```bash
# Voir les logs en temps réel
tail -f storage/logs/laravel.log

# Sur Windows
Get-Content storage/logs/laravel.log -Wait
```

### Sauvegardes

```bash
# Sauvegarder la base de données
mysqldump -u root -p garage > backup_$(date +%Y%m%d).sql

# Sauvegarder les fichiers
tar -czf garage_backup_$(date +%Y%m%d).tar.gz .

# Sur Windows (PowerShell)
Compress-Archive -Path ./* -DestinationPath "backup_$(Get-Date -Format 'yyyyMMdd').zip"
```

### Monitoring

```bash
# Vérifier l'espace disque
df -h  # Linux/Mac
Get-Volume  # Windows

# Vérifier les processus
ps aux | grep php  # Linux/Mac
Get-Process | grep php  # Windows

# Vérifier les permissions
ls -la storage/  # Linux/Mac
Get-Item -Path storage -Recurse | Get-Acl  # Windows
```

---

## 🚨 Dépannage Production

### Erreur 500 - Internal Server Error

```bash
# 1. Vérifier les logs
tail -f storage/logs/laravel.log

# 2. Activer le debug temporairement
# Dans .env : APP_DEBUG=true
# (À désactiver après investigation)

# 3. Vérifier les permissions
chmod -R 775 storage bootstrap/cache

# 4. Vérifier la base de données
php artisan tinker
> DB::connection()->getPDO();
```

### Images ne s'affichent pas

```bash
# Vérifier le lien de stockage
php artisan storage:link

# Vérifier les permissions
chmod -R 775 storage/app/public

# Vérifier le chemin dans .env
APP_URL=https://votredomaine.com
```

### Migrations échouées

```bash
# Vérifier la version de PHP
php -v  # Doit être 8.2+

# Vérifier les erreurs
php artisan migrate --step

# Réinitialiser et rejouer
php artisan migrate:reset
php artisan migrate
```

---

## 📈 Optimisations de Performance

### 1. Eager Loading (Relations)

```php
// ❌ N+1 problem
$reparations = Reparation::all();
foreach ($reparations as $rep) {
    echo $rep->vehicule->marque;  // Query à chaque itération!
}

// ✅ Eager loading
$reparations = Reparation::with('vehicule', 'technicien')->get();
foreach ($reparations as $rep) {
    echo $rep->vehicule->marque;  // Pas de query supplémentaire
}
```

### 2. Pagination

```php
// ✅ Utiliser la pagination plutôt que all()
$vehicules = Vehicule::paginate(15);

// ❌ Éviter
$vehicules = Vehicule::all();  // Charge TOUS les enregistrements
```

### 3. Caching

```php
// Mettre en cache les données statiques
$marques = Cache::remember('vehicules_marques', 3600, function () {
    return Vehicule::distinct()->pluck('marque');
});
```

### 4. Indexation Base de Données

```sql
-- Ajouter des index pour les colonnes fréquemment recherchées
CREATE INDEX idx_immatriculation ON vehicules(immatriculation);
CREATE INDEX idx_marque ON vehicules(marque);
CREATE INDEX idx_vehicule_id ON reparations(vehicule_id);
CREATE INDEX idx_technicien_id ON reparations(technicien_id);
```

### 5. Compression des Assets

```bash
# Vite compile déjà en production
npm run build  # Crée des fichiers minifiés

# Vérifier la taille
npm run build -- --report
```

---

## 🔄 Mise à Jour en Production

### Avec Zero Downtime

```bash
# 1. Télécharger les nouveaux fichiers dans un dossier de staging
scp -r app/ remote:/var/www/garage-staging/

# 2. Tester sur le staging
ssh remote
cd /var/www/garage-staging
composer install --optimize-autoloader --no-dev
npm run build
php artisan migrate --database=staging

# 3. Basculer symlink
ln -sfn /var/www/garage-staging /var/www/garage

# 4. Redémarrer services (si nécessaire)
systemctl restart php-fpm
```

---

## 📚 Ressources Utiles

- [Laravel Production Deployment](https://laravel.com/docs/deployment)
- [PHP Best Practices](https://www.php-fig.org/psr/)
- [Security in Laravel](https://laravel.com/docs/security)
- [Database Optimization](https://laravel.com/docs/queries)

---

**Prêt pour la production ! 🚀**
