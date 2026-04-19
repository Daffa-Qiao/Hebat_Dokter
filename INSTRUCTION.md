# 📋 INSTRUCTION.md — Panduan Instalasi & Menjalankan Hebat Dokter

Panduan ini sudah diuji pada lingkungan berikut:
- **OS**: Windows 10/11
- **PHP**: 8.2
- **PostgreSQL**: 15+
- **Node.js**: 18+
- **Composer**: 2.x

---

## 📦 Prasyarat

Pastikan software berikut sudah terinstal sebelum memulai:

| Software | Versi Minimum | Cek Versi |
|----------|---------------|-----------|
| PHP | 8.1 | `php -v` |
| Composer | 2.0 | `composer -V` |
| PostgreSQL | 13 | `psql --version` |
| Node.js | 16 | `node -v` |
| NPM | 8 | `npm -v` |
| Git | - | `git --version` |

---

## 🚀 Langkah Instalasi

### 1. Clone Repository

```bash
git clone <url-repository>
cd Hebat-Dokter
```

---

### 2. Install Dependensi PHP

```bash
composer install
```

---

### 3. Install Dependensi Frontend

```bash
npm install
```

---

### 4. Salin File Environment

```bash
cp .env.example .env
```

---

### 5. Generate Application Key

```bash
php artisan key:generate
```

---

### 6. Buat Database PostgreSQL

Buka psql atau pgAdmin, lalu buat database baru:

```sql
CREATE DATABASE hebatdokter;
```

---

### 7. Konfigurasi File `.env`

Buka file `.env` dan sesuaikan bagian berikut:

```env
APP_NAME="Hebat Dokter"
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=hebatdokter
DB_USERNAME=postgres
DB_PASSWORD=password_postgres_anda
```

#### Konfigurasi SMTP Gmail (untuk verifikasi email)

1. Aktifkan **2-Step Verification** di akun Google Anda
2. Buka https://myaccount.google.com/apppasswords
3. Buat App Password baru (pilih "Mail" dan "Windows Computer")
4. Salin 16 karakter yang dihasilkan (format: `xxxx xxxx xxxx xxxx`)

Isi `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=emailanda@gmail.com
MAIL_PASSWORD="xxxx xxxx xxxx xxxx"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="emailanda@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

### 8. Jalankan Migrasi Database

```bash
php artisan migrate
```

Output yang diharapkan:
```
INFO  Running migrations.
  2014_10_12_000000_create_users_table .... DONE
  ...semua migrasi berhasil...
```

---

### 9. Jalankan Seeder

```bash
php artisan db:seed
```

Output yang diharapkan:
```
INFO  Seeding database.
  Database\Seeders\HealthChallengeSeeder ... DONE
  Database\Seeders\ArticleSeeder .......... DONE
```

---

### 10. Buat Storage Symlink

```bash
php artisan storage:link
```

---

### 11. Build Aset Frontend

```bash
npm run build
```

---

### 12. Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser dan akses: **http://localhost:8000**

---

## 🔑 Akun Default (dari Seeder)

Semua akun berikut **tidak memerlukan verifikasi email**.

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| Dokter | dokter@example.com | password |
| Dokter (Kardiologi) | dokter2@example.com | password |
| Dokter (Pediatri) | dokter3@example.com | password |
| Dokter (Nefrologi) | dokter4@example.com | password |
| Dokter (Pulmonologi) | dokter5@example.com | password |
| Dokter (Dermatologi) | dokter6@example.com | password |
| Dokter (Neurologi) | dokter7@example.com | password |
| Dokter (Umum) | dokter8@example.com | password |
| Pasien | pasien@example.com | password |
| Pasien 2 | pasien2@example.com | password |
| Pasien 3 | pasien3@example.com | password |
| Pasien 4 | pasien4@example.com | password |

---

## 🔄 Reset Database (Jika Diperlukan)

Untuk menghapus semua data dan mulai dari awal:

```bash
php artisan migrate:fresh --seed
```

---

## ❓ Troubleshooting

### Error: `SQLSTATE[08006] Connection refused`
- Pastikan PostgreSQL berjalan: buka pgAdmin atau jalankan `pg_ctl start`
- Cek `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD` di `.env`

### Error: `php_pdo_pgsql` extension not found
- Buka `php.ini`, hilangkan `;` di depan baris `extension=pdo_pgsql`
- Restart terminal

### Email verifikasi tidak terkirim
- Pastikan App Password Gmail sudah dibuat dan diisi di `MAIL_PASSWORD`
- Jalankan `php artisan config:clear` setelah mengubah `.env`

### Error: `permission denied` pada storage
- Jalankan `php artisan storage:link` ulang
- Pastikan folder `storage/` dapat ditulis

### Halaman CSS/JS tidak muncul
- Jalankan `npm run build` ulang
- Atau untuk development: jalankan `npm run dev` di terminal terpisah

## AI Tools Used

During the development of this project, AI tools were employed to:

- Debug and fix issues related to email verification and CAPTCHA functionality.
- Improve the verification logic to block access for already verified or non-existent accounts.
- Assist in creating and updating documentation, including this INSTRUCTION.md file.
- Validate and ensure proper handling of seeded accounts in the database.

These tools significantly contributed to the project's success by optimizing workflows and ensuring precision.
