#!/bin/bash
set -e

# Configuration
DB_HOST=${DB_HOST:-127.0.0.1}
DB_PORT=${DB_PORT:-3306}
DB_WAIT_TIMEOUT=${DB_WAIT_TIMEOUT:-60}

# Wait for DB (with timeout)
WAIT=0
echo "Waiting for DB at $DB_HOST:$DB_PORT..."
until nc -z "$DB_HOST" "$DB_PORT"; do
  sleep 1
  WAIT=$((WAIT+1))
  if [ "$WAIT" -ge "$DB_WAIT_TIMEOUT" ]; then
    echo "DB wait timeout after $DB_WAIT_TIMEOUT seconds, continuing..."
    break
  fi
done

# Ensure APP_KEY exists (generate if missing)
if [ -f .env ] && [ -z "$APP_KEY" ]; then
  echo "Generating APP_KEY..."
  php artisan key:generate --force || true
fi

# Ensure permissions
mkdir -p storage bootstrap/cache || true
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

# Run artisan tasks (best-effort)
php artisan migrate --force || echo "Migrations failed or skipped."
php artisan storage:link || true
php artisan config:cache || true

# Lancer supervisord (nginx + php-fpm)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
