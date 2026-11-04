# EVALUASI PROYEK & PENGUJIAN APLIKASI
**Judul:** Aplikasi Peminjaman Alat UKK RPL 2026/2027

## 1. Fitur yang Berjalan Baik
- Arsitektur modular PHP Native berhasil diterapkan secara bersih (`config`, `controllers`, `models`, `middleware`, `routes`, `views`).
- Integrasi MySQL dengan **Stored Procedure** (`sp_pinjam_alat`), **Stored Function** (`hitung_denda`), dan **Triggers** (`trg_kurangi_stok`, `trg_tambah_stok`) berjalan sangat presisi dan konsisten menjaga integritas stok alat.
- Hak akses berbasis role (*Role-Based Access Control*) divalidasi ketat di sisi backend (`RoleMiddleware`).
- Tampilan antarmuka responsif dan profesional menggunakan Bootstrap 5.

## 2. Pengujian Skenario UKK (Test Cases)
1. **Login User**: Berhasil menguji autentikasi dan redirect otomatis sesuai role (Admin, Petugas, Peminjam).
2. **CRUD Master Data**: Berhasil menambah, mengubah, dan menghapus kategori serta data alat dengan validasi stok tidak negatif.
3. **Pengajuan Peminjaman**: Berhasil memvalidasi stok dan mengirim pengajuan dengan status `menunggu`.
4. **Persetujuan Peminjaman**: Petugas menyetujui peminjaman, memicu `trg_kurangi_stok` untuk mengurangi stok alat secara aman.
5. **Pengembalian & Denda**: Proses pengembalian menghitung denda keterlambatan secara akurat via `hitung_denda()` dan memicu `trg_tambah_stok` untuk mengembalikan stok.
6. **Keamanan**: Uji akses URL langsung tanpa login atau melewati batas role berhasil ditolak dengan HTTP 403.

## 3. Rencana Pengembangan
- Penambahan grafik analitik lanjutan menggunakan Chart.js pada dashboard admin.
- Penambahan fitur ekspor laporan langsung ke PDF menggunakan dompdf jika diperlukan di masa mendatang.
