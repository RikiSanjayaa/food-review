## Food Reviews (Laravel + Blade)

Minimalist Baker–style mini food review site with recipe search, filters, user reviews/ratings, and lightweight moderation.

### Stack

-   Laravel 12, Blade, and Bootstrap
-   SQLite by default (see `.env.example`)

### Getting started

1. Install dependencies  
   `composer install`

2. Copy env & generate key  
   `cp .env.example .env`  
   `php artisan key:generate`

3. Migrate & seed demo data  
   `php artisan migrate --seed`

4. Serve  
   `php artisan serve`

### Demo accounts

-   Admin: `admin@example.com` / `password` (can moderate reviews, edit/delete own recipes)
-   Regular users are seeded with password `password`

### Core features

-   Search + filters (tags, diet, time, sort by rating/newest/shortest)
-   Recipe CRUD with tags, hero image, prep/cook times, difficulty, cuisine
-   Reviews with 1–5 stars, report + admin hide/unhide, rating aggregates

### Testing

-   Feature coverage in progress. Run `php artisan test`.
