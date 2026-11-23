<?php
$page_title = 'Pengaturan Sistem - Admin';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
require_once __DIR__ . '/../layouts/navbar.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 px-4 border-0">
                <h4 class="fw-bold mb-0">Pengaturan Sistem</h4>
            </div>
            <div class="card-body p-4">
                <form action="<?php echo $config['base_url']; ?>/index.php?route=admin/settings/update" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Lab</label>
                        <input type="text" name="lab_name" class="form-control" value="<?php echo htmlspecialchars($settings['lab_name'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Denda Per Hari (Rp)</label>
                        <input type="number" name="denda" class="form-control" value="<?php echo htmlspecialchars($settings['denda_per_hari'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Maksimal Hari Pinjam</label>
                        <input type="number" name="max_hari" class="form-control" value="<?php echo htmlspecialchars($settings['max_hari_pinjam'] ?? ''); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
