#!/bin/sh
# =============================================================================
# deploy.sh — Podman Compose deployment for Food Reviews
# Usage: ./scripts/deploy.sh
# =============================================================================

set -e

COMPOSE_FILE="compose.podman.yml"
APP_NAME="food-reviews"

echo "╔══════════════════════════════════════════════════╗"
echo "║   🍜 Food Reviews — Podman Deploy               ║"
echo "╚══════════════════════════════════════════════════╝"

# ── 1. Check podman ──────────────────────────────────
if ! command -v podman >/dev/null 2>&1; then
    echo "❌ podman not found. Install it first."
    exit 1
fi
echo "✅ podman: $(podman --version)"

# ── 2. Check compose ────────────────────────────────
if ! podman compose version >/dev/null 2>&1; then
    echo "❌ podman-compose not available."
    echo "   Try: podman machine start  (if using Podman Desktop)"
    echo "   Or install podman-compose: pip install podman-compose"
    exit 1
fi
echo "✅ podman compose available"

# ── 3. Clean up old deployment ──────────────────────
echo ""
echo "→ Stopping any previous deployment..."
podman compose -f "$COMPOSE_FILE" down 2>/dev/null || true

# ── 4. Build images ─────────────────────────────────
echo ""
echo "→ Building images (multi-stage Containerfile)..."
podman compose -f "$COMPOSE_FILE" build --pull

# ── 5. Start services (except init) ─────────────────
echo ""
echo "→ Starting services (db, redis, app, nginx)..."
podman compose -f "$COMPOSE_FILE" up -d db redis

# ── 6. Wait for DB ─────────────────────────────────
echo ""
echo "→ Waiting for database to be ready..."
TIMEOUT=60
ELAPSED=0
until podman compose -f "$COMPOSE_FILE" exec db mysqladmin ping -h localhost -u root -prootpassword --silent 2>/dev/null; do
    sleep 2
    ELAPSED=$((ELAPSED + 2))
    if [ "$ELAPSED" -ge "$TIMEOUT" ]; then
        echo "❌ Database did not become ready in ${TIMEOUT}s"
        exit 1
    fi
    echo "   ... waiting ($ELAPSED/${TIMEOUT}s)"
done
echo "✅ Database is ready"

# ── 7. Start remaining services ────────────────────
echo ""
echo "→ Starting app and nginx..."
podman compose -f "$COMPOSE_FILE" up -d app nginx redis

# ── 8. Run init (migrations + seeds) ────────────────
echo ""
echo "→ Running database init (migrations + seeding)..."
podman compose -f "$COMPOSE_FILE" run --rm app-init

# ── 9. Done ─────────────────────────────────────────
echo ""
echo "╔══════════════════════════════════════════════════╗"
echo "║   ✅ Food Reviews is up!                        ║"
echo "║                                                  ║"
echo "║   URL:   http://localhost:8004                   ║"
echo "║                                                  ║"
echo "║   Commands:                                      ║"
echo "║   podman compose -f $COMPOSE_FILE ps            ║"
echo "║   podman compose -f $COMPOSE_FILE logs -f       ║"
echo "║   podman compose -f $COMPOSE_FILE down          ║"
echo "╚══════════════════════════════════════════════════╝"
