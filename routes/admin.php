<?php
// routes/admin.php
$route = $_GET['route'] ?? '';

switch ($route) {
    case 'admin/dashboard':
        RoleMiddleware::allow(['admin']);
        $userModel = new User();
        $kategoriModel = new Kategori();
        $alatModel = new Alat();
        $peminjamanModel = new Peminjaman();
        $logModel = new LogAktivitas();

        $totalUsers = $userModel->countAll();
        $totalAdmin = $userModel->countByRole('admin');
        $totalPetugas = $userModel->countByRole('petugas');
        $totalPeminjam = $userModel->countByRole('peminjam');
        $totalKategori = $kategoriModel->countAll();
        $totalAlat = $alatModel->countAll();
        $totalStok = $alatModel->sumStok();
        $kategoriStats = $alatModel->getByCategoryStats();
        $recentLogs = $logModel->getAll(10);
        $daftarPeminjam = $userModel->getAll('peminjam');

        require_once __DIR__ . '/../views/admin/dashboard.php';
        break;

    case 'admin/peminjam':
        RoleMiddleware::allow(['admin']);
        $userModel = new User();
        $search = $_GET['search'] ?? '';
        $daftarPeminjam = $userModel->getAll('peminjam', $search);
        
        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/admin/peminjam.php';
        break;

    case 'admin/pengembalian':
        RoleMiddleware::allow(['admin']);
        $peminjamanModel = new Peminjaman();
        $peminjamans = $peminjamanModel->getAll('disetujui');
        $riwayatSelesai = $peminjamanModel->getAll('selesai');

        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/admin/pengembalian.php';
        break;
    case 'admin/pengembalian/update-rencana':
        $controller = new PeminjamanController();
        $controller->adminUpdateRencanaKembali();
        break;

    case 'admin/users':
        $controller = new UserController();
        $controller->index();
        break;
    case 'admin/users/create':
        $controller = new UserController();
        $controller->create();
        break;
    case 'admin/users/store':
        $controller = new UserController();
        $controller->store();
        break;
    case 'admin/users/edit':
        $controller = new UserController();
        $controller->edit();
        break;
    case 'admin/users/update':
        $controller = new UserController();
        $controller->update();
        break;
    case 'admin/users/delete':
        $controller = new UserController();
        $controller->delete();
        break;

    case 'admin/kategori':
        $controller = new KategoriController();
        $controller->index();
        break;
    case 'admin/kategori/store':
        $controller = new KategoriController();
        $controller->store();
        break;
    case 'admin/kategori/update':
        $controller = new KategoriController();
        $controller->update();
        break;
    case 'admin/kategori/delete':
        $controller = new KategoriController();
        $controller->delete();
        break;

    case 'admin/alat':
        $controller = new AlatController();
        $controller->index();
        break;
    case 'admin/alat/create':
        $controller = new AlatController();
        $controller->create();
        break;
    case 'admin/alat/store':
        $controller = new AlatController();
        $controller->store();
        break;
    case 'admin/alat/edit':
        $controller = new AlatController();
        $controller->edit();
        break;
    case 'admin/alat/update':
        $controller = new AlatController();
        $controller->update();
        break;
    case 'admin/alat/delete':
        $controller = new AlatController();
        $controller->delete();
        break;

    case 'admin/log-aktivitas':
        $controller = new LogAktivitasController();
        $controller->index();
        break;
    case 'admin/log-aktivitas/export':
        $controller = new LogAktivitasController();
        $controller->exportCsv();
        break;

    default:
        return false;
}
return true;
