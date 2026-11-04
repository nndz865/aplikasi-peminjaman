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

<!-- Premium Banner -->
<div class="card bg-gradient text-white shadow-lg mb-4 border-0 overflow-hidden position-relative" style="background: linear-gradient(135deg, #1e293b 0%, #3b82f6 100%);">
    <div class="position-absolute end-0 bottom-0 opacity-10 pe-4 pb-2">
        <i class="bi bi-tools display-1"></i>
    </div>
    <div class="card-body p-4 p-md-5 position-relative z-1">
        <span class="badge bg-white bg-opacity-25 text-white fw-semibold px-3 py-2 mb-2 rounded-pill"><i class="bi bi-shield-check me-1"></i> Panel Administrator Utama</span>
        <h1 class="display-6 fw-bold mb-2">Pengembangan Soal Aplikasi Peminjaman Alat</h1>
        <p class="lead text-white-50 mb-0">Selamat datang kembali, <strong class="text-white"><?php echo htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Administrator'); ?></strong>! Sistem pengelolaan inventaris UKK RPL 2026/2027 berjalan optimal.</p>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 bg-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary bg-opacity-10 text-primary p-3 rounded-4 fs-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Total Pengguna</h6>
                        <h2 class="fw-bold text-dark mb-0"><?php echo number_format((int)$totalUsers); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top small text-muted d-flex justify-content-between">
                    <span>Admin: <strong><?php echo (int)$totalAdmin; ?></strong></span>
                    <span>Petugas: <strong><?php echo (int)$totalPetugas; ?></strong></span>
                    <span>Peminjam: <strong><?php echo (int)$totalPeminjam; ?></strong></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 bg-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-success bg-opacity-10 text-success p-3 rounded-4 fs-3">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Kategori Alat</h6>
                        <h2 class="fw-bold text-dark mb-0"><?php echo number_format((int)$totalKategori); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top text-muted small d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-success me-1"></i> Kategori Terstruktur
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 bg-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-info bg-opacity-10 text-info p-3 rounded-4 fs-3">
                        <i class="bi bi-cpu-fill"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Jenis Alat</h6>
                        <h2 class="fw-bold text-dark mb-0"><?php echo number_format((int)$totalAlat); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top text-muted small d-flex align-items-center">
                    <i class="bi bi-tools text-info me-1"></i> Lab Praktikum RPL
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 bg-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-warning bg-opacity-10 text-warning p-3 rounded-4 fs-3">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Total Stok Fisik</h6>
                        <h2 class="fw-bold text-dark mb-0"><?php echo number_format((int)$totalStok); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top text-muted small d-flex align-items-center">
                    <i class="bi bi-shield-check text-warning me-1"></i> Unit Terdata Aman
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Statistik Kategori -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-3 px-4 border-0 d-flex align-items-center">
                <i class="bi bi-bar-chart-fill text-primary fs-5 me-2"></i> Statistik Alat per Kategori
            </div>
            <div class="card-body px-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 text-secondary small text-uppercase">Kategori</th>
                                <th class="text-center py-3 text-secondary small text-uppercase">Jenis Alat</th>
                                <th class="text-center py-3 text-secondary small text-uppercase">Total Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kategoriStats as $stat): ?>
                                <tr>
                                    <td class="fw-semibold py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded p-2 me-3 text-primary"><i class="bi bi-tag"></i></div>
                                            <?php echo htmlspecialchars($stat['nama_kategori'] ?? ''); ?>
                                        </div>
                                    </td>
                                    <td class="text-center"><span class="badge bg-light text-dark rounded-pill px-3 py-2"><?php echo (int)($stat['total_alat'] ?? 0); ?> item</span></td>
                                    <td class="text-center"><span class="badge bg-primary rounded-pill px-3 py-2"><?php echo (int)($stat['total_stok'] ?? 0); ?> unit</span></td>
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
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                <span class="d-flex align-items-center">
                    <i class="bi bi-clock-history text-primary fs-5 me-2"></i> Aktivitas Sistem Terbaru
                </span>
                <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/log-aktivitas" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle small">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary small text-uppercase">Waktu</th>
                                <th class="py-3 text-secondary small text-uppercase">User</th>
                                <th class="pe-4 py-3 text-secondary small text-uppercase">Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recentLogs)): ?>
                                <tr><td colspan="3" class="text-center py-4 text-muted">Belum ada aktivitas tercatat.</td></tr>
                            <?php else: ?>
                                <?php foreach ($recentLogs as $log): ?>
                                    <tr>
                                        <td class="ps-4 text-muted py-3" style="white-space: nowrap;"><i class="bi bi-clock me-1 text-secondary"></i><?php echo htmlspecialchars($log['created_at'] ?? ''); ?></td>
                                        <td class="py-3"><span class="fw-semibold text-dark"><i class="bi bi-person-circle text-muted me-1"></i><?php echo htmlspecialchars($log['username'] ?? ''); ?></span></td>
                                        <td class="pe-4 py-3"><span class="badge bg-light text-dark border px-2 py-1"><?php echo htmlspecialchars($log['aktivitas'] ?? ''); ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
