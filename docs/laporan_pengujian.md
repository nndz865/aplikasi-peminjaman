# LAPORAN PENGUJIAN & EVALUASI SISTEM
## APLIKASI PEMINJAMAN ALAT UKK RPL 2026/2027

---

## 1. RINGKASAN EKSEKUTIF
Dokumen ini berisi hasil pengujian skenario fungsional dan keamanan pada **Aplikasi Peminjaman Alat UKK RPL 2026/2027**. Sistem dirancang menggunakan arsitektur modular PHP Native dan database MySQL 8+ dengan dukungan *Stored Procedure*, *Stored Function*, *Triggers*, dan *Foreign Key Constraints* untuk menjamin integritas data inventaris laboratorium.

---

## 2. SKENARIO PENGUJIAN FUNGSIONAL (TEST CASES)

| No | Modul / Fitur | Skenario Uji | Hasil Harapan | Hasil Pengujian | Status |
|----|---------------|--------------|---------------|-----------------|--------|
| 1 | Autentikasi | Login dengan akun Admin (`admin` / `Admin123!`) | Berhasil masuk dan diarahkan ke Dashboard Admin | Berhasil, sesi dan role tervalidasi | **PASSED** |
| 2 | Autentikasi | Login dengan akun Petugas (`petugas` / `Petugas123!`) | Berhasil masuk dan diarahkan ke Dashboard Petugas | Berhasil, diarahkan dengan benar | **PASSED** |
| 3 | Autentikasi | Login dengan akun Peminjam (`peminjam` / `Peminjam123!`) | Berhasil masuk dan diarahkan ke Dashboard Peminjam | Berhasil, katalog & riwayat tampil | **PASSED** |
| 4 | Master Data | Tambah & Edit Alat oleh Admin | Data alat tersimpan dan stok tervalidasi tidak negatif | Berhasil tersimpan ke database | **PASSED** |
| 5 | Peminjaman | Siswa mengajukan pinjam alat via katalog | Data masuk dengan status `menunggu`, memanggil `sp_pinjam_alat` | Berhasil mengajukan, stok terkunci aman | **PASSED** |
| 6 | Persetujuan | Petugas menyetujui pengajuan peminjaman | Status berubah menjadi `disetujui`, stok berkurang otomatis via `trg_kurangi_stok` | Berhasil, stok berkurang akurat | **PASSED** |
| 7 | Persetujuan | Petugas mengubah status / menolak peminjaman | Status dapat diubah dan stok dikembalikan jika dibatalkan | Berhasil mengubah status fleksibel | **PASSED** |
| 8 | Pengembalian | Petugas/Admin mengubah tanggal rencana kembali | Tanggal rencana kembali berhasil diperbarui dengan validasi tanggal | Berhasil memperbarui tanggal | **PASSED** |
| 9 | Pengembalian | Pengembalian alat tepat waktu / terlambat | Status menjadi `selesai`, denda dihitung via `hitung_denda()`, stok kembali via `trg_tambah_stok` | Berhasil menghitung denda & stok kembali utuh | **PASSED** |
| 10 | Keamanan | Akses URL langsung tanpa login (misal `/index.php?route=admin/dashboard`) | Ditolak oleh `AuthMiddleware` dan diredirect ke halaman login | Berhasil diblokir dengan aman | **PASSED** |

---

## 3. LAPORAN EVALUASI & KESIMPULAN
1. **Integritas Data & Stok**: Penerapan *Stored Procedure* dan *Triggers* terbukti sangat handal mencegah *race condition* dan memastikan stok alat tidak pernah minus saat peminjaman maupun pengembalian.
2. **Kenyamanan Pengguna (UX)**: Implementasi pencegahan *double-submit*, modal interaktif tanpa kedip, serta cetak laporan multi-halaman yang optimal membuat sistem sangat responsif dan profesional.
3. **Kesimpulan**: Aplikasi Peminjaman Alat UKK RPL 2026/2027 telah siap digunakan dan memenuhi seluruh standar fungsional serta keamanan inventaris laboratorium sekolah.
