<?php
$page_title = 'Dashboard Petugas - Sistem Peminjaman Lab';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
require_once __DIR__ . '/../layouts/navbar.php';

$pengajuanMenunggu = $pengajuanMenunggu ?? 0;
$peminjamanDisetujui = $peminjamanDisetujui ?? 0;
$peminjamanSelesai = $peminjamanSelesai ?? 0;
$pengembalianTerlambat = $pengembalianTerlambat ?? 0;
$totalDenda = $totalDenda ?? 0;
$recentPengajuan = $recentPengajuan ?? [];
$baseUrl = $config['base_url'] ?? '';
?>

<header class="page-heading mb-4">
    <div>
        <p class="eyebrow-label mb-2">Operasional peminjaman</p>
        <h1 class="h3 mb-1">Validasi dan pengembalian</h1>
        <p class="text-muted mb-0">Tinjau pengajuan, proses pengembalian, dan pantau transaksi berjalan.</p>
    </div>
    <div class="page-heading-actions">
        <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=petugas/persetujuan&status=menunggu" class="btn btn-primary">Tinjau pengajuan</a>
        <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=petugas/laporan" class="btn btn-outline-secondary">Laporan</a>
    </div>
</header>

<!-- Quick actions -->
<div class="row g-3 mb-4">
    <div class="col-md-4"><a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=petugas/persetujuan&status=menunggu" class="card h-100 text-decoration-none text-dark"><div class="card-body d-flex align-items-center gap-3"><i class="bi bi-check2-square fs-3 text-warning"></i><div><strong>Validasi Pengajuan</strong><div class="small text-muted">Tinjau permintaan yang menunggu</div></div><i class="bi bi-arrow-up-right ms-auto"></i></div></a></div>
    <div class="col-md-4"><a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=petugas/pengembalian" class="card h-100 text-decoration-none text-dark"><div class="card-body d-flex align-items-center gap-3"><i class="bi bi-arrow-return-left fs-3 text-primary"></i><div><strong>Proses Pengembalian</strong><div class="small text-muted">Periksa alat yang sedang dipinjam</div></div><i class="bi bi-arrow-up-right ms-auto"></i></div></a></div>
    <div class="col-md-4"><a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=petugas/laporan" class="card h-100 text-decoration-none text-dark"><div class="card-body d-flex align-items-center gap-3"><i class="bi bi-file-earmark-bar-graph fs-3 text-success"></i><div><strong>Buka Laporan</strong><div class="small text-muted">Analisis transaksi laboratorium</div></div><i class="bi bi-arrow-up-right ms-auto"></i></div></a></div>
</div>

<!-- Statistik Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 bg-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-warning bg-opacity-10 text-warning p-3 rounded-4 fs-3">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-dark fw-bold mb-1 small text-uppercase">Menunggu Validasi</h6>
                        <h2 class="fw-bold text-dark mb-0"><?php echo number_format((int)$pengajuanMenunggu); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top small">
                    <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=petugas/persetujuan&status=menunggu" class="text-warning fw-bold text-decoration-none d-flex align-items-center justify-content-between">
                        <span>Proses Pengajuan</span> <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 bg-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary bg-opacity-10 text-primary p-3 rounded-4 fs-3">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-dark fw-bold mb-1 small text-uppercase">Pinjaman Disetujui</h6>
                        <h2 class="fw-bold text-dark mb-0"><?php echo number_format((int)$peminjamanDisetujui); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top text-dark small fw-semibold d-flex align-items-center">
                    <i class="bi bi-box-seam text-primary me-1"></i> Sedang Dipinjam Siswa
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 bg-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-success bg-opacity-10 text-success p-3 rounded-4 fs-3">
                        <i class="bi bi-clipboard-check-fill"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-dark fw-bold mb-1 small text-uppercase">Peminjaman Selesai</h6>
                        <h2 class="fw-bold text-dark mb-0"><?php echo number_format((int)$peminjamanSelesai); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top text-dark small fw-semibold d-flex align-items-center">
                    <i class="bi bi-arrow-return-left text-success me-1"></i> Stok Kembali Utuh
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 bg-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-danger bg-opacity-10 text-danger p-3 rounded-4 fs-3">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-dark fw-bold mb-1 small text-uppercase">Terlambat & Denda</h6>
                        <h2 class="fw-bold text-dark mb-0"><?php echo number_format((int)$pengembalianTerlambat); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top text-danger small fw-bold">
                    Denda: Rp <?php echo number_format((float)$totalDenda, 0, ',', '.'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($pengajuanMenunggu > 0 || $pengembalianTerlambat > 0): ?>
<div class="alert alert-warning border-0 shadow-sm d-flex align-items-center justify-content-between mb-4">
    <div><i class="bi bi-bell-fill me-2"></i><strong>Perlu tindakan:</strong> <?php echo (int)$pengajuanMenunggu; ?> pengajuan menunggu<?php echo $pengembalianTerlambat > 0 ? ' dan ' . (int)$pengembalianTerlambat . ' pengembalian terlambat.' : '.'; ?></div>
    <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=petugas/persetujuan" class="btn btn-sm btn-dark">Tinjau Sekarang</a>
</div>
<?php else: ?>
<div class="alert alert-success border-0 shadow-sm mb-4"><i class="bi bi-check-circle-fill me-2"></i><strong>Semua terkendali.</strong> Tidak ada pengajuan atau pengembalian yang membutuhkan tindakan segera.</div>
<?php endif; ?>

<div class="card border-0 shadow-sm mb-4"><div class="card-body py-3"><div class="d-flex flex-wrap align-items-center justify-content-between gap-2"><div><span class="fw-bold text-dark"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Panel operasional</span><span class="small text-muted ms-2">Akses cepat untuk menjaga alur transaksi tetap lancar.</span></div><div class="d-flex gap-2"><a class="btn btn-sm btn-outline-warning rounded-pill" href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=petugas/persetujuan&status=menunggu">Menunggu: <?php echo (int)$pengajuanMenunggu; ?></a><a class="btn btn-sm btn-outline-danger rounded-pill" href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=petugas/pengembalian">Terlambat: <?php echo (int)$pengembalianTerlambat; ?></a></div></div></div></div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-bold py-3 px-4 d-flex justify-content-between align-items-center border-0">
        <span class="d-flex align-items-center text-dark">
            <i class="bi bi-bar-chart-line text-primary fs-5 me-2"></i> Grafik Statistik Status Transaksi Lab
        </span>
    </div>
    <div class="card-body">
        <canvas id="petugasStatsChart" height="70"></canvas>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold py-3 px-4 d-flex justify-content-between align-items-center border-0">
        <span class="d-flex align-items-center text-dark">
            <i class="bi bi-list-check text-primary fs-5 me-2"></i> Pengajuan Peminjaman Terbaru
        </span>
        <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=petugas/persetujuan" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">Kelola Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3 text-dark fw-bold small text-uppercase">Kode</th>
                        <th class="py-3 text-dark fw-bold small text-uppercase">Peminjam</th>
                        <th class="py-3 text-dark fw-bold small text-uppercase">Nama Alat</th>
                        <th class="text-center py-3 text-dark fw-bold small text-uppercase">Jumlah</th>
                        <th class="py-3 text-dark fw-bold small text-uppercase">Tgl Pinjam</th>
                        <th class="py-3 text-dark fw-bold small text-uppercase">Rencana Kembali</th>
                        <th class="py-3 text-dark fw-bold small text-uppercase">Status</th>
                        <th class="text-end pe-4 py-3 text-dark fw-bold small text-uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentPengajuan)): ?>
                        <tr><td colspan="8" class="text-center py-4 text-dark fw-semibold">Belum ada pengajuan peminjaman.</td></tr>
                    <?php else: ?>
                        <?php $count = 0; foreach ($recentPengajuan as $p): if ($count++ >= 5) break; ?>
                            <tr>
                                <td class="ps-4 py-3 text-dark fw-semibold"><code><?php echo htmlspecialchars($p['kode_peminjaman'] ?? ''); ?></code></td>
                                <td class="fw-bold text-dark py-3"><?php echo htmlspecialchars($p['nama_lengkap'] ?? ''); ?></td>
                                <td class="text-dark fw-semibold py-3"><?php echo htmlspecialchars($p['nama_alat'] ?? ''); ?></td>
                                <td class="text-center py-3"><span class="badge bg-secondary text-white rounded-pill px-3 fw-semibold"><?php echo (int)($p['jumlah'] ?? 0); ?> unit</span></td>
                                <td class="text-dark py-3"><?php echo htmlspecialchars($p['tanggal_pinjam'] ?? ''); ?></td>
                                <td class="text-dark py-3"><?php echo htmlspecialchars($p['tanggal_rencana_kembali'] ?? ''); ?></td>
                                <td class="py-3">
                                    <?php 
                                        $status = $p['status'] ?? 'menunggu';
                                        $badgeClass = ($status === 'menunggu') ? 'bg-warning text-dark' : (($status === 'disetujui') ? 'bg-primary text-white' : (($status === 'selesai') ? 'bg-success text-white' : 'bg-danger text-white'));
                                    ?>
                                    <span class="badge <?php echo $badgeClass; ?> text-capitalize px-3 py-2 rounded-pill fw-semibold">
                                        <?php echo htmlspecialchars($status); ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4 py-3">
                                    <?php if ($status === 'menunggu'): ?>
                                        <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=petugas/persetujuan/setujui&id=<?php echo (int)$p['id_peminjaman']; ?>" class="btn btn-sm btn-success rounded-pill px-3 me-1 fw-semibold" title="Setujui">
                                            <i class="bi bi-check-lg me-1"></i> Setujui
                                        </a>
                                        <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=petugas/persetujuan/tolak&id=<?php echo (int)$p['id_peminjaman']; ?>" class="btn btn-sm btn-danger rounded-pill px-3 fw-semibold" title="Tolak">
                                            <i class="bi bi-x-lg me-1"></i> Tolak
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small fw-semibold">Selesai/Diproses</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('petugasStatsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Menunggu Validasi', 'Sedang Dipinjam', 'Peminjaman Selesai', 'Terlambat/Denda'],
            datasets: [{
                label: 'Jumlah Transaksi',
                data: [
                    <?php echo (int)$pengajuanMenunggu; ?>,
                    <?php echo (int)$peminjamanDisetujui; ?>,
                    <?php echo (int)$peminjamanSelesai; ?>,
                    <?php echo (int)$pengembalianTerlambat; ?>
                ],
                backgroundColor: [
                    'rgba(255, 208, 0, 0.8)',
                    'rgba(13, 110, 253, 0.8)',
                    'rgba(25, 135, 84, 0.8)',
                    'rgba(220, 53, 69, 0.8)'
                ],
                borderColor: '#1a1a1a',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
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
