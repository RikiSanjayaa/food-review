# 🍜 Food Reviews — Podman Deployment

Cloud Computing final project. Converted from Docker to Podman with a multi-stage build, 4 services, and Redis.

## Architecture

```
┌─────────────────────────────────────────────────────┐
│                     Pod Network                      │
│                                                      │
│  ┌──────────┐    ┌──────────┐    ┌──────────┐       │
│  │  nginx   │◄──►│   app    │    │   db     │       │
│  │:8004:80  │    │(PHP-FPM) │    │ (MySQL)  │       │
│  └──────────┘    └────┬─────┘    └──────────┘       │
│                       │                              │
│                 ┌─────▼──────┐                       │
│                 │   redis    │                       │
│                 │(cache/sess)│                       │
│                 └────────────┘                       │
│                                                      │
│  ┌─────────────────────────────────────┐             │
│  │        app-init (one-shot)          │             │
│  │  migrates + seeds, then exits       │             │
│  └─────────────────────────────────────┘             │
└─────────────────────────────────────────────────────┘
```

## Services (4 + 1 init)

| Service    | Role                     | Image                          |
|------------|--------------------------|--------------------------------|
| `app`      | Laravel PHP-FPM          | Custom Containerfile (multi-stage) |
| `nginx`    | Web server               | nginx:stable-alpine             |
| `db`       | MySQL database           | mysql:8.0                       |
| `redis`    | Cache, session, queue    | redis:7-alpine                  |
| `app-init` | Migrations & seeding     | Same as `app`, runs once then exits |

## What Changed from Docker

| Before (Docker)     | After (Podman)            |
|---------------------|---------------------------|
| `Dockerfile`        | `Containerfile` (multi-stage) |
| `docker-compose.yml` | `compose.podman.yml`      |
| `.env.docker`       | `.env.podman`             |
| `.dockerignore`     | `.containerignore`        |
| Monolithic build    | Node builder → PHP app    |
| 3 containers        | 4 containers + Redis      |
| Entrypoint: all-in-1| Entrypoint: minimal + separate init service |
| DB session/cache    | Redis session/cache/queue |

## Key Improvements

### 1. Multi-stage Containerfile
- **Stage 1 (node-builder):** Compiles CSS/JS assets via Vite
- **Stage 2 (PHP-FPM):** Runs the app, copies assets from Stage 1
- Result: Final image has no Node/NPM — smaller, more secure

### 2. Redis
- Handles sessions, cache, and queue — offloads MySQL
- Persistent with AOF, max 128MB memory limit
- Plug-and-play: Laravel config was already there

### 3. Separate Init Service
- `app-init` runs migrations, seeding, and caching
- Runs once as a one-shot container, then exits
- App container entrypoint is minimal — just permissions + PHP-FPM

### 4. Proper Health Checks
Every service has a health check:
- `db`: mysqladmin ping
- `redis`: redis-cli ping
- `app`: artisan about
- `nginx`: upstream dependency

### 5. Resource Limits
Memory limits and CPU shares set on every service.

## Quick Start

### Prerequisites
- Podman v4+ with compose support (`podman compose`)
  - Or install `podman-compose`: `pip install podman-compose`

### Deploy

```bash
# 1. Build and start everything (app, nginx, db, redis)
./scripts/deploy.sh

# Or manually:
podman compose -f compose.podman.yml build --pull
podman compose -f compose.podman.yml up -d db redis
# Wait for DB to be healthy
podman compose -f compose.podman.yml up -d app nginx
# Run migrations and seeding once
podman compose -f compose.podman.yml run --rm app-init

# 2. Open in browser
open http://localhost:8004
```

### Useful Commands

```bash
# Check status
podman compose -f compose.podman.yml ps

# View logs
podman compose -f compose.podman.yml logs -f app
podman compose -f compose.podman.yml logs -f nginx
podman compose -f compose.podman.yml logs -f redis

# Rebuild and restart a service
podman compose -f compose.podman.yml build app
podman compose -f compose.podman.yml up -d app

# Re-seed database
podman compose -f compose.podman.yml run --rm app-init

# Stop everything
podman compose -f compose.podman.yml down

# Clean volumes (destroys data)
podman compose -f compose.podman.yml down -v
```

### Access the App

- **Frontend:** http://localhost:8004
- **MySQL (host side):** `mysql -h 127.0.0.1 -P 3307 -u food_reviews -psecret`
- **Redis (inside network):** `podman compose -f compose.podman.yml exec redis redis-cli`

## Podman vs Docker Notes

- Uses `Containerfile` instead of `Dockerfile`
- Uses `.containerignore` instead of `.dockerignore`
- Rootless by default — no `sudo` needed
- `podman compose` is built-in (Podman v4+)
- For Podman Desktop users: `podman compose` also works

## Architecture Decisions

**Why volumes_from instead of copying files to nginx?**
`volumes_from: app:ro` gives nginx read-only access to the app container's entire filesystem — including compiled assets from the multi-stage build AND the persistent storage volume. This avoids duplicating the build step for nginx.

**Why a separate init container?**
Migrations and seeding should not run every time the app container restarts. The `app-init` service runs once when the stack is first deployed, then exits. Subsequent restarts of `app` don't re-run migrations.

**Why not Laravel Sail?**
Sail is Docker-specific. This project uses native Podman with manual compose — more educational for a cloud computing final.
