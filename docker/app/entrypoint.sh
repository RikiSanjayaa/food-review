#!/bin/sh
# Food Reviews — App entrypoint
# Ensures proper permissions, generates APP_KEY, starts PHP-FPM

set -e

# Fix runtime permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    php artisan key:generate --force
fi

# Create storage link (safe to run multiple times)
php artisan storage:link --force 2>/dev/null || true

# Cache for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
