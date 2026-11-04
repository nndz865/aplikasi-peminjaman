<?php
$page_title = 'Monitoring Pengembalian Alat - Aplikasi Peminjaman Alat UKK RPL';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
require_once __DIR__ . '/../layouts/navbar.php';

$peminjamans = $peminjamans ?? [];
$riwayatSelesai = $riwayatSelesai ?? [];
$baseUrl = $config['base_url'] ?? '';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0"><i class="bi bi-arrow-return-left me-2 text-primary"></i>Monitoring Pengembalian Alat</h3>
    <span class="text-muted">Daftar peminjaman aktif dan riwayat pengembalian</span>
</div>

<div class="card border-0 shadow-sm mb-5">
    <div class="card-header bg-white fw-bold py-3 px-4 border-0">
        <i class="bi bi-clock-history text-warning me-2"></i> Peminjaman Aktif (Sedang Dipinjam)
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Kode</th>
                        <th>Peminjam</th>
                        <th>Nama Alat</th>
                        <th class="text-center">Jumlah</th>
                        <th>Tanggal Pinjam</th>
                        <th>Rencana Kembali</th>
                        <th class="text-center">Status Keterlambatan</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($peminjamans)): ?>
                        <tr><td colspan="8" class="text-center py-4 text-muted">Tidak ada peminjaman aktif saat ini.</td></tr>
                    <?php else: ?>
                        <?php foreach ($peminjamans as $p): 
                            $isTerlambat = (date('Y-m-d') > $p['tanggal_rencana_kembali']);
                        ?>
                            <tr>
                                <td class="ps-4"><code><?php echo htmlspecialchars($p['kode_peminjaman'] ?? ''); ?></code></td>
                                <td class="fw-bold"><?php echo htmlspecialchars($p['nama_lengkap'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($p['nama_alat'] ?? ''); ?></td>
                                <td class="text-center"><span class="badge bg-secondary"><?php echo (int)($p['jumlah'] ?? 0); ?></span></td>
                                <td><?php echo htmlspecialchars($p['tanggal_pinjam'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($p['tanggal_rencana_kembali'] ?? ''); ?></td>
                                <td class="text-center">
                                    <?php if ($isTerlambat): ?>
                                        <span class="badge bg-danger">Terlambat</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Tepat Waktu</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <button type="button" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modalAdminUbahRencana<?php echo $p['id_peminjaman']; ?>" title="Ubah Tanggal Rencana Kembali">
                                        <i class="bi bi-calendar-event"></i> Ubah Tanggal
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Admin Ubah Tanggal Rencana Kembali -->
                            <div class="modal fade" id="modalAdminUbahRencana<?php echo $p['id_peminjaman']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?php echo $config['base_url']; ?>/index.php?route=admin/pengembalian/update-rencana" method="POST">
                                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                            <input type="hidden" name="id_peminjaman" value="<?php echo $p['id_peminjaman']; ?>">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Ubah Tanggal Rencana Kembali (Admin)</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Kode & Alat</label>
                                                    <input type="text" class="form-control bg-light" value="<?php echo htmlspecialchars($p['kode_peminjaman'] . ' - ' . $p['nama_alat']); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Tanggal Rencana Kembali Baru</label>
                                                    <input type="date" name="tanggal_rencana_kembali" class="form-control" value="<?php echo $p['tanggal_rencana_kembali']; ?>" required>
                                                    <div class="form-text small">Tidak boleh lebih awal dari tanggal pinjam (<?php echo $p['tanggal_pinjam']; ?>).</div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-warning fw-bold">Simpan Perubahan</button>
                                            </div>
                                         </form>
                                     </div>
                                 </div>
                             </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold py-3 px-4 border-0">
        <i class="bi bi-check-circle text-success me-2"></i> Riwayat Pengembalian Selesai
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Kode</th>
                        <th>Peminjam</th>
                        <th>Nama Alat</th>
                        <th class="text-center">Jumlah</th>
                        <th>Tanggal Pinjam</th>
                        <th>Aktual Kembali</th>
                        <th class="text-end pe-4">Denda</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayatSelesai)): ?>
                        <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada riwayat pengembalian selesai.</td></tr>
                    <?php else: ?>
                        <?php foreach ($riwayatSelesai as $r): ?>
                            <tr>
                                <td class="ps-4"><code><?php echo htmlspecialchars($r['kode_peminjaman'] ?? ''); ?></code></td>
                                <td class="fw-bold"><?php echo htmlspecialchars($r['nama_lengkap'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($r['nama_alat'] ?? ''); ?></td>
                                <td class="text-center"><span class="badge bg-secondary"><?php echo (int)($r['jumlah'] ?? 0); ?></span></td>
                                <td><?php echo htmlspecialchars($r['tanggal_pinjam'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($r['tanggal_kembali_aktual'] ?? '-'); ?></td>
                                <td class="text-end pe-4 fw-bold text-danger">Rp <?php echo number_format((float)($r['denda'] ?? 0), 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
