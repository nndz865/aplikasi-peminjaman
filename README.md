# SISTEM PEMINJAMAN LAB & INVENTARIS

Aplikasi web sistem informasi inventaris dan transaksi peminjaman alat laboratorium, perangkat praktik, serta fasilitas umum secara terpusat, modern, dan real-time.

## Teknologi
- Backend: PHP Native 8.2+ (Modular Architecture)
- Database: MySQL 8 / MariaDB (PDO, Stored Procedures, Functions, Triggers, Foreign Keys)
- Frontend: HTML5, CSS3, JavaScript, Bootstrap 5, Bootstrap Icons, Chart.js

## Fitur Utama
1. **Multi-Role Authentication**: Admin, Petugas, dan Peminjam.
2. **Dashboard & Analitik Visual**: Grafis Chart.js untuk statistik transaksi lab, stok alat per kategori, serta monitoring denda.
3. **Admin Module**: Manajemen User, Kategori Alat, Data Alat, Pengembalian, dan Log Aktivitas Sistem.
4. **Petugas Module**: Validasi & Persetujuan Peminjaman (`sp_pinjam_alat`), Proses Pengembalian (`hitung_denda()`, Triggers stok otomatis), Laporan Transaksi & Export CSV / Cetak HTML.
5. **Peminjam Module**: Katalog Alat Real-Time, Pengajuan Peminjaman, Riwayat Transaksi, dan Monitoring Denda Pribadi.
6. **Keamanan & Pelacakan**: Pencatatan IP Login dan riwayat waktu masuk pengguna.

## Instalasi & Cara Menjalankan di Laragon
1. Pastikan **Laragon** aktif (Apache & MySQL running).
2. Letakkan folder `aplikasi-peminjaman` ke dalam `C:/laragon/www/`.
3. Buka **phpMyAdmin** (`http://localhost/phpmyadmin/`) dan buat database baru bernama `db_peminjaman`.
4. Import file `database/db_peminjaman.sql` ke dalam database `db_peminjaman`.
5. Akses aplikasi melalui browser di URL:
   `http://localhost/aplikasi-peminjaman/public/`

## Akun Demo
- **Admin**: `admin` / `Admin123!`
- **Petugas**: `petugas` / `Petugas123!`
- **Peminjam**: `peminjam` / `Peminjam123!`
