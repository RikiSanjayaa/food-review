# Food Reviews - Manual Podman Flow

Target: run the Laravel app on a VPS with a small, teachable container setup.

## Final Shape

```text
browser -> nginx:80 -> app:9000/php-fpm -> mysql:3306
```

Default containers:

- `nginx`: serves `public/`, compiled Vite assets, and forwards PHP requests.
- `app`: PHP-FPM Laravel runtime.
- `db`: MySQL 8.0 with a named volume.

Optional Part 2 container:

- `redis`: cache/session/queue backend after the basic architecture is already running.

Redis is kept in `compose.yml` behind a Compose profile. It is not started by the default `podman compose up`, so Part 1 stays simple.

## Files That Matter

- `Containerfile`: builds the shared asset stage, the PHP-FPM app target, and the Nginx target.
- `docker/app/entrypoint.sh`: waits for MySQL, runs migrations, seeds once, then starts PHP-FPM.
- `docker/nginx/default.conf`: Nginx virtual host.
- `compose.yml`: defines `app`, `nginx`, `db`, and named volumes.
- `.env.podman`: template environment for Laravel.
- `.env`: runtime environment used by Compose after you copy the template.
- `.containerignore` / `.dockerignore`: keeps local dependencies, secrets, tests, and docs out of image context.

## What Was Cut

- Helper scripts. The stack is meant to run directly with `podman compose up`.
- Separate Nginx Containerfile. The app and Nginx images now use targets from the same `Containerfile`.
- Custom network names, container names, app healthcheck, resource hints, and DB host port publishing.
- Decorative comments that made the config longer without changing behavior.

## Manual VPS Flow

Use this as a realistic video script.

### 1. Install runtime

```bash
sudo apt update
sudo apt install -y podman podman-compose git
podman --version
podman compose version
```

If your distro does not ship `podman compose`, install `podman-compose` from the distro package or Python package manager.

### 2. Clone the project

```bash
git clone <repo-url> food-review
cd food-review
```

### 3. Prepare environment

```bash
cp .env.podman .env
```

Edit `.env`:

- set `APP_URL` to your domain or server IP;
- generate `APP_KEY` with the command below;
- replace database and mail passwords.

```bash
podman run --rm docker.io/php:8.4-cli php -r 'echo "base64:".base64_encode(random_bytes(32)).PHP_EOL;'
```

Copy the generated value into `APP_KEY` in `.env`.

### 4. Start the stack

```bash
podman compose up --build
```

What happens:

- The shared `assets` stage runs `npm ci` and `npm run build`.
- The app target keeps `public/build/manifest.json` so Laravel's Vite helper can render pages.
- The Nginx target serves the same compiled `public/build` files.
- The PHP app target installs Composer dependencies without dev packages.
- `node_modules` and `vendor` from your laptop are ignored and rebuilt inside images.

On first boot, the app container:

- waits until MySQL is reachable;
- runs `php artisan migrate --force`;
- runs `php artisan db:seed --force` once;
- starts `php-fpm`.

After the first build, normal starts can be as short as:

```bash
podman compose up
```

Use detached mode when you want it to keep running in the background:

```bash
podman compose up -d
```

### 5. Verify

```bash
podman compose ps
podman compose logs -f app
podman compose logs -f nginx
```

Open:

```text
http://SERVER_IP:8004
```

### 6. Operate the app

Run Artisan:

```bash
podman compose exec app php artisan about
podman compose exec app php artisan migrate:status
```

Open MySQL shell:

```bash
podman compose exec db mysql -u food_reviews -p food_reviews
```

Rebuild after code changes:

```bash
podman compose up --build -d
```

Stop containers without deleting data:

```bash
podman compose down
```

Delete containers and database volume:

```bash
podman compose down -v
```

## Migrating From The Old Compose

The old stack used explicit container names such as `food-reviews-db`, `food-reviews-redis`, `food-reviews-app`, and `food-reviews-nginx`.

If `podman-compose stop` tries to stop `food-reviews_db_1` but your running containers are named `food-reviews-db`, stop the old containers by their actual names:

```bash
podman stop food-reviews-nginx food-reviews-app food-reviews-redis food-reviews-db
podman rm food-reviews-nginx food-reviews-app food-reviews-redis food-reviews-db
```

Then pull the simplified config and start normally:

```bash
git pull
cp .env.podman .env
podman compose up --build -d
```

The compose file keeps the old named volumes:

```text
food-reviews-db-data
food-reviews-app-storage
food-reviews-redis-data
```

That keeps existing database, storage, and Redis data available after the container names are simplified.

## Part 2: Add Redis

After the app, Nginx, and MySQL flow is stable, switch Laravel from database-backed session/cache/queue to Redis.

Edit `.env`:

```env
SESSION_DRIVER=redis
CACHE_STORE=redis
QUEUE_CONNECTION=redis
```

Then start the Redis profile:

```bash
podman compose --profile redis up -d
```

Verify Redis:

```bash
podman compose exec redis redis-cli ping
```

If you want the command to return to the simple form later, set `COMPOSE_PROFILES=redis` in your shell or deployment environment, then use:

```bash
podman compose up -d
```

## Production Notes

- Put a reverse proxy or firewall in front of port `8004` if this is internet-facing.
- Do not leave the sample passwords from `.env.podman` on a real VPS.
- Keep `APP_KEY` stable. Changing it invalidates encrypted cookies and sessions.
- If you later add real queued jobs, add a `worker` service before relying on Redis queues.
