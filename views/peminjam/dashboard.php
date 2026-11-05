<?php
$page_title = 'Dashboard Peminjam - Aplikasi Peminjaman Alat UKK RPL';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
require_once __DIR__ . '/../layouts/navbar.php';

$stats = $stats ?? [];
$alats = $alats ?? [];
$riwayats = $riwayats ?? [];
$baseUrl = $config['base_url'] ?? '';
?>

<!-- Premium Banner -->
<div class="card shadow-lg mb-4 border-0 overflow-hidden position-relative bg-dark text-white">
    <div class="position-absolute end-0 bottom-0 opacity-10 pe-4 pb-2">
        <i class="bi bi-box-seam display-1"></i>
    </div>
    <div class="card-body p-4 p-md-5 position-relative z-1">
        <span class="badge bg-success text-white fw-bold px-3 py-2 mb-2 rounded-pill"><i class="bi bi-mortarboard-fill me-1"></i> Panel Siswa Peminjam</span>
        <h1 class="display-6 fw-bold mb-2 text-white">Katalog & Riwayat Peminjaman Alat</h1>
        <p class="lead text-light mb-0">Halo, <strong class="text-warning"><?php echo htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Peminjam'); ?></strong>! Ajukan peminjaman alat praktik dan pantau status serta denda Anda dengan mudah.</p>
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
                        <h2 class="fw-bold text-dark mb-0"><?php echo number_format((int)($stats['menunggu'] ?? 0)); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top text-dark small fw-semibold">
                    <i class="bi bi-clock me-1"></i> Menunggu persetujuan petugas
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
                        <h6 class="text-dark fw-bold mb-1 small text-uppercase">Sedang Dipinjam</h6>
                        <h2 class="fw-bold text-dark mb-0"><?php echo number_format((int)($stats['disetujui'] ?? 0)); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top text-dark small fw-semibold">
                    <i class="bi bi-tools me-1"></i> Alat aktif di tangan Anda
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
                        <h6 class="text-dark fw-bold mb-1 small text-uppercase">Selesai</h6>
                        <h2 class="fw-bold text-dark mb-0"><?php echo number_format((int)($stats['selesai'] ?? 0)); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top text-dark small fw-semibold">
                    <i class="bi bi-shield-check me-1"></i> Transaksi dikembalikan
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
                        <h6 class="text-dark fw-bold mb-1 small text-uppercase">Denda Pribadi</h6>
                        <h2 class="fw-bold text-dark mb-0">Rp <?php echo number_format((float)($stats['total_denda'] ?? 0), 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top text-danger small fw-bold">
                    Akumulasi Keterlambatan
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Katalog Alat Tersedia -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-3 px-4 d-flex justify-content-between align-items-center border-0">
                <span class="d-flex align-items-center text-dark">
                    <i class="bi bi-box-seam text-primary fs-5 me-2"></i> Alat Tersedia untuk Dipinjam
                </span>
                <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=peminjam/daftar-alat" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 text-dark fw-bold small text-uppercase">Gambar</th>
                                <th class="py-3 text-dark fw-bold small text-uppercase">Nama Alat</th>
                                <th class="py-3 text-dark fw-bold small text-uppercase">Kategori</th>
                                <th class="text-center py-3 text-dark fw-bold small text-uppercase">Stok</th>
                                <th class="text-end pe-4 py-3 text-dark fw-bold small text-uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($alats)): ?>
                               <tr><td colspan="5" class="text-center py-4 text-dark fw-semibold">Tidak ada alat tersedia saat ini.</td></tr>
                            <?php else: ?>
                                <?php $count = 0; foreach ($alats as $a): if ($count++ >= 5) break; ?>
                                    <tr>
                                        <td class="ps-4 py-3"><img src="<?php echo !empty($a['gambar']) ? $baseUrl . '/assets/img/alat/' . rawurlencode($a['gambar']) : $baseUrl . '/assets/img/alat-placeholder.svg'; ?>" alt="<?php echo htmlspecialchars($a['nama_alat'] ?? ''); ?>" style="width:64px;height:48px;object-fit:cover;border-radius:8px"></td>
                                        <td class="py-3 fw-bold text-dark"><?php echo htmlspecialchars($a['nama_alat'] ?? ''); ?></td>
                                        <td class="py-3"><span class="badge bg-light text-dark border border-secondary px-2 py-1 fw-semibold"><?php echo htmlspecialchars($a['nama_kategori'] ?? ''); ?></span></td>
                                        <td class="text-center py-3"><span class="badge bg-success text-white rounded-pill px-3 fw-semibold"><?php echo (int)($a['stok'] ?? 0); ?> unit</span></td>
                                        <td class="text-end pe-4 py-3">
                                            <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=peminjam/pengajuan&id_alat=<?php echo (int)$a['id_alat']; ?>" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold">
                                                <i class="bi bi-plus-lg me-1"></i> Pinjam
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Peminjaman Terakhir -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-3 px-4 d-flex justify-content-between align-items-center border-0">
                <span class="d-flex align-items-center text-dark">
                    <i class="bi bi-clock-history text-primary fs-5 me-2"></i> Riwayat Peminjaman Terakhir
                </span>
                <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=peminjam/riwayat" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">Lihat Riwayat</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 text-dark fw-bold small text-uppercase">Kode</th>
                                <th class="py-3 text-dark fw-bold small text-uppercase">Alat</th>
                                <th class="text-center py-3 text-dark fw-bold small text-uppercase">Jml</th>
                                <th class="py-3 text-dark fw-bold small text-uppercase">Status</th>
                                <th class="text-end pe-4 py-3 text-dark fw-bold small text-uppercase">Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($riwayats)): ?>
                                <tr><td colspan="5" class="text-center py-4 text-dark fw-semibold">Belum ada riwayat peminjaman.</td></tr>
                            <?php else: ?>
                                <?php $count = 0; foreach ($riwayats as $r): if ($count++ >= 5) break; ?>
                                    <tr>
                                        <td class="ps-4 py-3 text-dark fw-semibold"><code><?php echo htmlspecialchars($r['kode_peminjaman'] ?? ''); ?></code></td>
                                        <td class="fw-bold text-dark py-3"><?php echo htmlspecialchars($r['nama_alat'] ?? ''); ?></td>
                                        <td class="text-center py-3"><span class="badge bg-secondary text-white rounded-pill px-2 fw-semibold"><?php echo (int)($r['jumlah'] ?? 0); ?></span></td>
                                        <td class="py-3">
                                            <?php 
                                                $status = $r['status'] ?? 'menunggu';
                                                $badgeClass = ($status === 'menunggu') ? 'bg-warning text-dark' : (($status === 'disetujui') ? 'bg-primary text-white' : (($status === 'selesai') ? 'bg-success text-white' : 'bg-danger text-white'));
                                            ?>
                                            <span class="badge <?php echo $badgeClass; ?> text-capitalize px-3 py-1 rounded-pill fw-semibold">
                                                <?php echo htmlspecialchars($status); ?>
                                            </span>
                                        </td>
                                        <td class="text-end pe-4 py-3 fw-bold text-danger">Rp <?php echo number_format((float)($r['denda'] ?? 0), 0, ',', '.'); ?></td>
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
