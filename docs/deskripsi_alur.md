# DOKUMENTASI ALUR SISTEM (PSEUDOCODE)
## APLIKASI PEMINJAMAN ALAT UKK RPL 2026/2027

---

### 1. PSEUDOCODE: AUTENTIKASI & LOGIN
```text
FUNCTION processLogin(username, password):
    INPUT: username, password dari form login
    
    // Validasi input kosong
    IF username IS EMPTY OR password IS EMPTY THEN
        RETURN error("Username dan Password wajib diisi")
    END IF

    // Cari user di database
    user = Database.query("SELECT * FROM users WHERE username = ?", [username])
    
    IF user NOT FOUND THEN
        RETURN error("Username atau Password salah")
    END IF

    // Verifikasi password hash
    IF PASSWORD_VERIFY(password, user.password) THEN
        // Set session
        SESSION['user_id'] = user.id_user
        SESSION['username'] = user.username
        SESSION['nama_lengkap'] = user.nama_lengkap
        SESSION['role'] = user.role
        SESSION['csrf_token'] = GENERATE_CSRF_TOKEN()

        // Redirect sesuai role
        IF user.role == 'admin' THEN
            REDIRECT("index.php?route=admin/dashboard")
        ELSE IF user.role == 'petugas' THEN
            REDIRECT("index.php?route=petugas/dashboard")
        ELSE IF user.role == 'peminjam' THEN
            REDIRECT("index.php?route=peminjam/dashboard")
        END IF
    ELSE
        RETURN error("Username atau Password salah")
    END IF
END FUNCTION
```

---

### 2. PSEUDOCODE: PENGAJUAN PEMINJAMAN ALAT
```text
FUNCTION ajukanPeminjaman(id_user, id_alat, jumlah, tanggal_pinjam, tanggal_rencana_kembali, keperluan):
    // Validasi dasar
    IF jumlah <= 0 THEN
        RETURN error("Jumlah peminjaman harus lebih dari nol")
    END IF

    IF tanggal_rencana_kembali < tanggal_pinjam THEN
        RETURN error("Tanggal rencana kembali tidak boleh sebelum tanggal pinjam")
    END IF

    // Eksekusi Stored Procedure MySQL (sp_pinjam_alat)
    // SP ini menangani transaksi, lock baris (FOR UPDATE), validasi stok, 
    // pembuatan kode unik (PJM-YYYYMMDD-XXXX), dan insert status 'menunggu'
    
    stmt = DB.prepare("CALL sp_pinjam_alat(?, ?, ?, ?, ?, ?, @res, @msg)")
    stmt.execute([id_user, id_alat, jumlah, tanggal_pinjam, tanggal_rencana_kembali, keperluan])
    
    result = DB.query("SELECT @res AS result, @msg AS message").fetch()

    IF result.result == 1 THEN
        RETURN success(result.message)
    ELSE
        RETURN error(result.message)
    END IF
END FUNCTION
```

---

### 3. PSEUDOCODE: PROSES PENGEMBALIAN & PERHITUNGAN DENDA
```text
FUNCTION prosesPengembalian(id_peminjaman, tanggal_kembali_aktual):
    // Ambil data peminjaman
    peminjaman = Database.query("SELECT * FROM peminjaman WHERE id_peminjaman = ?", [id_peminjaman])

    IF peminjaman NOT FOUND OR peminjaman.status != 'disetujui' THEN
        RETURN error("Transaksi tidak valid atau belum disetujui")
    END IF

    IF tanggal_kembali_aktual < peminjaman.tanggal_pinjam THEN
        RETURN error("Tanggal kembali aktual tidak boleh lebih awal dari tanggal pinjam")
    END IF

    // Hitung denda menggunakan Stored Function MySQL hitung_denda()
    // Tarif denda: Rp 5.000 / hari keterlambatan
    stmtDenda = DB.prepare("SELECT hitung_denda(?, ?) as denda")
    stmtDenda.execute([peminjaman.tanggal_rencana_kembali, tanggal_kembali_aktual])
    resDenda = stmtDenda.fetch()
    denda = resDenda.denda OR 0

    // Update database dalam transaksi
    BEGIN TRANSACTION
    TRY
        // Update tanggal aktual, denda, dan status jadi 'selesai'
        // Trigger trg_tambah_stok akan otomatis mengembalikan stok alat ke tabel alat
        DB.query("UPDATE peminjaman SET tanggal_kembali_aktual = ?, denda = ?, status = 'selesai' WHERE id_peminjaman = ?", 
                 [tanggal_kembali_aktual, denda, id_peminjaman])

        COMMIT TRANSACTION
        RETURN success("Pengembalian berhasil. Denda: Rp " + FORMAT_CURRENCY(denda))
    CATCH
        ROLLBACK TRANSACTION
        RETURN error("Gagal memproses pengembalian")
    END TRY
END FUNCTION
```
