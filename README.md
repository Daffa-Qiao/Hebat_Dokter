# 🏥 Hebat Dokter

Aplikasi manajemen kesehatan berbasis web yang menghubungkan pasien dengan dokter, dilengkapi fitur reservasi, konsultasi, artikel kesehatan, tantangan harian, dan verifikasi email.

---

## 👥 Tim Pengembang

| No | Nama | NIM | Kelas |
|----|------|-----|-------|
| 1 | [Daffa Reivan Fathur Rahman] | [41825010071] | Ketua Tim |
| 2 | [Rafi Bima Tjahyadi] | [41825010043] | Anggota |
| 3 | [Dafa Pratama] | [41825010040] | Anggota |

---

## 🚀 Cara Menjalankan Aplikasi

### Prasyarat
- PHP >= 8.1
- Composer
- PostgreSQL
- Node.js & NPM

### Langkah Instalasi

```bash
# 1. Clone repository
git clone <url-repo>
cd Hebat-Dokter

# 2. Install dependensi PHP
composer install

# 3. Install dependensi frontend
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Konfigurasi database di .env
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=nama_database
# DB_USERNAME=username
# DB_PASSWORD=password

# 7. Konfigurasi SMTP di .env (untuk verifikasi email)
# MAIL_MAILER=smtp
# MAIL_HOST=smtp.gmail.com
# MAIL_PORT=587
# MAIL_USERNAME=email@gmail.com
# MAIL_PASSWORD=app_password_gmail
# MAIL_ENCRYPTION=tls
# MAIL_FROM_ADDRESS=email@gmail.com

# 8. Jalankan migrasi dan seeder
php artisan migrate
php artisan db:seed

# 9. Buat symlink storage
php artisan storage:link

# 10. Build aset frontend
npm run build

# 11. Jalankan server
php artisan serve
```

Aplikasi berjalan di **http://localhost:8000**

### Akun Default (dari Seeder)

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| Dokter | dokter@example.com | password |
| Pasien | pasien@example.com | password |

> Akun seeder tidak memerlukan verifikasi email.

---

## 🛠️ Stack Teknologi

### Backend
| Teknologi | Versi | Keterangan |
|-----------|-------|------------|
| PHP | ^8.1 | Bahasa pemrograman utama |
| Laravel | ^10.10 | Framework PHP |
| Laravel Sanctum | ^3.3 | API authentication |
| PostgreSQL | - | Database relasional |

### Frontend
| Teknologi | Keterangan |
|-----------|------------|
| Blade | Template engine Laravel |
| Bootstrap 5 | Framework CSS |
| Vite | Build tool frontend |
| Font Awesome | Ikon |

### Library & Tools
| Library | Keterangan |
|---------|------------|
| Guzzle HTTP | HTTP client |
| PHPUnit | Unit testing |
| Laravel Tinker | REPL interaktif |
| Faker | Data dummy untuk testing |

---

## AI Tools Used

This project utilized AI tools to enhance development efficiency and accuracy. Specifically, AI assistance was used for:

- Debugging and resolving CAPTCHA issues.
- Updating documentation, including the README file and creating the INSTRUCTION.md file.
- Ensuring seeded accounts are correctly handled in the database.

These tools streamlined the development process and ensured high-quality outcomes.

---

## ✨ Fitur Utama

### 👤 Autentikasi
- Register dengan verifikasi kode OTP via email (6 digit, berlaku 10 menit)
- Login dengan proteksi CAPTCHA matematika
- Role-based access control (Admin, Dokter, Pasien)

### 🏥 Pasien
- Dashboard dengan statistik reservasi
- Buat & kelola reservasi konsultasi
- Chat dengan dokter dalam reservasi
- Tantangan kesehatan harian dengan poin
- Kalkulator BMI & kalori
- Akses menu sehat berdasarkan riwayat penyakit

### 👨‍⚕️ Dokter
- Dashboard dengan statistik reservasi
- Kelola status reservasi
- Tulis & publikasikan artikel kesehatan
- Kelola menu sehat

### 🔧 Admin
- Dashboard statistik keseluruhan
- Manajemen pengguna (CRUD)
- Manajemen reservasi
- Manajemen event, tips diet, menu sehat, artikel

---

## 🔒 Keamanan
- Password di-hash menggunakan bcrypt
- CSRF protection pada semua form
- Role-based middleware
- Policy-based authorization
- Input validation & sanitization
- Verifikasi email OTP sebelum akses akun

