<?php
$page_title = 'Laporan Transaksi - Aplikasi Peminjaman Alat UKK RPL';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';
require_once __DIR__ . '/../../layouts/navbar.php';

$laporans = $laporans ?? [];
$totalDenda = $totalDenda ?? 0;
$baseUrl = $config['base_url'] ?? '';
$searchVal = $_GET['search'] ?? '';
$statusVal = $_GET['status'] ?? '';
$startDateVal = $_GET['start_date'] ?? '';
$endDateVal = $_GET['end_date'] ?? '';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Laporan Transaksi Peminjaman</h3>
    <div>
        <button onclick="window.print();" class="btn btn-primary shadow-sm me-2 d-print-none">
            <i class="bi bi-file-earmark-pdf me-1"></i> Ekspor PDF / Print
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4 d-print-none">
    <div class="card-body">
        <form method="GET" action="" class="row g-3">
            <input type="hidden" name="route" value="petugas/laporan">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Cari kode, peminjam, alat..." value="<?php echo htmlspecialchars($searchVal); ?>">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="menunggu" <?php echo ($statusVal === 'menunggu') ? 'selected' : ''; ?>>Menunggu</option>
                    <option value="disetujui" <?php echo ($statusVal === 'disetujui') ? 'selected' : ''; ?>>Disetujui</option>
                    <option value="selesai" <?php echo ($statusVal === 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                    <option value="ditolak" <?php echo ($statusVal === 'ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($startDateVal); ?>" title="Tanggal Mulai">
            </div>
            <div class="col-md-2">
                <input type="date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($endDateVal); ?>" title="Tanggal Akhir">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-dark w-100"><i class="bi bi-search me-1"></i> Filter Laporan</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="text-center mb-4 d-none d-print-block">
            <h4 class="fw-bold mb-1">LAPORAN PEMINJAMAN ALAT PRAKTIKUM UKK RPL</h4>
            <p class="text-muted small mb-0">Dicetak pada: <?php echo date('d-m-Y H:i:s'); ?> oleh <?php echo htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Petugas'); ?></p>
            <hr>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle small">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Peminjam</th>
                        <th>Nama Alat</th>
                        <th class="text-center">Jml</th>
                        <th>Tgl Pinjam</th>
                        <th>Rencana Kembali</th>
                        <th>Aktual Kembali</th>
                        <th>Status</th>
                        <th class="text-end">Denda</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($laporans)): ?>
                        <tr><td colspan="10" class="text-center py-4 text-muted">Tidak ada data laporan transaksi.</td></tr>
                    <?php else: ?>
                        <?php foreach ($laporans as $index => $l): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><code><?php echo htmlspecialchars($l['kode_peminjaman'] ?? ''); ?></code></td>
                                <td class="fw-semibold"><?php echo htmlspecialchars($l['nama_lengkap'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($l['nama_alat'] ?? ''); ?></td>
                                <td class="text-center"><?php echo (int)($l['jumlah'] ?? 0); ?></td>
                                <td><?php echo htmlspecialchars($l['tanggal_pinjam'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($l['tanggal_rencana_kembali'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($l['tanggal_kembali_aktual'] ?? '-'); ?></td>
                                <td><span class="text-capitalize"><?php echo htmlspecialchars($l['status'] ?? ''); ?></span></td>
                                <td class="text-end">Rp <?php echo number_format((float)($l['denda'] ?? 0), 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="fw-bold table-secondary">
                            <td colspan="9" class="text-end">TOTAL KESELURUHAN DENDA:</td>
                            <td class="text-end">Rp <?php echo number_format((float)$totalDenda, 0, ',', '.'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
