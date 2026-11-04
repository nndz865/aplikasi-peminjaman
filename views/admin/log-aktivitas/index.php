<?php
$page_title = 'Log Aktivitas Sistem - Aplikasi Peminjaman Alat';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0"><i class="bi bi-clock-history me-2"></i>Log Aktivitas Sistem</h3>
    <span class="text-muted">Pencatatan Audit Sistem & Pengguna</span>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Waktu</th>
                        <th>Pengguna</th>
                        <th>Role</th>
                        <th>Aktivitas</th>
                        <th>Deskripsi</th>
                        <th class="pe-4">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada log aktivitas.</td></tr>
                    <?php else: ?>
                        <?php foreach ($logs as $index => $log): ?>
                            <tr>
                                <td class="ps-4"><?php echo $index + 1; ?></td>
                                <td class="text-muted" style="white-space: nowrap;"><?php echo $log['created_at']; ?></td>
                                <td class="fw-semibold"><?php echo htmlspecialchars($log['username']); ?> (<?php echo htmlspecialchars($log['nama_lengkap']); ?>)</td>
                                <td><span class="badge bg-secondary text-capitalize"><?php echo $log['role']; ?></span></td>
                                <td><span class="badge bg-dark"><?php echo htmlspecialchars($log['aktivitas']); ?></span></td>
                                <td><?php echo htmlspecialchars($log['deskripsi']); ?></td>
                                <td class="pe-4 font-monospace text-muted"><?php echo $log['ip_address']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>





