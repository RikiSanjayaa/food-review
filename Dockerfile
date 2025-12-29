FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies (including dev for Faker/seeding)
RUN composer install --no-interaction --optimize-autoloader

# Install Node dependencies and build assets
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Create entrypoint script to fix permissions at runtime
RUN echo '#!/bin/sh\n\
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache\n\
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache\n\
    # Generate APP_KEY if not set\n\
    if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then\n\
    php artisan key:generate --force\n\
    fi\n\
    # Create storage link, ignore error if already exist\n\
    php artisan storage:link\n\
    # Run migrations\n\
    php artisan migrate --force\n\
    # Seed only on first run (marker file check)\n\
    if [ ! -f /var/www/html/storage/.seeded ]; then\n\
    php artisan db:seed --force\n\
    touch /var/www/html/storage/.seeded\n\
    fi\n\
    # Cache config for performance\n\
    php artisan config:cache\n\
    php artisan route:cache\n\
    php artisan view:cache\n\
    exec php-fpm' > /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

CMD ["/usr/local/bin/docker-entrypoint.sh"]
