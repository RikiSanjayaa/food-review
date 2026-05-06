#!/bin/sh
# =============================================================================
# status.sh — Check Podman deployment status
# Usage: ./scripts/status.sh
# =============================================================================

COMPOSE_FILE="compose.podman.yml"

echo "╔══════════════════════════════════════════════════╗"
echo "║   🍜 Food Reviews — Status                      ║"
echo "╚══════════════════════════════════════════════════╝"

podman compose -f "$COMPOSE_FILE" ps

echo ""
echo "── Logs (last 10 per service) ──"
for svc in app nginx db redis; do
    echo ""
    echo "[$svc]:"
    podman compose -f "$COMPOSE_FILE" logs --tail=5 "$svc" 2>/dev/null || echo "   (not running)"
done
