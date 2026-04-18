# Konsultasi Dokter

Aplikasi konsultasi dokter berbasis Laravel dengan sistem role admin, dokter, dan pasien.

## Fitur Utama

### Admin
- Dashboard admin
- Manajemen akun (CRUD user) dengan modal create
- Manajemen reservasi (CRUD) dengan modal create

### Dokter
- Dashboard dokter
- Lihat reservasi masuk
- Update status reservasi

### Pasien
- Dashboard pasien
- Buat reservasi konsultasi
- Lihat riwayat reservasi

## Modul Manajemen Akun (Admin)

Modul ini memungkinkan admin untuk mengelola semua akun user dalam sistem.

### Fitur:
1. **List User** - Menampilkan semua user dengan pagination
2. **Search & Filter** - Pencarian berdasarkan nama/email dan filter berdasarkan role
3. **Tambah User** - Modal form untuk menambah user baru
4. **Edit User** - Form untuk mengubah data user
5. **Hapus User** - Hapus user (admin tidak bisa menghapus akun sendiri)

### Akses:
- Hanya admin yang bisa mengakses
- Menggunakan middleware `role:admin`
- Dilengkapi dengan Policy untuk authorization

### Route:
```
GET    /admin/users              - List semua user
POST   /admin/users              - Simpan user baru (via modal)
GET    /admin/users/{user}/edit  - Form edit user
PUT    /admin/users/{user}       - Update user
DELETE /admin/users/{user}       - Hapus user
```

### File yang Dibuat:
- `app/Http/Controllers/Admin/UserManagementController.php`
- `app/Policies/UserPolicy.php`
- `resources/views/admin/users/index.blade.php` (dengan modal create)
- `resources/views/admin/users/edit.blade.php`

### Modal Features:
- Bootstrap modal untuk create user
- Form validation dengan error handling
- Auto-reset form ketika modal ditutup/dibuka
- Auto-open modal jika ada validation errors

## Modul Manajemen Reservasi (Admin)

Modul ini memungkinkan admin untuk mengelola semua reservasi dalam sistem.

### Fitur:
1. **List Reservasi** - Menampilkan semua reservasi dengan pagination
2. **Search & Filter** - Pencarian berdasarkan nama pasien/dokter dan filter berdasarkan status
3. **Tambah Reservasi** - Modal form untuk menambah reservasi baru
4. **Edit Reservasi** - Form untuk mengubah data reservasi
5. **Detail Reservasi** - Lihat detail lengkap reservasi
6. **Hapus Reservasi** - Hapus reservasi

### Akses:
- Hanya admin yang bisa mengakses
- Menggunakan middleware `role:admin`

### Route:
```
GET    /admin/reservations              - List semua reservasi
POST   /admin/reservations              - Simpan reservasi baru (via modal)
GET    /admin/reservations/{id}         - Detail reservasi
GET    /admin/reservations/{id}/edit    - Form edit reservasi
PUT    /admin/reservations/{id}         - Update reservasi
DELETE /admin/reservations/{id}         - Hapus reservasi
```

### File yang Dibuat:
- `app/Http/Controllers/Admin/ReservationController.php`
- `resources/views/admin/reservations/index.blade.php` (dengan modal create)
- `resources/views/admin/reservations/show.blade.php`
- `resources/views/admin/reservations/edit.blade.php`

### Modal Features:
- Bootstrap modal untuk create reservasi
- Form validation dengan error handling
- Auto-reset form ketika modal ditutup/dibuka
- Auto-open modal jika ada validation errors
- Dropdown untuk pilih pasien dan dokter

## Instalasi

1. Clone repository
2. Install dependencies: `composer install`
3. Copy `.env.example` ke `.env`
4. Generate key: `php artisan key:generate`
5. Setup database di `.env`
6. Run migration: `php artisan migrate`
7. Run seeder: `php artisan db:seed`
8. Serve aplikasi: `php artisan serve`

## Struktur Database

### Users Table
- `id` - Primary key
- `name` - Nama lengkap
- `email` - Email (unique)
- `password` - Password (hashed)
- `role` - Role (admin/dokter/pasien)
- `created_at` - Timestamp
- `updated_at` - Timestamp

## Security

- Password di-hash menggunakan bcrypt
- Role-based access control
- Policy-based authorization
- CSRF protection
- Input validation
