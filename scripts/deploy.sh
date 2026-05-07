#!/bin/sh
# =============================================================================
# deploy.sh — Podman Compose deployment for Food Reviews
# Usage: ./scripts/deploy.sh
# =============================================================================

set -e

COMPOSE_FILE="compose.podman.yml"

echo "╔══════════════════════════════════════════════════╗"
echo "║   🍜 Food Reviews — Podman Deploy               ║"
echo "╚══════════════════════════════════════════════════╝"

# ── 1. Check podman ──────────────────────────────────
if ! command -v podman >/dev/null 2>&1; then
    echo "❌ podman not found. Install it first."
    exit 1
fi
echo "✅ podman: $(podman --version)"

# ── 2. Check compose mode ─────────────────────────
if ! podman compose version >/dev/null 2>&1; then
    echo "❌ podman compose not available."
    echo "   Try: podman machine start (Podman Desktop users)"
    echo "   Or install: pip install podman-compose"
    exit 1
fi
echo "✅ podman compose available"

# ── 3. Clean up ──────────────────────────────────────
echo ""
echo "→ Removing previous deployment..."
podman compose -f "$COMPOSE_FILE" down 2>/dev/null || true

# ── 4. Build all images ─────────────────────────────
echo ""
echo "→ Building images (app + nginx multi-stage)..."
podman compose -f "$COMPOSE_FILE" build --pull

# ── 5. Start infrastructure ─────────────────────────
echo ""
echo "→ Starting database and redis..."
podman compose -f "$COMPOSE_FILE" up -d db redis

# ── 6. Wait for DB ──────────────────────────────────
echo ""
echo "→ Waiting for database health..."
TIMEOUT=60
ELAPSED=0
until podman compose -f "$COMPOSE_FILE" exec -T db \
    mysqladmin ping -h localhost -u root -prootpassword --silent 2>/dev/null
do
    sleep 2
    ELAPSED=$((ELAPSED + 2))
    if [ "$ELAPSED" -ge "$TIMEOUT" ]; then
        echo "❌ Database not ready in ${TIMEOUT}s"
        exit 1
    fi
    printf "   ... waiting (%s/%ss)\r" "$ELAPSED" "$TIMEOUT"
done
echo ""
echo "✅ Database is ready"

# ── 7. Run init (migrations + seeds) ────────────────
echo ""
echo "→ Running database init (migrate + seed)..."
podman compose -f "$COMPOSE_FILE" run --rm app-init

# ── 8. Start app services ───────────────────────────
echo ""
echo "→ Starting app and nginx..."
podman compose -f "$COMPOSE_FILE" up -d app nginx

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
echo "║   podman compose -f $COMPOSE_FILE down -v       ║"
echo "╚══════════════════════════════════════════════════╝"
