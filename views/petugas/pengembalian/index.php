<?php
$page_title = 'Pengembalian Alat - Aplikasi Peminjaman Alat';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0"><i class="bi bi-arrow-return-left me-2"></i>Pengembalian Alat & Perhitungan Denda</h3>
    <span class="text-muted">Monitoring Alat Disetujui & Proses Pengembalian</span>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-bold py-3">
        <i class="bi bi-list-task me-2 text-primary"></i> Daftar Peminjaman Aktif (Disetujui)
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">Kode</th>
                        <th>Peminjam</th>
                        <th>Nama Alat</th>
                        <th class="text-center">Jumlah</th>
                        <th>Tanggal Pinjam</th>
                        <th>Rencana Kembali</th>
                        <th class="text-center">Status Keterlambatan</th>
                        <th class="text-end pe-4">Aksi Pengembalian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($peminjamans)): ?>
                        <tr><td colspan="8" class="text-center py-4 text-muted">Tidak ada peminjaman aktif yang perlu dikembalikan.</td></tr>
                    <?php else: ?>
                        <?php foreach ($peminjamans as $p): 
                            $isTerlambat = (date('Y-m-d') > $p['tanggal_rencana_kembali']);
                        ?>
                            <tr>
                                <td class="ps-4"><code><?php echo $p['kode_peminjaman']; ?></code></td>
                                <td class="fw-semibold"><?php echo htmlspecialchars($p['nama_lengkap']); ?></td>
                                <td><?php echo htmlspecialchars($p['nama_alat']); ?></td>
                                <td class="text-center"><span class="badge bg-secondary"><?php echo $p['jumlah']; ?></span></td>
                                <td><?php echo $p['tanggal_pinjam']; ?></td>
                                <td><?php echo $p['tanggal_rencana_kembali']; ?></td>
                                <td class="text-center">
                                    <?php if ($isTerlambat): ?>
                                        <span class="badge bg-danger">Terlambat / Denda Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Tepat Waktu</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalKembali<?php echo $p['id_peminjaman']; ?>">
                                        <i class="bi bi-check2-circle me-1"></i> Proses Kembali
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Proses Pengembalian -->
                            <div class="modal fade" id="modalKembali<?php echo $p['id_peminjaman']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?php echo $config['base_url']; ?>/index.php?route=petugas/pengembalian/proses" method="POST">
                                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                            <input type="hidden" name="id_peminjaman" value="<?php echo $p['id_peminjaman']; ?>">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Proses Pengembalian Alat</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Kode Peminjaman</label>
                                                    <input type="text" class="form-control bg-light" value="<?php echo $p['kode_peminjaman']; ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Nama Peminjam & Alat</label>
                                                    <input type="text" class="form-control bg-light" value="<?php echo htmlspecialchars($p['nama_lengkap'] . ' - ' . $p['nama_alat']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Tanggal Rencana Kembali</label>
                                                    <input type="text" class="form-control bg-light" value="<?php echo $p['tanggal_rencana_kembali']; ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Tanggal Kembali Aktual</label>
                                                    <input type="date" name="tanggal_kembali_aktual" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                                    <div class="form-text small">Sistem akan otomatis menghitung denda Rp 5.000/hari jika melewati tanggal rencana.</div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Selesaikan & Kembalikan Stok</button>
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

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>






