## Food Reviews (Laravel + Blade + Tailwind CSS)

Situs web ulasan makanan mini bergaya Minimalist Baker dengan pencarian resep, filter, ulasan/penilaian pengguna, dan moderasi ringan.

### Teknologi

-   **Laravel 12** & **Blade**
-   **Tailwind CSS** & **Alpine.js** (Antarmuka Modern)
-   SQLite secara default (lihat `.env.example`)

### Cara Memulai

1. **Instal Dependensi**

    ```bash
    composer install
    npm install
    ```

2. **Atur Lingkungan (Environment)**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

3. **Konfigurasi Seed & Storage**

    ```bash
    php artisan storage:link
    php artisan migrate --seed
    ```

4. **Konfigurasi Email (Wajib untuk Lupa Kata Sandi)**

    Untuk mengaktifkan fitur Lupa Kata Sandi, konfigurasi SMTP Gmail di file `.env` Anda:

    **Langkah 1:** Aktifkan Autentikasi 2-Faktor (2FA) di akun Google Anda

    **Langkah 2:** Buat Kata Sandi Aplikasi (App Password) di https://myaccount.google.com/apppasswords

    **Langkah 3:** Perbarui `.env` Anda dengan pengaturan berikut:

    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=email-anda@gmail.com
    MAIL_PASSWORD=16-karakter-password-aplikasi-anda
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="email-anda@gmail.com"
    MAIL_FROM_NAME="Food Reviews"
    ```

    > **Catatan:** Gunakan Kata Sandi Aplikasi (tanpa spasi) untuk `MAIL_PASSWORD`, bukan kata sandi Gmail biasa Anda. `MAIL_FROM_ADDRESS` harus sesuai dengan alamat Gmail Anda.

5. **Jalankan Aplikasi**
    ```bash
    npm run build
    php artisan serve
    ```

### Akun Demo

-   Admin: `admin@example.com` / `password` (bisa memoderasi ulasan, mengedit/menghapus resep sendiri)
-   Pengguna biasa dibuatkan (seeded) dengan kata sandi `password`

### Fitur Utama

-   **Autentikasi**: Login, Daftar, **Lupa Kata Sandi (Email & Reset)**.
-   **Pencarian + Filter**: Tag, diet, waktu, urutkan berdasarkan penilaian/terbaru/terpendek.
-   **Manajemen Resep**: CRUD dengan tag, gambar utama, waktu persiapan/masak, tingkat kesulitan, jenis masakan.
-   **Ulasan**: Bintang 1–5, lapor + admin sembunyikan/tampilkan, agregat penilaian.
-   **Antarmuka Modern**: Desain Glassmorphism, siap Mode Gelap/Terang (default Terang), Responsif.

### Deployment Docker

Untuk pengaturan lokal cepat menggunakan Docker, cukup jalankan:

```bash
cp .env.docker .env
docker compose up -d
```

Ini secara otomatis menangani:

-   Pembuatan APP_KEY
-   Migrasi database
-   Seeding database
-   Build aset
-   Penautan storage (storage linking)

**Akses aplikasi di:** http://localhost:8000

#### Perintah Docker

```bash
# Menjalankan container
docker compose up -d

# Mematikan container
docker compose down

# Build ulang setelah perubahan Dockerfile
docker compose build --no-cache && docker compose up -d

# Melihat log
docker compose logs -f app

# Masuk ke container aplikasi
docker exec -it food-reviews-app bash

# Re-seed database (hapus file penanda terlebih dahulu)
#ini di gunakan kalau mau bersihkan database dan isi data manual dari user
docker exec food-reviews-app rm /var/www/html/storage/.seeded
docker compose restart app
```

#### Lingkungan Docker

Pengaturan Docker menggunakan `.env.docker` dengan default berikut:

-   **Database:** MySQL 8.0 (container: `food-reviews-db`)
-   **Web server:** Nginx (port 8000)
-   **PHP:** 8.4-FPM

Untuk menyesuaikan, salin `.env.docker` ke `.env` dan modifikasi sesuai kebutuhan sebelum menjalankan `docker compose up`.

### Pengujian

-   Cakupan fitur sedang dalam pengerjaan. Jalankan `php artisan test`.
