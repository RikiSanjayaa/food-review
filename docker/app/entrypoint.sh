#!/bin/sh
# Food Reviews — App entrypoint
# Permissions → APP_KEY → storage link → migrate → seed (once) → PHP-FPM

set -e

# Fix runtime permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Generate APP_KEY if not set (via PHP, avoids needing .env file)
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    KEY=$(php -r 'echo "base64:" . base64_encode(random_bytes(32));')
    export APP_KEY="$KEY"
fi

# Storage symlink for uploaded files
php artisan storage:link --force 2>/dev/null || true

# Wait for MySQL to be reachable (max 60s)
if [ -n "$DB_HOST" ]; then
    echo "→ Waiting for MySQL at ${DB_HOST}:${DB_PORT:-3306}..."
    for i in $(seq 1 60); do
        php -r "
            try {
                new PDO('mysql:host=${DB_HOST};port=${DB_PORT:-3306}', 'root', '${DB_ROOT_PASSWORD:-rootpassword}');
                exit(0);
            } catch (PDOException \$e) {
                exit(1);
            }
        " 2>/dev/null && echo "   MySQL ready!" && break
        sleep 1
    done
fi

# Always run migrations (idempotent, fast on subsequent runs)
echo "→ Running migrations..."
php artisan migrate --force

# Seed only on first start
if [ ! -f /var/www/html/storage/.initialized ]; then
    echo "→ First run: seeding..."
    php artisan db:seed --force
    touch /var/www/html/storage/.initialized
    echo "✓ Initialization complete"
fi

exec "$@"
