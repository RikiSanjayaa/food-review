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

3. **Configure Seed & Storage**

    ```bash
    php artisan storage:link
    php artisan migrate --seed
    ```

4. **Configure Email (Required for Forgot Password)**

    To enable the Forgot Password feature, configure Gmail SMTP in your `.env` file:

    **Step 1:** Enable 2-Factor Authentication on your Google account

    **Step 2:** Generate an App Password at https://myaccount.google.com/apppasswords

    **Step 3:** Update your `.env` with these settings:

    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=your-email@gmail.com
    MAIL_PASSWORD=your-16-char-app-password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="your-email@gmail.com"
    MAIL_FROM_NAME="Food Reviews"
    ```

    > **Note:** Use the App Password (without spaces) for the `MAIL_PASSWORD`, not your regular Gmail password. The `MAIL_FROM_ADDRESS` should match your Gmail address.

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
