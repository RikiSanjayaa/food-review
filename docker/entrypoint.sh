#!/bin/bash

set -e

if [ ! -f .env ]; then
    if [ -f .env.docker ]; then
        cp .env.docker .env
    elif [ -f .env.example ]; then
        cp .env.example .env
    fi
fi

if grep -q "DB_CONNECTION=sqlite" .env; then
    if [ ! -f database/database.sqlite ]; then
        touch database/database.sqlite
    fi
    chown www-data:www-data database/database.sqlite
fi

if [ -z "$(grep '^APP_KEY=' .env)" ] || [ "$(grep '^APP_KEY=' .env)" = "APP_KEY=" ]; then
    php artisan key:generate
fi

php artisan optimize:clear

if [ ! -f public/build/manifest.json ]; then
    echo "Ui build not found, building..."
    npm install
    npm run build
fi

rm -rf public/storage
php artisan storage:link

php artisan migrate --force --seed

chmod -R 777 storage bootstrap/cache database

exec "$@"
