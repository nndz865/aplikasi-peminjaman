<?php
$page_title = 'Katalog Alat - Aplikasi Peminjaman Alat';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
require_once __DIR__ . '/../layouts/navbar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0"><i class="bi bi-box-seam me-2"></i>Katalog Alat Praktikum Tersedia</h3>
    <span class="text-muted">Pilih alat yang ingin Anda ajukan</span>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="" class="row g-3">
            <input type="hidden" name="route" value="peminjam/daftar-alat">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Cari nama alat, lokasi, spesifikasi..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-dark w-100"><i class="bi bi-search me-1"></i> Cari Alat</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    <?php if (empty($alats)): ?>
        <div class="col-12">
            <div class="card shadow-sm text-center py-5">
                <div class="card-body">
                    <i class="bi bi-box fs-1 text-muted"></i>
                    <p class="text-muted mt-2">Tidak ada alat dengan stok tersedia saat ini.</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($alats as $a): ?>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold text-dark mb-0"><?php echo htmlspecialchars($a['nama_alat']); ?></h5>
                            <span class="badge bg-light text-dark border"><?php echo htmlspecialchars($a['nama_kategori']); ?></span>
                        </div>
                        <p class="text-muted small mb-3"><?php echo htmlspecialchars($a['deskripsi']); ?></p>
                        <div class="mt-auto">
                            <ul class="list-unstyled small mb-3">
                                <li class="mb-1"><i class="bi bi-stack text-primary me-2"></i>Stok Tersedia: <strong class="text-success"><?php echo $a['stok']; ?> unit</strong></li>
                                <li class="mb-1"><i class="bi bi-shield-check text-info me-2"></i>Kondisi: <strong><?php echo htmlspecialchars($a['kondisi']); ?></strong></li>
                                <li><i class="bi bi-geo-alt text-danger me-2"></i>Lokasi: <strong><?php echo htmlspecialchars($a['lokasi']); ?></strong></li>
                            </ul>
                            <a href="<?php echo $config['base_url']; ?>/index.php?route=peminjam/pengajuan&id_alat=<?php echo $a['id_alat']; ?>" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle me-1"></i> Ajukan Peminjaman
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>





