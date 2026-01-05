# Sistem Informasi Data Pelanggan - Setup Guide

## Overview
Aplikasi Laravel 12 dengan authentication dan CRUD management untuk sistem informasi data pelanggan.

## Features
✅ Dashboard dengan statistik data pelanggan, produk, transaksi, pembayaran  
✅ CRUD Management untuk: Produk, Pelanggan, Transaksi, Pembayaran, Admin  
✅ Laravel Breeze Authentication dengan login, register, forgot password  
✅ Database dengan 8 tabel: admin, pelanggan, produk, transaksi, detail_transaksi, pembayaran, log_aktivitas, laporan_tahunan  

## Database Setup

### Credentials
- **Host:** 127.0.0.1
- **Port:** 3306
- **Database:** db_c050424021
- **User:** root
- **Password:** (kosong)

### Import Data
Database sudah berisi data dari `data_pelanggan.sql` dengan 3 admin accounts:

| ID_ADMIN | USERNAME | NAMA_ADMIN | PASSWORD |
|----------|----------|-----------|----------|
| A001 | admin01 | Agus Wahyudi | (original password) |
| A002 | admin02 | Budi Santoso | (original password) |
| A003 | admin03 | Siti Aminah | (original password) |

## User Credentials

### Admin Users (Created from admin table)
Users dibuat otomatis dari admin table melalui UserSeeder:

| Email | Password | Name |
|-------|----------|------|
| admin01@admin.local | (original admin01 password) | Agus Wahyudi |
| admin02@admin.local | (original admin02 password) | Budi Santoso |
| admin03@admin.local | (original admin03 password) | Siti Aminah |
| demo@example.com | password | Demo User |

## Routes

### Public Routes
- `GET /` - Redirect to login jika belum authenticated, ke dashboard jika sudah
- `GET /login` - Login page
- `GET /register` - Register page
- `GET /forgot-password` - Forgot password page

### Protected Routes (Require Authentication)
- `GET /dashboard` - Dashboard with statistics
- `GET /produk` - List Produk
- `GET /produk/create` - Create Produk
- `GET /produk/{id}` - Show Produk
- `GET /produk/{id}/edit` - Edit Produk
- `POST /produk` - Store Produk
- `PUT /produk/{id}` - Update Produk
- `DELETE /produk/{id}` - Delete Produk

- `GET /pelanggan` - List Pelanggan
- `GET /pelanggan/create` - Create Pelanggan
- `GET /pelanggan/{id}` - Show Pelanggan
- `GET /pelanggan/{id}/edit` - Edit Pelanggan
- `POST /pelanggan` - Store Pelanggan
- `PUT /pelanggan/{id}` - Update Pelanggan
- `DELETE /pelanggan/{id}` - Delete Pelanggan

- `GET /transaksi` - List Transaksi
- `GET /transaksi/create` - Create Transaksi
- `GET /transaksi/{id}` - Show Transaksi
- `GET /transaksi/{id}/edit` - Edit Transaksi
- `POST /transaksi` - Store Transaksi
- `PUT /transaksi/{id}` - Update Transaksi
- `DELETE /transaksi/{id}` - Delete Transaksi

- `GET /pembayaran` - List Pembayaran
- `GET /pembayaran/create` - Create Pembayaran
- `GET /pembayaran/{id}` - Show Pembayaran
- `GET /pembayaran/{id}/edit` - Edit Pembayaran
- `POST /pembayaran` - Store Pembayaran
- `PUT /pembayaran/{id}` - Update Pembayaran
- `DELETE /pembayaran/{id}` - Delete Pembayaran

- `GET /admin` - List Admin
- `GET /admin/create` - Create Admin
- `GET /admin/{id}` - Show Admin
- `GET /admin/{id}/edit` - Edit Admin
- `POST /admin` - Store Admin
- `PUT /admin/{id}` - Update Admin
- `DELETE /admin/{id}` - Delete Admin

- `GET /profile` - Edit Profile
- `PATCH /profile` - Update Profile
- `DELETE /profile` - Delete Profile

## Models & Relationships

### Admin (app/Models/Admin.php)
- `ID_ADMIN` (string, primary key)
- Relationships: hasMany Produk, hasMany Transaksi, hasMany Pembayaran

### Pelanggan (app/Models/Pelanggan.php)
- `ID_PELANGGAN` (int, auto-increment)
- Relationships: hasMany Produk, hasMany Transaksi, hasMany Pembayaran

### Produk (app/Models/Produk.php)
- `ID_PRODUK` (int, auto-increment)
- Fields: NAMA_PRODUK, HARGA, STOK, TOTAL_TERJUAL
- Relationships: belongsTo Admin, belongsTo Pelanggan, hasMany DetailTransaksi

### Transaksi (app/Models/Transaksi.php)
- `ID_TRANSAKSI` (int, auto-increment)
- Fields: TANGGAL_TRANSAKSI, TOTAL_BAYAR
- Relationships: belongsTo Pelanggan, belongsTo Admin, hasMany DetailTransaksi, hasMany Pembayaran

### DetailTransaksi (app/Models/DetailTransaksi.php)
- Composite PK: (ID_PRODUK, ID_TRANSAKSI)
- Fields: JUMLAH, HARGA_SATUAN, SUBTOTAL
- Relationships: belongsTo Produk, belongsTo Transaksi

### Pembayaran (app/Models/Pembayaran.php)
- `ID_PEMBAYARAN` (int, auto-increment)
- Fields: TANGGAL_PEMBAYARAN, JUMLAH_PEMBAYARAN, METODE_PEMBAYARAN
- Relationships: belongsTo Pelanggan, belongsTo Admin, belongsTo Transaksi

### LogAktivitas & LaporanTahunan
- Minimal implementations for audit logging and annual reporting

## Running the Application

```bash
# Start development server
php artisan serve

# Access at: http://127.0.0.1:8000
# Login with: admin01@admin.local / (admin01 password)
```

## File Structure

```
app/
  Http/Controllers/
    - DashboardController.php
    - ProdukController.php
    - PelangganController.php
    - TransaksiController.php
    - PembayaranController.php
    - AdminController.php
    - ProfileController.php (Breeze)
  Models/
    - Admin.php
    - Pelanggan.php
    - Produk.php
    - Transaksi.php
    - DetailTransaksi.php
    - Pembayaran.php
    - LogAktivitas.php
    - LaporanTahunan.php
    - User.php (Breeze)

resources/views/
  layouts/
    - app.blade.php (Main layout with Bootstrap CSS)
    - navigation.blade.php (Navigation bar with auth checks)
    - guest.blade.php
  auth/
    - login.blade.php (Breeze)
    - register.blade.php (Breeze)
    - forgot-password.blade.php (Breeze)
    - reset-password.blade.php (Breeze)
  dashboard.blade.php
  produk/
    - index.blade.php
    - create.blade.php
    - edit.blade.php
    - show.blade.php
  pelanggan/ (same structure)
  transaksi/ (same structure)
  pembayaran/ (same structure)
  admin/ (same structure)

routes/
  - web.php (All routes with auth middleware)
  - auth.php (Breeze authentication routes)

database/
  seeders/
    - UserSeeder.php (Create users from admin table)
    - DatabaseSeeder.php (Main seeder)
  migrations/ (Created by Breeze)
```

## Tech Stack
- **Framework:** Laravel 12.43.1
- **PHP:** 8.2.12
- **Database:** MySQL/MariaDB 10.4.32
- **Authentication:** Laravel Breeze
- **Frontend:** Blade Templates + Bootstrap 5.3.0
- **ORM:** Eloquent

## Notes
- All CRUD routes are protected with `auth` middleware
- Dashboard shows statistics of total Pelanggan, Produk, Transaksi, Pembayaran
- Navigation bar includes links to all CRUD sections
- User profile management available via `/profile`
- Logout available in user dropdown menu
