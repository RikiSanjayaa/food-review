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

if [ ! -L public/storage ]; then
    php artisan storage:link
fi

php artisan migrate --force --seed

chown -R www-data:www-data storage bootstrap/cache

exec "$@"
