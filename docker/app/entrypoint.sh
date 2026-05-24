#!/bin/sh
set -e

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

php artisan storage:link --force >/dev/null 2>&1 || true

if [ -n "$DB_HOST" ]; then
    echo "Waiting for database at ${DB_HOST}:${DB_PORT:-3306}..."
    until mysqladmin ping -h"$DB_HOST" -P"${DB_PORT:-3306}" -u"${DB_USERNAME}" -p"${DB_PASSWORD}" --silent --skip-ssl; do
        sleep 2
    done
fi

php artisan migrate --force

if [ ! -f /var/www/html/storage/.seeded ]; then
    php artisan db:seed --force
    touch /var/www/html/storage/.seeded
fi

exec "$@"
