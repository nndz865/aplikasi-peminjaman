<?php
$page_title = 'Persetujuan Peminjaman - Aplikasi Peminjaman Alat';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0"><i class="bi bi-check2-square me-2"></i>Persetujuan Pengajuan Peminjaman</h3>
    <span class="text-muted">Validasi & Kelola Pengajuan Peminjam</span>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="" class="row g-3">
            <input type="hidden" name="route" value="petugas/persetujuan">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Cari kode, peminjam, alat..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="menunggu" <?php echo (isset($_GET['status']) && $_GET['status'] === 'menunggu') ? 'selected' : ''; ?>>Menunggu</option>
                    <option value="disetujui" <?php echo (isset($_GET['status']) && $_GET['status'] === 'disetujui') ? 'selected' : ''; ?>>Disetujui</option>
                    <option value="selesai" <?php echo (isset($_GET['status']) && $_GET['status'] === 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                    <option value="ditolak" <?php echo (isset($_GET['status']) && $_GET['status'] === 'ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($_GET['start_date'] ?? ''); ?>" title="Tanggal Mulai">
            </div>
            <div class="col-md-2">
                <input type="date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($_GET['end_date'] ?? ''); ?>" title="Tanggal Akhir">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-dark w-100"><i class="bi bi-filter me-1"></i> Terapkan Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
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
                        <th>Keperluan</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($peminjamans)): ?>
                        <tr><td colspan="9" class="text-center py-4 text-muted">Tidak ada data pengajuan.</td></tr>
                    <?php else: ?>
                        <?php foreach ($peminjamans as $p): ?>
                            <tr>
                                <td class="ps-4"><code><?php echo $p['kode_peminjaman']; ?></code></td>
                                <td class="fw-semibold"><?php echo htmlspecialchars($p['nama_lengkap']); ?></td>
                                <td><?php echo htmlspecialchars($p['nama_alat']); ?></td>
                                <td class="text-center"><span class="badge bg-secondary"><?php echo $p['jumlah']; ?></span></td>
                                <td><?php echo $p['tanggal_pinjam']; ?></td>
                                <td><?php echo $p['tanggal_rencana_kembali']; ?></td>
                                <td><span class="text-muted text-truncate d-inline-block" style="max-width: 150px;" title="<?php echo htmlspecialchars($p['keperluan']); ?>"><?php echo htmlspecialchars($p['keperluan']); ?></span></td>
                                <td>
                                    <span class="badge bg-<?php echo ($p['status'] === 'menunggu') ? 'warning text-dark' : (($p['status'] === 'disetujui') ? 'primary' : (($p['status'] === 'selesai') ? 'success' : 'danger')); ?> text-capitalize">
                                        <?php echo $p['status']; ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <?php if ($p['status'] === 'menunggu'): ?>
                                        <a href="<?php echo $config['base_url']; ?>/index.php?route=petugas/persetujuan/setujui&id=<?php echo $p['id_peminjaman']; ?>" class="btn btn-sm btn-success me-1" onclick="return confirm('Setujui peminjaman ini? Stok akan dikurangi otomatis.');" title="Setujui">
                                            <i class="bi bi-check-lg"></i>
                                        </a>
                                        <a href="<?php echo $config['base_url']; ?>/index.php?route=petugas/persetujuan/tolak&id=<?php echo $p['id_peminjaman']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tolak peminjaman ini?');" title="Tolak">
                                            <i class="bi bi-x-lg"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">Selesai/Diproses</span>
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

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>






