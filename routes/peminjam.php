<?php
// routes/peminjam.php
$route = $_GET['route'] ?? '';

switch ($route) {
    case 'peminjam/dashboard':
        RoleMiddleware::allow(['peminjam']);
        $peminjamanModel = new Peminjaman();
        $alatModel = new Alat();

        $stats = $peminjamanModel->countUserStats($_SESSION['user_id']);
        $alats = $alatModel->getAll(null, null, true);
        $riwayats = $peminjamanModel->getAll(null, $_SESSION['user_id']);

        require_once __DIR__ . '/../views/peminjam/dashboard.php';
        break;

    case 'peminjam/daftar-alat':
        $controller = new PeminjamanController();
        $controller->peminjamDaftarAlat();
        break;

    case 'peminjam/pengajuan':
        $controller = new PeminjamanController();
        $controller->peminjamPengajuanForm();
        break;

    case 'peminjam/pengajuan/store':
        $controller = new PeminjamanController();
        $controller->peminjamStorePengajuan();
        break;

    case 'peminjam/riwayat':
        $controller = new PeminjamanController();
        $controller->peminjamRiwayat();
        break;

    case 'peminjam/pengembalian':
        $controller = new PeminjamanController();
        $controller->peminjamPengembalianIndex();
        break;

    case 'peminjam/pengembalian/proses':
        $controller = new PeminjamanController();
        $controller->peminjamProsesPengembalian();
        break;

    default:
        return false;
}
return true;
