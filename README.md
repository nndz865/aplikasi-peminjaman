# APLIKASI PEMINJAMAN ALAT UKK RPL 2026/2027

Aplikasi web sistem informasi inventaris dan transaksi peminjaman alat praktik Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak Tahun Pelajaran 2026/2027.

## Teknologi
- Backend: PHP Native 8.2+ (Modular Architecture)
- Database: MySQL 8 / MariaDB (PDO, Stored Procedures, Functions, Triggers, Foreign Keys)
- Frontend: HTML5, CSS3, JavaScript, Bootstrap 5, Bootstrap Icons

## Fitur Utama
1. **Multi-Role Authentication**: Admin, Petugas, dan Peminjam.
2. **Admin Module**: CRUD User, CRUD Kategori Alat, CRUD Data Alat, Log Aktivitas.
3. **Petugas Module**: Validasi & Persetujuan Peminjaman (`sp_pinjam_alat`), Monitoring & Proses Pengembalian (`hitung_denda()`, Triggers stok otomatis), Laporan Transaksi & Cetak HTML.
4. **Peminjam Module**: Katalog Alat Real-Time, Pengajuan Peminjaman, Riwayat Transaksi, Kalkulasi Denda Pribadi.

## Instalasi & Cara Menjalankan di Laragon
1. Pastikan **Laragon** aktif (Apache & MySQL running).
2. Letakkan folder `aplikasi-peminjaman-1` ke dalam `C:/laragon/www/`.
3. Buka **phpMyAdmin** (`http://localhost/phpmyadmin/`) dan buat database baru bernama `db_peminjaman`.
4. Import file `database/db_peminjaman.sql` ke dalam database `db_peminjaman`.
5. Akses aplikasi melalui browser di URL:
   `http://localhost/aplikasi-peminjaman-1/public/`

## Akun Demo
- **Admin**: `admin` / `Admin123!`
- **Petugas**: `petugas` / `Petugas123!`
- **Peminjam**: `peminjam` / `Peminjam123!`
