<?php
$page_title = 'Dashboard Admin - Sistem Peminjaman Lab';
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

// Ambil daftar user peminjam khusus untuk tabel admin
$userModel = new User();
$daftarPeminjam = $userModel->getAll('peminjam');
?>

<header class="page-heading mb-4">
    <div>
        <p class="eyebrow-label mb-2">Administrasi sistem</p>
        <h1 class="h3 mb-1">Peminjaman alat</h1>
        <p class="text-muted mb-0">Ringkasan inventaris, akun, dan aktivitas yang perlu dipantau.</p>
    </div>
    <div class="page-heading-actions">
        <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/alat/create" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah alat</a>
        <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/users/create" class="btn btn-outline-secondary">Tambah pengguna</a>
    </div>
</header>

<nav class="action-strip mb-4" aria-label="Aksi administrasi">
    <span class="action-strip-label">Akses cepat</span>
    <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/alat"><i class="bi bi-box-seam me-1"></i>Inventaris</a>
    <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/users"><i class="bi bi-people me-1"></i>Pengguna</a>
    <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/log-aktivitas"><i class="bi bi-clock-history me-1"></i>Log aktivitas</a>
</nav>

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
                        <h6 class="text-dark fw-bold mb-1 small text-uppercase">Total Pengguna</h6>
                        <h2 class="fw-bold text-dark mb-0"><?php echo number_format((int)$totalUsers); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top small text-dark fw-semibold d-flex justify-content-between">
                    <span>Admin: <strong class="text-primary"><?php echo (int)$totalAdmin; ?></strong></span>
                    <span>Petugas: <strong class="text-primary"><?php echo (int)$totalPetugas; ?></strong></span>
                    <span>Peminjam: <strong class="text-primary"><?php echo (int)$totalPeminjam; ?></strong></span>
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
                        <h6 class="text-dark fw-bold mb-1 small text-uppercase">Kategori Alat</h6>
                        <h2 class="fw-bold text-dark mb-0"><?php echo number_format((int)$totalKategori); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top text-dark small fw-semibold d-flex align-items-center">
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
                        <h6 class="text-dark fw-bold mb-1 small text-uppercase">Jenis Alat</h6>
                        <h2 class="fw-bold text-dark mb-0"><?php echo number_format((int)$totalAlat); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top text-dark small fw-semibold d-flex align-items-center">
                    <i class="bi bi-building text-info me-1"></i> Pusat Inventaris & Laboratorium
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
                        <h6 class="text-dark fw-bold mb-1 small text-uppercase">Total Stok Fisik</h6>
                        <h2 class="fw-bold text-dark mb-0"><?php echo number_format((int)$totalStok); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top text-dark small fw-semibold d-flex align-items-center">
                    <i class="bi bi-shield-check text-warning me-1"></i> Unit Terdata Aman
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8"><div class="alert alert-info border-0 shadow-sm mb-0 h-100 d-flex align-items-center"><i class="bi bi-info-circle-fill fs-4 me-3"></i><span><strong>Kontrol sistem:</strong> gunakan menu Data Alat, Kategori, dan Pengguna untuk menjaga data inventaris tetap akurat.</span></div></div>
    <div class="col-lg-4"><div class="card border-0 shadow-sm h-100"><div class="card-body d-flex align-items-center gap-3"><div class="rounded-3 bg-success bg-opacity-10 text-success p-3 fs-4"><i class="bi bi-activity"></i></div><div><div class="small text-muted text-uppercase fw-bold">Kesehatan inventaris</div><div class="fw-bold text-dark"><?php echo $totalStok > 0 ? 'Operasional aktif' : 'Perlu data awal'; ?></div><small class="text-muted"><?php echo (int)$totalStok; ?> unit tercatat di sistem</small></div></div></div></div>
</div>

<div class="card border-0 shadow-sm mb-4"><div class="card-body py-3"><div class="d-flex flex-wrap align-items-center justify-content-between gap-2"><div><span class="fw-bold text-dark"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Prioritas hari ini</span><span class="small text-muted ms-2">Pantau area yang membutuhkan perhatian.</span></div><div class="d-flex gap-2"><a class="btn btn-sm btn-outline-warning rounded-pill" href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/alat">Stok menipis: <?php echo count($lowStockAlats); ?></a><a class="btn btn-sm btn-outline-primary rounded-pill" href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/log-aktivitas">Audit terbaru</a></div></div></div></div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-bold py-3 px-4 border-0 d-flex justify-content-between align-items-center">
        <span class="text-dark"><i class="bi bi-exclamation-diamond-fill text-warning me-2"></i>Monitoring Stok Menipis</span>
        <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/alat" class="btn btn-sm btn-outline-primary rounded-pill">Kelola Alat</a>
    </div>
    <div class="card-body p-0">
        <?php if (empty($lowStockAlats)): ?>
            <div class="p-4 text-success fw-semibold"><i class="bi bi-check-circle-fill me-2"></i>Semua stok alat berada di level aman.</div>
        <?php else: ?>
            <div class="table-responsive"><table class="table table-hover align-middle mb-0 small">
                <thead class="table-light"><tr><th class="ps-4">Nama Alat</th><th>Kondisi</th><th class="text-center">Stok</th></tr></thead>
                <tbody><?php foreach ($lowStockAlats as $alat): ?><tr>
                    <td class="ps-4 fw-semibold"><?php echo htmlspecialchars($alat['nama_alat']); ?></td>
                    <td><?php echo htmlspecialchars($alat['kondisi']); ?></td>
                    <td class="text-center"><span class="badge bg-<?php echo $alat['stok'] == 0 ? 'danger' : 'warning text-dark'; ?>"><?php echo (int)$alat['stok']; ?> unit</span></td>
                </tr><?php endforeach; ?></tbody>
            </table></div>
        <?php endif; ?>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Tabel Data Peminjam -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                <span class="d-flex align-items-center text-dark">
                    <i class="bi bi-people-fill text-primary fs-5 me-2"></i> Daftar Data Peminjam Aktif
                </span>
                <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/users" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">Kelola User</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 text-dark fw-bold text-uppercase">No</th>
                                <th class="py-3 text-dark fw-bold text-uppercase">Nama Lengkap</th>
                                <th class="py-3 text-dark fw-bold text-uppercase">Username</th>
                                <th class="pe-4 py-3 text-dark fw-bold text-uppercase">Tanggal Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($daftarPeminjam)): ?>
                                <tr><td colspan="4" class="text-center py-4 text-dark fw-semibold">Belum ada data peminjam.</td></tr>
                            <?php else: ?>
                                <?php foreach ($daftarPeminjam as $index => $p): ?>
                                    <tr>
                                        <td class="ps-4 py-3 text-dark fw-bold"><?php echo $index + 1; ?></td>
                                        <td class="fw-bold text-dark py-3"><i class="bi bi-person-badge text-primary me-2"></i><?php echo htmlspecialchars($p['nama_lengkap'] ?? ''); ?></td>
                                        <td class="py-3"><code><?php echo htmlspecialchars($p['username'] ?? ''); ?></code></td>
                                        <td class="pe-4 py-3 text-dark fw-semibold"><?php echo htmlspecialchars($p['created_at'] ?? ''); ?></td>
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

<div class="row g-4 mb-4">
    <!-- Notifikasi Stok Menipis -->
    <div class="col-xl-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                <span class="d-flex align-items-center text-dark">
                    <i class="bi bi-exclamation-triangle-fill text-warning fs-5 me-2"></i> Peringatan Stok Alat Menipis (&le; 2)
                </span>
                <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill"><?php 
                    $lowStockItems = (new Alat())->getLowStock(2);
                    echo count($lowStockItems); 
                ?> Item</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle small">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 text-dark fw-bold">Nama Alat</th>
                                <th class="text-center py-3 text-dark fw-bold">Sisa Stok</th>
                                <th class="pe-4 py-3 text-dark fw-bold">Kondisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($lowStockItems)): ?>
                                <tr><td colspan="3" class="text-center py-4 text-dark fw-semibold">Semua stok alat aman (di atas 2 unit).</td></tr>
                            <?php else: ?>
                                <?php foreach ($lowStockItems as $item): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark py-3"><i class="bi bi-tools text-warning me-1"></i><?php echo htmlspecialchars($item['nama_alat']); ?></td>
                                        <td class="text-center"><span class="badge bg-danger text-white px-3 py-2 fw-bold"><?php echo (int)$item['stok']; ?> unit</span></td>
                                        <td class="pe-4"><span class="badge bg-light text-dark border px-2 py-1"><?php echo htmlspecialchars($item['kondisi']); ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Kategori Alat -->
    <div class="col-xl-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-3 px-4 border-0 d-flex align-items-center">
                <i class="bi bi-bar-chart-fill text-primary fs-5 me-2"></i> <span class="text-dark">Statistik Alat per Kategori</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle small">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 text-dark fw-bold">Kategori</th>
                                <th class="text-center py-3 text-dark fw-bold">Total Jenis</th>
                                <th class="pe-4 py-3 text-dark fw-bold">Total Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($kategoriStats)): ?>
                                <tr><td colspan="3" class="text-center py-4 text-dark fw-semibold">Belum ada kategori alat.</td></tr>
                            <?php else: ?>
                                <?php foreach ($kategoriStats as $stat): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark py-3"><i class="bi bi-tag text-primary me-1"></i><?php echo htmlspecialchars($stat['nama_kategori']); ?></td>
                                        <td class="text-center"><?php echo (int)$stat['total_alat']; ?> item</td>
                                        <td class="pe-4"><span class="badge bg-primary text-white rounded-pill px-3"><?php echo (int)$stat['total_stok']; ?> unit</span></td>
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
            <div class="card-header bg-white fw-bold py-3 px-4 border-0 d-flex align-items-center">
                <i class="bi bi-bar-chart-fill text-primary fs-5 me-2"></i> <span class="text-dark">Statistik Alat per Kategori</span>
            </div>
            <div class="card-body px-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 text-dark fw-bold small text-uppercase">Kategori</th>
                                <th class="text-center py-3 text-dark fw-bold small text-uppercase">Jenis Alat</th>
                                <th class="text-center py-3 text-dark fw-bold small text-uppercase">Total Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kategoriStats as $stat): ?>
                                <tr>
                                    <td class="fw-bold text-dark py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded p-2 me-3 text-primary"><i class="bi bi-tag"></i></div>
                                            <?php echo htmlspecialchars($stat['nama_kategori'] ?? ''); ?>
                                        </div>
                                    </td>
                                    <td class="text-center"><span class="badge bg-secondary text-white rounded-pill px-3 py-2 fw-semibold"><?php echo (int)($stat['total_alat'] ?? 0); ?> item</span></td>
                                    <td class="text-center"><span class="badge bg-primary text-white rounded-pill px-3 py-2 fw-semibold"><?php echo (int)($stat['total_stok'] ?? 0); ?> unit</span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                <span class="d-flex align-items-center text-dark">
                    <i class="bi bi-clock-history text-primary fs-5 me-2"></i> Aktivitas Sistem Terbaru
                </span>
                <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/log-aktivitas" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle small">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 text-dark fw-bold small text-uppercase">Waktu</th>
                                <th class="py-3 text-dark fw-bold small text-uppercase">User</th>
                                <th class="pe-4 py-3 text-dark fw-bold small text-uppercase">Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recentLogs)): ?>
                                <tr><td colspan="3" class="text-center py-4 text-dark fw-semibold">Belum ada aktivitas tercatat.</td></tr>
                            <?php else: ?>
                                <?php foreach ($recentLogs as $log): ?>
                                    <tr>
                                        <td class="ps-4 text-dark fw-semibold py-3" style="white-space: nowrap;"><i class="bi bi-clock me-1 text-primary"></i><?php echo htmlspecialchars($log['created_at'] ?? ''); ?></td>
                                        <td class="py-3"><span class="fw-bold text-dark"><i class="bi bi-person-circle text-primary me-1"></i><?php echo htmlspecialchars($log['username'] ?? ''); ?></span></td>
                                        <td class="pe-4 py-3"><span class="badge bg-light text-dark border border-secondary px-2 py-1 fw-semibold"><?php echo htmlspecialchars($log['aktivitas'] ?? ''); ?></span></td>
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

<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold py-3 px-4 border-0 d-flex align-items-center">
                <i class="bi bi-graph-up-arrow text-primary fs-5 me-2"></i> <span class="text-dark">Grafik Distribusi Stok Alat per Kategori</span>
            </div>
            <div class="card-body">
                <canvas id="kategoriChart" height="90"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('kategoriChart').getContext('2d');
    
    const kategoriLabels = [
        <?php foreach ($kategoriStats as $stat) { echo '"' . addslashes($stat['nama_kategori']) . '",'; } ?>
    ];
    const kategoriStok = [
        <?php foreach ($kategoriStats as $stat) { echo (int)$stat['total_stok'] . ','; } ?>
    ];
    const kategoriTotalAlat = [
        <?php foreach ($kategoriStats as $stat) { echo (int)$stat['total_alat'] . ','; } ?>
    ];

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: kategoriLabels,
            datasets: [{
                label: 'Total Stok Unit',
                data: kategoriStok,
                backgroundColor: 'rgba(255, 85, 0, 0.8)',
                borderColor: '#1a1a1a',
                borderWidth: 2,
                borderRadius: 8
            }, {
                label: 'Jumlah Jenis Alat',
                data: kategoriTotalAlat,
                backgroundColor: 'rgba(255, 208, 0, 0.8)',
                borderColor: '#1a1a1a',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
