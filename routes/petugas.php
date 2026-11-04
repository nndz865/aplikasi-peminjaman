<?php
// routes/petugas.php
$route = $_GET['route'] ?? '';

switch ($route) {
    case 'petugas/dashboard':
        RoleMiddleware::allow(['petugas']);
        $peminjamanModel = new Peminjaman();
        $alatModel = new Alat();

        $totalPengajuan = $peminjamanModel->countAll();
        $pengajuanMenunggu = $peminjamanModel->countByStatus('menunggu');
        $peminjamanDisetujui = $peminjamanModel->countByStatus('disetujui');
        $peminjamanSelesai = $peminjamanModel->countByStatus('selesai');
        $pengembalianTerlambat = $peminjamanModel->countTerlambat();
        $totalDenda = $peminjamanModel->sumTotalDenda();
        $recentPengajuan = $peminjamanModel->getAll(null, null);

        require_once __DIR__ . '/../views/petugas/dashboard.php';
        break;

    case 'petugas/persetujuan':
        $controller = new PeminjamanController();
        $controller->petugasPersetujuanIndex();
        break;
    case 'petugas/persetujuan/ubah-status':
        $controller = new PeminjamanController();
        $controller->petugasUbahStatus();
        break;
    case 'petugas/persetujuan/setujui':
        $controller = new PeminjamanController();
        $controller->petugasSetujui();
        break;
    case 'petugas/persetujuan/tolak':
        $controller = new PeminjamanController();
        $controller->petugasTolak();
        break;

    case 'petugas/pengembalian':
        $controller = new PeminjamanController();
        $controller->petugasPengembalianIndex();
        break;
    case 'petugas/pengembalian/update-rencana':
        $controller = new PeminjamanController();
        $controller->petugasUpdateRencanaKembali();
        break;
    case 'petugas/pengembalian/proses':
        $controller = new PeminjamanController();
        $controller->petugasProsesPengembalian();
        break;

    case 'petugas/laporan':
        $controller = new LaporanController();
        $controller->index();
        break;

    default:
        return false;
}
return true;
