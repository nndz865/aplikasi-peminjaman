<?php
$page_title = 'Dashboard Petugas - Aplikasi Peminjaman Alat UKK RPL';
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

<!-- Premium Banner -->
<div class="card shadow-lg mb-4 border-0 overflow-hidden position-relative bg-dark text-white">
    <div class="position-absolute end-0 bottom-0 opacity-10 pe-4 pb-2">
        <i class="bi bi-clipboard-check display-1"></i>
    </div>
    <div class="card-body p-4 p-md-5 position-relative z-1">
        <span class="badge bg-warning text-dark fw-bold px-3 py-2 mb-2 rounded-pill"><i class="bi bi-shield-lock me-1"></i> Panel Petugas Lab</span>
        <h1 class="display-6 fw-bold mb-2 text-white">Validasi & Monitoring Peminjaman</h1>
        <p class="lead text-light mb-0">Halo, <strong class="text-warning"><?php echo htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Petugas'); ?></strong>! Kelola persetujuan pinjam dan pemantauan pengembalian alat secara presisi.</p>
    </div>
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
<?php endif; ?>

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

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
