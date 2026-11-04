<?php
$page_title = 'Pengembalian Alat - Aplikasi Peminjaman Alat UKK RPL';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
require_once __DIR__ . '/../layouts/navbar.php';

$peminjamans = $peminjamans ?? [];
$baseUrl = $config['base_url'] ?? '';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0"><i class="bi bi-arrow-return-left me-2 text-primary"></i>Pengajuan Pengembalian Alat</h3>
    <span class="text-muted">Kembalikan alat yang sedang Anda pinjam</span>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold py-3 px-4 border-0">
        <i class="bi bi-box-seam text-primary me-2"></i> Daftar Alat yang Sedang Anda Pinjam (Disetujui)
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Kode Transaksi</th>
                        <th>Nama Alat</th>
                        <th class="text-center">Jumlah</th>
                        <th>Tanggal Pinjam</th>
                        <th>Rencana Kembali</th>
                        <th class="text-end pe-4">Aksi Pengembalian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($peminjamans)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada alat aktif yang perlu dikembalikan.</td></tr>
                    <?php else: ?>
                        <?php foreach ($peminjamans as $p): ?>
                            <tr>
                                <td class="ps-4"><code><?php echo htmlspecialchars($p['kode_peminjaman'] ?? ''); ?></code></td>
                                <td class="fw-bold"><?php echo htmlspecialchars($p['nama_alat'] ?? ''); ?></td>
                                <td class="text-center"><span class="badge bg-secondary"><?php echo (int)($p['jumlah'] ?? 0); ?></span></td>
                                <td><?php echo htmlspecialchars($p['tanggal_pinjam'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($p['tanggal_rencana_kembali'] ?? ''); ?></td>
                                <td class="text-end pe-4">
                                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalKembali<?php echo (int)$p['id_peminjaman']; ?>">
                                        <i class="bi bi-check2-circle me-1"></i> Kembalikan Alat
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Proses Pengembalian -->
                            <div class="modal fade" id="modalKembali<?php echo (int)$p['id_peminjaman']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=peminjam/pengembalian/proses" method="POST">
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                                            <input type="hidden" name="id_peminjaman" value="<?php echo (int)$p['id_peminjaman']; ?>">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Konfirmasi Pengembalian Alat</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Alat yang Dikembalikan</label>
                                                    <input type="text" class="form-control bg-light" value="<?php echo htmlspecialchars($p['nama_alat'] . ' (' . $p['jumlah'] . ' unit)'); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Tanggal Rencana Kembali</label>
                                                    <input type="text" class="form-control bg-light" value="<?php echo htmlspecialchars($p['tanggal_rencana_kembali']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Tanggal Kembali Aktual (Hari Ini)</label>
                                                    <input type="date" name="tanggal_kembali_aktual" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                                    <div class="form-text small">Jika melewati rencana kembali, denda otomatis dihitung Rp 5.000/hari.</div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Ajukan Pengembalian</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
