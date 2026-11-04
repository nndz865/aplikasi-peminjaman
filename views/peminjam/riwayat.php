<?php
$page_title = 'Riwayat Peminjaman & Denda - Aplikasi Peminjaman Alat';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
require_once __DIR__ . '/../layouts/navbar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0"><i class="bi bi-clock-history me-2"></i>Riwayat Peminjaman & Denda Pribadi</h3>
    <a href="<?php echo $config['base_url']; ?>/index.php?route=peminjam/pengajuan" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Ajukan Peminjaman
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">Kode Transaksi</th>
                        <th>Nama Alat</th>
                        <th class="text-center">Jumlah</th>
                        <th>Tanggal Pinjam</th>
                        <th>Rencana Kembali</th>
                        <th>Aktual Kembali</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Denda</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayats)): ?>
                        <tr><td colspan="8" class="text-center py-4 text-muted">Anda belum memiliki riwayat peminjaman alat.</td></tr>
                    <?php else: ?>
                        <?php foreach ($riwayats as $r): ?>
                            <tr>
                                <td class="ps-4"><code><?php echo $r['kode_peminjaman']; ?></code></td>
                                <td class="fw-semibold"><?php echo htmlspecialchars($r['nama_alat']); ?></td>
                                <td class="text-center"><span class="badge bg-secondary"><?php echo $r['jumlah']; ?></span></td>
                                <td><?php echo $r['tanggal_pinjam']; ?></td>
                                <td><?php echo $r['tanggal_rencana_kembali']; ?></td>
                                <td><?php echo $r['tanggal_kembali_aktual'] ?? '-'; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo ($r['status'] === 'menunggu') ? 'warning text-dark' : (($r['status'] === 'disetujui') ? 'primary' : (($r['status'] === 'selesai') ? 'success' : 'danger')); ?> text-capitalize">
                                        <?php echo $r['status']; ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4 fw-semibold text-danger">
                                    <?php if ($r['denda'] > 0): ?>
                                        Rp <?php echo number_format($r['denda'], 0, ',', '.'); ?>
                                    <?php else: ?>
                                        <span class="text-success">Rp 0</span>
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





