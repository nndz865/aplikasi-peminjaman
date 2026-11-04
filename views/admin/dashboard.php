<?php
$page_title = 'Dashboard Admin - Aplikasi Peminjaman Alat UKK RPL';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
require_once __DIR__ . '/../layouts/navbar.php';

$totalUsers = $totalUsers ?? 0;
$totalAdmin = $totalAdmin ?? 0;
$totalPetugas = $totalPetugas ?? 0;
$totalPeminjam = $totalPeminjam ?? 0;
$totalKategori = $totalKategori ?? 0;
$totalAlat = $totalAlat ?? 0;
$totalStok = $totalStok ?? 0;
$kategoriStats = $kategoriStats ?? [];
$recentLogs = $recentLogs ?? [];
$baseUrl = $config['base_url'] ?? '';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</h3>
    <span class="text-muted">Ringkasan Sistem & Manajemen Inventaris</span>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white p-3 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white-50 mb-1">Total Pengguna</h6>
                    <h3 class="fw-bold mb-0"><?php echo (int)$totalUsers; ?></h3>
                </div>
                <div class="fs-1 text-white-50"><i class="bi bi-people"></i></div>
            </div>
            <div class="mt-3 small text-white-50">
                Admin: <?php echo (int)$totalAdmin; ?> | Petugas: <?php echo (int)$totalPetugas; ?> | Peminjam: <?php echo (int)$totalPeminjam; ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white p-3 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white-50 mb-1">Total Kategori</h6>
                    <h3 class="fw-bold mb-0"><?php echo (int)$totalKategori; ?></h3>
                </div>
                <div class="fs-1 text-white-50"><i class="bi bi-tags"></i></div>
            </div>
            <div class="mt-3 small text-white-50">Kategori Alat Ukur & Praktikum</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white p-3 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white-50 mb-1">Total Jenis Alat</h6>
                    <h3 class="fw-bold mb-0"><?php echo (int)$totalAlat; ?></h3>
                </div>
                <div class="fs-1 text-white-50"><i class="bi bi-cpu"></i></div>
            </div>
            <div class="mt-3 small text-white-50">Variasi Alat Tersedia</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark p-3 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-dark-50 mb-1">Total Stok Fisik</h6>
                    <h3 class="fw-bold mb-0"><?php echo (int)$totalStok; ?></h3>
                </div>
                <div class="fs-1 text-dark-50"><i class="bi bi-box-seam"></i></div>
            </div>
            <div class="mt-3 small text-dark">Keseluruhan Unit Alat</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Statistik Kategori -->
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-3">
                <i class="bi bi-bar-chart-fill me-2 text-primary"></i> Statistik Alat per Kategori
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Kategori</th>
                                <th class="text-center">Jenis Alat</th>
                                <th class="text-center">Total Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kategoriStats as $stat): ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo htmlspecialchars($stat['nama_kategori'] ?? ''); ?></td>
                                    <td class="text-center"><span class="badge bg-secondary"><?php echo (int)($stat['total_alat'] ?? 0); ?></span></td>
                                    <td class="text-center"><span class="badge bg-primary"><?php echo (int)($stat['total_stok'] ?? 0); ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-3 d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2 text-primary"></i> Aktivitas Terbaru</span>
                <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/log-aktivitas" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle small">
                        <thead class="table-light">
                            <tr>
                                <th>Waktu</th>
                                <th>User</th>
                                <th>Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentLogs as $log): ?>
                                <tr>
                                    <td class="text-muted" style="white-space: nowrap;"><?php echo htmlspecialchars($log['created_at'] ?? ''); ?></td>
                                    <td><span class="fw-semibold"><?php echo htmlspecialchars($log['username'] ?? ''); ?></span></td>
                                    <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($log['aktivitas'] ?? ''); ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
