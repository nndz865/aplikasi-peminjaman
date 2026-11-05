<?php
$page_title = 'Data Alat - Aplikasi Peminjaman Alat';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0"><i class="bi bi-cpu me-2"></i>Data Alat Praktikum</h3>
    <a href="<?php echo $config['base_url']; ?>/index.php?route=admin/alat/create" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Alat
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="" class="row g-3">
            <input type="hidden" name="route" value="admin/alat">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama alat, lokasi, deskripsi..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategoris as $kat): ?>
                        <option value="<?php echo $kat['id_kategori']; ?>" <?php echo (isset($_GET['kategori']) && $_GET['kategori'] == $kat['id_kategori']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($kat['nama_kategori']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100"><i class="bi bi-search me-1"></i> Filter</button>
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
                        <th class="ps-4">No</th>
                        <th>Gambar</th>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th class="text-center">Stok</th>
                        <th>Kondisi</th>
                        <th>Lokasi Penyimpanan</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($alats)): ?>
                        <tr><td colspan="8" class="text-center py-4 text-muted">Tidak ada data alat.</td></tr>
                    <?php else: ?>
                        <?php foreach ($alats as $index => $a): ?>
                            <tr>
                                <td class="ps-4"><?php echo $index + 1; ?></td>
                                <td><img src="<?php echo !empty($a['gambar']) ? $config['base_url'] . '/assets/img/alat/' . rawurlencode($a['gambar']) : $config['base_url'] . '/assets/img/alat-placeholder.svg'; ?>" alt="<?php echo htmlspecialchars($a['nama_alat']); ?>" style="width:64px;height:48px;object-fit:cover;border-radius:8px"></td>
                                <td>
                                    <span class="fw-semibold text-dark"><?php echo htmlspecialchars($a['nama_alat']); ?></span>
                                    <div class="small text-muted"><?php echo htmlspecialchars($a['deskripsi']); ?></div>
                                </td>
                                <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($a['nama_kategori']); ?></span></td>
                                <td class="text-center">
                                    <span class="badge bg-<?php echo ($a['stok'] > 0) ? 'success' : 'danger'; ?>">
                                        <?php echo $a['stok']; ?> unit
                                    </span>
                                </td>
                                <td><span class="badge bg-info text-dark"><?php echo htmlspecialchars($a['kondisi']); ?></span></td>
                                <td><i class="bi bi-geo-alt text-danger me-1"></i><?php echo htmlspecialchars($a['lokasi']); ?></td>
                                <td class="text-end pe-4">
                                    <a href="<?php echo $config['base_url']; ?>/index.php?route=admin/alat/edit&id=<?php echo $a['id_alat']; ?>" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?php echo $config['base_url']; ?>/index.php?route=admin/alat/delete&id=<?php echo $a['id_alat']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus alat ini?');" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
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





