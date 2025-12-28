## Food Reviews (Laravel + Blade + Tailwind CSS)

Minimalist Baker–style mini food review site with recipe search, filters, user reviews/ratings, and lightweight moderation.

### Stack

-   **Laravel 12** & **Blade**
-   **Tailwind CSS** & **Alpine.js** (Modern UI)
-   SQLite by default (see `.env.example`)

### Getting started

1. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Setup Environtment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configure Database & Seed**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

4. **[NEW] Configure Email (Required for Forgot Password)**
   Update your `.env` file with Gmail SMTP settings to enable the Forgot Password feature:

   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=465
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-app-password
   MAIL_ENCRYPTION=ssl
   MAIL_FROM_ADDRESS="admin@yourdomain.com"
   MAIL_FROM_NAME="Food Reviews"
   
   APP_NAME="Food Reviews"
   APP_LOCALE=id
   ```
   > **Note:** Use an **App Password** from Google Account (2-Step Verification), not your login password.

5. **Run Application**
   ```bash
   npm run build
   php artisan serve
   ```

### Demo accounts

-   Admin: `admin@example.com` / `password` (can moderate reviews, edit/delete own recipes)
-   Regular users are seeded with password `password`

### Core features

-   **Authentication**: Login, Register, **Forgot Password (Email & Reset)**.
-   **Search + Filters**: Tags, diet, time, sort by rating/newest/shortest.
-   **Recipe Management**: CRUD with tags, hero image, prep/cook times, difficulty, cuisine.
-   **Reviews**: 1–5 stars, report + admin hide/unhide, rating aggregates.
-   **Modern UI**: Glassmorphism design, Dark/Light mode ready (default Light), Responsive.

### Testing

-   Feature coverage in progress. Run `php artisan test`.

