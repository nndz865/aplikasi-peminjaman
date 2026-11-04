<?php
$page_title = 'Log Aktivitas Sistem - Aplikasi Peminjaman Alat UKK RPL';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';
require_once __DIR__ . '/../../layouts/navbar.php';

$logs = $logs ?? [];
$baseUrl = $config['base_url'] ?? '';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0"><i class="bi bi-clock-history me-2 text-primary"></i>Log Aktivitas Sistem</h3>
    <div>
        <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/log-aktivitas/export" class="btn btn-success shadow-sm me-2">
            <i class="bi bi-file-earmark-spreadsheet me-1"></i> Ekspor CSV
        </a>
        <button type="button" class="btn btn-dark shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCetakLog">
            <i class="bi bi-printer me-1"></i> Cetak / Print
        </button>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3 text-dark fw-bold text-uppercase">No</th>
                        <th class="py-3 text-dark fw-bold text-uppercase">Waktu</th>
                        <th class="py-3 text-dark fw-bold text-uppercase">Pengguna</th>
                        <th class="py-3 text-dark fw-bold text-uppercase">Role</th>
                        <th class="py-3 text-dark fw-bold text-uppercase">Aktivitas</th>
                        <th class="py-3 text-dark fw-bold text-uppercase">Deskripsi</th>
                        <th class="pe-4 py-3 text-dark fw-bold text-uppercase">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr><td colspan="7" class="text-center py-4 text-dark fw-semibold">Belum ada log aktivitas.</td></tr>
                    <?php else: ?>
                        <?php foreach ($logs as $index => $log): ?>
                            <tr>
                                <td class="ps-4 py-3 text-dark fw-bold"><?php echo $index + 1; ?></td>
                                <td class="text-dark fw-semibold py-3" style="white-space: nowrap;"><?php echo htmlspecialchars($log['created_at'] ?? ''); ?></td>
                                <td class="fw-bold text-dark py-3"><?php echo htmlspecialchars($log['username'] ?? ''); ?> (<?php echo htmlspecialchars($log['nama_lengkap'] ?? ''); ?>)</td>
                                <td class="py-3"><span class="badge bg-secondary text-capitalize"><?php echo htmlspecialchars($log['role'] ?? ''); ?></span></td>
                                <td class="py-3"><span class="badge bg-dark text-white"><?php echo htmlspecialchars($log['aktivitas'] ?? ''); ?></span></td>
                                <td class="text-dark py-3"><?php echo htmlspecialchars($log['deskripsi'] ?? ''); ?></td>
                                <td class="pe-4 font-monospace text-muted py-3"><?php echo htmlspecialchars($log['ip_address'] ?? ''); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Cetak -->
<div class="modal fade" id="modalCetakLog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Cetak Log Aktivitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button onclick="window.print();" class="btn btn-primary px-4">
                    <i class="bi bi-printer me-1"></i> Mulai Cetak
                </button>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
