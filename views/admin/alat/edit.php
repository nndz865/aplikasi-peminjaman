<?php
$page_title = 'Edit Alat - Aplikasi Peminjaman Alat';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold py-3">
                <i class="bi bi-pencil-square me-2 text-primary"></i> Form Edit Alat Praktikum
            </div>
            <div class="card-body">
                <form action="<?php echo $config['base_url']; ?>/index.php?route=admin/alat/update" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="id_alat" value="<?php echo $alat['id_alat']; ?>">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control" value="<?php echo htmlspecialchars($alat['nama_alat']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori Alat</label>
                        <select name="id_kategori" class="form-select" required>
                            <?php foreach ($kategoris as $kat): ?>
                                <option value="<?php echo $kat['id_kategori']; ?>" <?php echo ($alat['id_kategori'] == $kat['id_kategori']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($kat['nama_kategori']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Stok Unit</label>
                            <input type="number" name="stok" class="form-control" min="0" value="<?php echo $alat['stok']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kondisi</label>
                            <select name="kondisi" class="form-select" required>
                                <option value="Baik" <?php echo ($alat['kondisi'] === 'Baik') ? 'selected' : ''; ?>>Baik</option>
                                <option value="Kurang Baik" <?php echo ($alat['kondisi'] === 'Kurang Baik') ? 'selected' : ''; ?>>Kurang Baik</option>
                                <option value="Perbaikan" <?php echo ($alat['kondisi'] === 'Perbaikan') ? 'selected' : ''; ?>>Perbaikan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Lokasi Penyimpanan</label>
                        <input type="text" name="lokasi" class="form-control" value="<?php echo htmlspecialchars($alat['lokasi']); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"><?php echo htmlspecialchars($alat['deskripsi']); ?></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo $config['base_url']; ?>/index.php?route=admin/alat" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Perbarui Alat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>





