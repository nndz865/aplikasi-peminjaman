<?php
$page_title = 'Katalog Alat - Aplikasi Peminjaman Alat';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
require_once __DIR__ . '/../layouts/navbar.php';
?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h3 class="fw-bold text-dark m-0"><i class="bi bi-box-seam text-primary me-2"></i>Katalog Alat Praktikum</h3>
            <p class="text-muted small mb-0">Jelajahi dan ajukan peminjaman alat untuk kebutuhan praktikum Anda.</p>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" action="" class="row g-2 align-items-center">
            <input type="hidden" name="route" value="peminjam/daftar-alat">
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Cari alat (nama, kategori, lokasi)..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-dark w-100 fw-semibold rounded-pill">Cari Alat</button>
            </div>
        </form>
    </div>
</div>

<div class="d-flex align-items-center justify-content-between mb-3">
    <div class="small text-muted"><i class="bi bi-grid-3x3-gap me-1"></i><?php echo count($alats); ?> alat tersedia</div>
    <?php if (!empty($_GET['search'])): ?><a href="<?php echo $config['base_url']; ?>/index.php?route=peminjam/daftar-alat" class="btn btn-sm btn-link text-decoration-none">Reset pencarian</a><?php endif; ?>
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
                            <div class="card shadow-sm h-100 catalog-card">
                    <div class="card-body d-flex flex-column">
                        <img src="<?php echo !empty($a['gambar']) ? $config['base_url'] . '/assets/img/alat/' . rawurlencode($a['gambar']) : $config['base_url'] . '/assets/img/alat-placeholder.svg'; ?>" alt="<?php echo htmlspecialchars($a['nama_alat']); ?>" class="w-100 mb-3" style="height:180px;object-fit:cover;border-radius:12px">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold text-dark mb-0"><?php echo htmlspecialchars($a['nama_alat']); ?></h5>
                            <span class="badge bg-light text-dark border"><?php echo htmlspecialchars($a['nama_kategori']); ?></span>
                        </div>
                        <div class="small text-success fw-semibold mb-2"><i class="bi bi-circle-fill me-1" style="font-size:.5rem"></i>Tersedia untuk dipinjam
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





