<?php
require_once __DIR__ . '/../models/Peminjaman.php';
require_once __DIR__ . '/../models/LogAktivitas.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

class PeminjamanController {
    // ----------------- PEMINJAM ACTIONS -----------------
    public function peminjamDaftarAlat() {
        RoleMiddleware::allow(['peminjam']);
        $alatModel = new Alat();
        $search = $_GET['search'] ?? '';
        $alats = $alatModel->getAll(null, $search, true);

        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/peminjam/daftar-alat.php';
    }

    public function peminjamPengajuanForm() {
        RoleMiddleware::allow(['peminjam']);
        $id_alat = $_GET['id_alat'] ?? null;
        $alatModel = new Alat();
        $alat = $id_alat ? $alatModel->findById($id_alat) : null;
        $alats = $alatModel->getAll(null, null, true);

        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/peminjam/pengajuan.php';
    }

    public function peminjamStorePengajuan() {
        RoleMiddleware::allow(['peminjam']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $config = include __DIR__ . '/../config/app.php';

            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                set_flash_message('danger', 'Token CSRF tidak valid.');
                header('Location: ' . $config['base_url'] . '/index.php?route=peminjam/pengajuan');
                exit;
            }

            $id_alat = $_POST['id_alat'] ?? null;
            $jumlah = (int)($_POST['jumlah'] ?? 0);
            $tanggal_pinjam = $_POST['tanggal_pinjam'] ?? date('Y-m-d');
            $tanggal_rencana_kembali = $_POST['tanggal_rencana_kembali'] ?? '';
            $keperluan = trim($_POST['keperluan'] ?? '');

            if (!$id_alat || $jumlah <= 0 || empty($tanggal_rencana_kembali) || empty($keperluan)) {
                set_flash_message('danger', 'Semua field wajib diisi dengan benar.');
                header('Location: ' . $config['base_url'] . '/index.php?route=peminjam/pengajuan');
                exit;
            }

            $peminjamanModel = new Peminjaman();
            $result = $peminjamanModel->ajukanPinjam(
                $_SESSION['user_id'],
                $id_alat,
                $jumlah,
                $tanggal_pinjam,
                $tanggal_rencana_kembali,
                $keperluan
            );

            if ($result['result'] == 1) {
                $logModel = new LogAktivitas();
                $logModel->catat($_SESSION['user_id'], 'PENGAJUAN PINJAM', "Mengajukan peminjaman alat ID: $id_alat sebanyak $jumlah");
                set_flash_message('success', $result['message']);
                header('Location: ' . $config['base_url'] . '/index.php?route=peminjam/riwayat');
            } else {
                set_flash_message('danger', $result['message']);
                header('Location: ' . $config['base_url'] . '/index.php?route=peminjam/pengajuan&id_alat=' . $id_alat);
            }
            exit;
        }
    }

    public function peminjamRiwayat() {
        RoleMiddleware::allow(['peminjam']);
        $peminjamanModel = new Peminjaman();
        $riwayats = $peminjamanModel->getAll(null, $_SESSION['user_id']);

        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/peminjam/riwayat.php';
    }

    public function peminjamPengembalianIndex() {
        RoleMiddleware::allow(['peminjam']);
        $peminjamanModel = new Peminjaman();
        // Ambil transaksi milik peminjam yang berstatus 'disetujui' (siap dikembalikan)
        $peminjamans = $peminjamanModel->getAll('disetujui', $_SESSION['user_id']);

        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/peminjam/pengembalian.php';
    }

    public function peminjamProsesPengembalian() {
        RoleMiddleware::allow(['peminjam']);
        $config = include __DIR__ . '/../config/app.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                set_flash_message('danger', 'Token CSRF tidak valid.');
                header('Location: ' . $config['base_url'] . '/index.php?route=peminjam/pengembalian');
                exit;
            }

            $id_peminjaman = $_POST['id_peminjaman'] ?? null;
            $tanggal_kembali_aktual = $_POST['tanggal_kembali_aktual'] ?? date('Y-m-d');

            if (!$id_peminjaman || empty($tanggal_kembali_aktual)) {
                set_flash_message('danger', 'Data pengembalian tidak lengkap.');
                header('Location: ' . $config['base_url'] . '/index.php?route=peminjam/pengembalian');
                exit;
            }

            $peminjamanModel = new Peminjaman();
            $peminjaman = $peminjamanModel->findById($id_peminjaman);

            // Pastikan transaksi ini benar-benar milik user yang sedang login
            if (!$peminjaman || $peminjaman['id_user'] != $_SESSION['user_id']) {
                set_flash_message('danger', 'Transaksi tidak valid.');
                header('Location: ' . $config['base_url'] . '/index.php?route=peminjam/pengembalian');
                exit;
            }

            $result = $peminjamanModel->prosesPengembalian($id_peminjaman, $tanggal_kembali_aktual);

            if ($result['success']) {
                $logModel = new LogAktivitas();
                $logModel->catat($_SESSION['user_id'], 'PENGAJUAN PENGEMBALIAN', "Mengajukan pengembalian peminjaman ID: $id_peminjaman. Denda: Rp " . number_format($result['denda'], 0, ',', '.'));
                set_flash_message('success', 'Pengajuan pengembalian berhasil diproses. ' . $result['message']);
            } else {
                set_flash_message('danger', $result['message']);
            }

            header('Location: ' . $config['base_url'] . '/index.php?route=peminjam/riwayat');
            exit;
        }
    }

    // ----------------- PETUGAS ACTIONS -----------------
    public function petugasPersetujuanIndex() {
        RoleMiddleware::allow(['petugas']);
        $peminjamanModel = new Peminjaman();
        $status = $_GET['status'] ?? null;
        $filters = [
            'search' => $_GET['search'] ?? '',
            'start_date' => $_GET['start_date'] ?? '',
            'end_date' => $_GET['end_date'] ?? ''
        ];
        $peminjamans = $peminjamanModel->getAll($status, null, $filters);

        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/petugas/persetujuan/index.php';
    }

    public function petugasUbahStatus() {
        RoleMiddleware::allow(['petugas']);
        $id = $_GET['id'] ?? null;
        $statusBaru = $_GET['status'] ?? null;
        $config = include __DIR__ . '/../config/app.php';

        if (!$id || !in_array($statusBaru, ['menunggu', 'disetujui', 'ditolak', 'selesai'])) {
            set_flash_message('danger', 'Parameter status tidak valid.');
            header('Location: ' . $config['base_url'] . '/index.php?route=petugas/persetujuan');
            exit;
        }

        $peminjamanModel = new Peminjaman();
        $peminjaman = $peminjamanModel->findById($id);

        if (!$peminjaman) {
            set_flash_message('danger', 'Transaksi tidak ditemukan.');
            header('Location: ' . $config['base_url'] . '/index.php?route=petugas/persetujuan');
            exit;
        }

        // Jika mengubah dari disetujui ke menunggu / ditolak, kita perlu mengembalikan stok alat terlebih dahulu karena trigger trg_kurangi_stok mengurangi stok saat status berubah dari menunggu ke disetujui.
        try {
            $db = Database::getInstance()->getConnection();
            $db->beginTransaction();

            if ($peminjaman['status'] === 'disetujui' && in_array($statusBaru, ['menunggu', 'ditolak'])) {
                // Kembalikan stok alat
                $stmtStok = $db->prepare("UPDATE alat SET stok = stok + ? WHERE id_alat = ?");
                $stmtStok->execute([$peminjaman['jumlah'], $peminjaman['id_alat']]);
            } elseif ($peminjaman['status'] !== 'disetujui' && $statusBaru === 'disetujui') {
                // Kurangi stok jika sebelumnya bukan disetujui
                if ($peminjaman['stok_sekarang'] < $peminjaman['jumlah']) {
                    $db->rollBack();
                    set_flash_message('danger', 'Stok alat tidak cukup untuk mengubah status menjadi disetujui.');
                    header('Location: ' . $config['base_url'] . '/index.php?route=petugas/persetujuan');
                    exit;
                }
                $stmtStok = $db->prepare("UPDATE alat SET stok = stok - ? WHERE id_alat = ?");
                $stmtStok->execute([$peminjaman['jumlah'], $peminjaman['id_alat']]);
            }

            $stmtUp = $db->prepare("UPDATE peminjaman SET status = ? WHERE id_peminjaman = ?");
            $stmtUp->execute([$statusBaru, $id]);

            $db->commit();

            $logModel = new LogAktivitas();
            $logModel->catat($_SESSION['user_id'], 'UBAH STATUS PEMINJAMAN', "Mengubah status peminjaman ID: $id dari {$peminjaman['status']} menjadi $statusBaru");
            set_flash_message('success', "Status peminjaman berhasil diubah menjadi $statusBaru.");
        } catch (\Exception $e) {
            $db->rollBack();
            set_flash_message('danger', 'Gagal mengubah status: ' . $e->getMessage());
        }

        header('Location: ' . $config['base_url'] . '/index.php?route=petugas/persetujuan');
        exit;
    }

    public function petugasSetujui() {
        RoleMiddleware::allow(['petugas']);
        $id = $_GET['id'] ?? null;
        $config = include __DIR__ . '/../config/app.php';

        if (!$id) {
            header('Location: ' . $config['base_url'] . '/index.php?route=petugas/persetujuan');
            exit;
        }

        $peminjamanModel = new Peminjaman();
        $peminjaman = $peminjamanModel->findById($id);

        if (!$peminjaman || $peminjaman['status'] !== 'menunggu') {
            set_flash_message('danger', 'Transaksi tidak ditemukan atau sudah diproses.');
            header('Location: ' . $config['base_url'] . '/index.php?route=petugas/persetujuan');
            exit;
        }

        if ($peminjaman['stok_sekarang'] < $peminjaman['jumlah']) {
            set_flash_message('danger', 'Stok Tidak Cukup untuk menyetujui peminjaman ini.');
            header('Location: ' . $config['base_url'] . '/index.php?route=petugas/persetujuan');
            exit;
        }

        $success = $peminjamanModel->updateStatus($id, 'disetujui');
        if ($success) {
            $logModel = new LogAktivitas();
            $logModel->catat($_SESSION['user_id'], 'SETUJUI PEMINJAMAN', "Menyetujui peminjaman ID: $id (Kode: {$peminjaman['kode_peminjaman']})");
            set_flash_message('success', 'Peminjaman berhasil disetujui dan stok telah dikurangi.');
        } else {
            set_flash_message('danger', 'Gagal menyetujui peminjaman.');
        }

        header('Location: ' . $config['base_url'] . '/index.php?route=petugas/persetujuan');
        exit;
    }

    public function petugasTolak() {
        RoleMiddleware::allow(['petugas']);
        $id = $_GET['id'] ?? null;
        $config = include __DIR__ . '/../config/app.php';

        if (!$id) {
            header('Location: ' . $config['base_url'] . '/index.php?route=petugas/persetujuan');
            exit;
        }

        $peminjamanModel = new Peminjaman();
        $peminjaman = $peminjamanModel->findById($id);

        if (!$peminjaman || $peminjaman['status'] !== 'menunggu') {
            set_flash_message('danger', 'Transaksi tidak ditemukan atau sudah diproses.');
            header('Location: ' . $config['base_url'] . '/index.php?route=petugas/persetujuan');
            exit;
        }

        $success = $peminjamanModel->updateStatus($id, 'ditolak');
        if ($success) {
            $logModel = new LogAktivitas();
            $logModel->catat($_SESSION['user_id'], 'TOLAK PEMINJAMAN', "Menolak peminjaman ID: $id (Kode: {$peminjaman['kode_peminjaman']})");
            set_flash_message('success', 'Peminjaman telah ditolak.');
        } else {
            set_flash_message('danger', 'Gagal menolak peminjaman.');
        }

        header('Location: ' . $config['base_url'] . '/index.php?route=petugas/persetujuan');
        exit;
    }

    public function petugasPengembalianIndex() {
        RoleMiddleware::allow(['petugas']);
        $peminjamanModel = new Peminjaman();
        $peminjamans = $peminjamanModel->getAll('disetujui');

        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/petugas/pengembalian/index.php';
    }

    public function adminUpdateRencanaKembali() {
        RoleMiddleware::allow(['admin']);
        $config = include __DIR__ . '/../config/app.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                set_flash_message('danger', 'Token CSRF tidak valid.');
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/pengembalian');
                exit;
            }

            $id_peminjaman = $_POST['id_peminjaman'] ?? null;
            $tanggal_rencana_kembali = $_POST['tanggal_rencana_kembali'] ?? '';

            if (!$id_peminjaman || empty($tanggal_rencana_kembali)) {
                set_flash_message('danger', 'Tanggal rencana kembali tidak boleh kosong.');
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/pengembalian');
                exit;
            }

            $peminjamanModel = new Peminjaman();
            $peminjaman = $peminjamanModel->findById($id_peminjaman);

            if (!$peminjaman || $peminjaman['status'] !== 'disetujui') {
                set_flash_message('danger', 'Transaksi tidak ditemukan atau tidak aktif.');
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/pengembalian');
                exit;
            }

            if ($tanggal_rencana_kembali < $peminjaman['tanggal_pinjam']) {
                set_flash_message('danger', 'Tanggal rencana kembali tidak boleh sebelum tanggal pinjam.');
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/pengembalian');
                exit;
            }

            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("UPDATE peminjaman SET tanggal_rencana_kembali = ? WHERE id_peminjaman = ?");
            $success = $stmt->execute([$tanggal_rencana_kembali, $id_peminjaman]);

            if ($success) {
                $logModel = new LogAktivitas();
                $logModel->catat($_SESSION['user_id'], 'UPDATE RENCANA KEMBALI (ADMIN)', "Admin mengubah tanggal rencana kembali peminjaman ID: $id_peminjaman menjadi $tanggal_rencana_kembali");
                set_flash_message('success', 'Tanggal rencana kembali berhasil diperbarui.');
            } else {
                set_flash_message('danger', 'Gagal memperbarui tanggal rencana kembali.');
            }

            header('Location: ' . $config['base_url'] . '/index.php?route=admin/pengembalian');
            exit;
        }
    }

    public function petugasUpdateRencanaKembali() {
        RoleMiddleware::allow(['petugas']);
        $config = include __DIR__ . '/../config/app.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                set_flash_message('danger', 'Token CSRF tidak valid.');
                header('Location: ' . $config['base_url'] . '/index.php?route=petugas/pengembalian');
                exit;
            }

            $id_peminjaman = $_POST['id_peminjaman'] ?? null;
            $tanggal_rencana_kembali = $_POST['tanggal_rencana_kembali'] ?? '';

            if (!$id_peminjaman || empty($tanggal_rencana_kembali)) {
                set_flash_message('danger', 'Tanggal rencana kembali tidak boleh kosong.');
                header('Location: ' . $config['base_url'] . '/index.php?route=petugas/pengembalian');
                exit;
            }

            $peminjamanModel = new Peminjaman();
            $peminjaman = $peminjamanModel->findById($id_peminjaman);

            if (!$peminjaman || $peminjaman['status'] !== 'disetujui') {
                set_flash_message('danger', 'Transaksi tidak ditemukan atau tidak aktif.');
                header('Location: ' . $config['base_url'] . '/index.php?route=petugas/pengembalian');
                exit;
            }

            if ($tanggal_rencana_kembali < $peminjaman['tanggal_pinjam']) {
                set_flash_message('danger', 'Tanggal rencana kembali tidak boleh sebelum tanggal pinjam.');
                header('Location: ' . $config['base_url'] . '/index.php?route=petugas/pengembalian');
                exit;
            }

            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("UPDATE peminjaman SET tanggal_rencana_kembali = ? WHERE id_peminjaman = ?");
            $success = $stmt->execute([$tanggal_rencana_kembali, $id_peminjaman]);

            if ($success) {
                $logModel = new LogAktivitas();
                $logModel->catat($_SESSION['user_id'], 'UPDATE RENCANA KEMBALI', "Mengubah tanggal rencana kembali peminjaman ID: $id_peminjaman menjadi $tanggal_rencana_kembali");
                set_flash_message('success', 'Tanggal rencana kembali berhasil diperbarui.');
            } else {
                set_flash_message('danger', 'Gagal memperbarui tanggal rencana kembali.');
            }

            header('Location: ' . $config['base_url'] . '/index.php?route=petugas/pengembalian');
            exit;
        }
    }

    public function petugasProsesPengembalian() {
        RoleMiddleware::allow(['petugas']);
        $config = include __DIR__ . '/../config/app.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                set_flash_message('danger', 'Token CSRF tidak valid.');
                header('Location: ' . $config['base_url'] . '/index.php?route=petugas/pengembalian');
                exit;
            }

            $id_peminjaman = $_POST['id_peminjaman'] ?? null;
            $tanggal_kembali_aktual = $_POST['tanggal_kembali_aktual'] ?? date('Y-m-d');

            if (!$id_peminjaman || empty($tanggal_kembali_aktual)) {
                set_flash_message('danger', 'Data pengembalian tidak lengkap.');
                header('Location: ' . $config['base_url'] . '/index.php?route=petugas/pengembalian');
                exit;
            }

            $peminjamanModel = new Peminjaman();
            $result = $peminjamanModel->prosesPengembalian($id_peminjaman, $tanggal_kembali_aktual);

            if ($result['success']) {
                $logModel = new LogAktivitas();
                $logModel->catat($_SESSION['user_id'], 'PENGEMBALIAN ALAT', "Memproses pengembalian peminjaman ID: $id_peminjaman. Denda: Rp " . number_format($result['denda'], 0, ',', '.'));
                set_flash_message('success', $result['message']);
            } else {
                set_flash_message('danger', $result['message']);
            }

            header('Location: ' . $config['base_url'] . '/index.php?route=petugas/pengembalian');
            exit;
        }
    }
}
