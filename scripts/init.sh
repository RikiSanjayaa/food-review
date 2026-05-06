#!/bin/sh
# =============================================================================
# init.sh — Run migrations & seeding (one-shot init container alternative)
# Usage: podman compose -f compose.podman.yml run --rm app-init
# =============================================================================

set -e

echo "→ Running migrations..."
php artisan migrate --force

echo "→ Seeding database..."
php artisan db:seed --force

echo "✓ Init complete."
