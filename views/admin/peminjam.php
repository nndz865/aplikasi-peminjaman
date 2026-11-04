<?php
$page_title = 'Data Peminjam - Aplikasi Peminjaman Alat UKK RPL';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
require_once __DIR__ . '/../layouts/navbar.php';

$daftarPeminjam = $daftarPeminjam ?? [];
$baseUrl = $config['base_url'] ?? '';
$searchVal = $_GET['search'] ?? '';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0"><i class="bi bi-people-fill me-2 text-primary"></i>Manajemen Data Peminjam</h3>
    <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/users/create" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Peminjam Baru
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="" class="row g-3">
            <input type="hidden" name="route" value="admin/peminjam">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau username peminjam..." value="<?php echo htmlspecialchars($searchVal); ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-dark w-100"><i class="bi bi-search me-1"></i> Cari Peminjam</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3 text-dark fw-bold text-uppercase">No</th>
                        <th class="py-3 text-dark fw-bold text-uppercase">Nama Lengkap</th>
                        <th class="py-3 text-dark fw-bold text-uppercase">Username</th>
                        <th class="py-3 text-dark fw-bold text-uppercase">Tanggal Dibuat</th>
                        <th class="text-end pe-4 py-3 text-dark fw-bold text-uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarPeminjam)): ?>
                        <tr><td colspan="5" class="text-center py-4 text-dark fw-semibold">Tidak ada data peminjam.</td></tr>
                    <?php else: ?>
                        <?php foreach ($daftarPeminjam as $index => $p): ?>
                            <tr>
                                <td class="ps-4 py-3 text-dark fw-bold"><?php echo $index + 1; ?></td>
                                <td class="fw-bold text-dark py-3"><i class="bi bi-person-badge text-primary me-2"></i><?php echo htmlspecialchars($p['nama_lengkap'] ?? ''); ?></td>
                                <td class="py-3"><code><?php echo htmlspecialchars($p['username'] ?? ''); ?></code></td>
                                <td class="py-3 text-dark fw-semibold"><?php echo htmlspecialchars($p['created_at'] ?? ''); ?></td>
                                <td class="text-end pe-4 py-3">
                                    <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/users/edit&id=<?php echo (int)$p['id_user']; ?>" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=admin/users/delete&id=<?php echo (int)$p['id_user']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus peminjam ini?');" title="Hapus">
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

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
