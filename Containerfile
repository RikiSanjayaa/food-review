# =============================================================================
# Containerfile — Food Reviews App
# Multi-stage build: Node → PHP
# =============================================================================

# ------------------------------------------------
# Stage 1: Node Builder — Compile frontend assets
# ------------------------------------------------
FROM node:22-alpine AS node-builder

WORKDIR /build

# Copy dependency manifests first (cache layer)
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund

# Copy only what's needed for build
COPY resources/ resources/
COPY vite.config.js ./
COPY tailwind.config.js ./

# Build production assets
RUN npm run build

# ------------------------------------------------
# Stage 2: PHP Application
# ------------------------------------------------
FROM php:8.4-fpm

LABEL maintainer="Riki Sanjaya"
LABEL description="Food Reviews — Podman deployment"
LABEL version="2.0.0"

# ── System dependencies ──────────────────────────
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    mariadb-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ── Composer ─────────────────────────────────────
COPY --from=docker.io/library/composer:latest /usr/bin/composer /usr/bin/composer

# ── Application code ─────────────────────────────
WORKDIR /var/www/html

COPY . .

# Copy built frontend assets from Stage 1
COPY --from=node-builder /build/public/build /var/www/html/public/build

# Install PHP dependencies (no dev for production)
RUN composer install --optimize-autoloader --no-interaction

# ── Permissions ──────────────────────────────────
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# ── Entrypoint ───────────────────────────────────
# Simple: just fix permissions and start PHP-FPM
# Migrations & seeding are handled by a separate init service
COPY docker/app/entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["php-fpm"]
