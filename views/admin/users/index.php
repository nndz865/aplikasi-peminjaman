<?php
$page_title = 'Manajemen User - Aplikasi Peminjaman Alat';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0"><i class="bi bi-people me-2"></i>Manajemen Pengguna</h3>
    <a href="<?php echo $config['base_url']; ?>/index.php?route=admin/users/create" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah User
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="" class="row g-3">
            <input type="hidden" name="route" value="admin/users">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau username..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select">
                    <option value="">Semua Role</option>
                    <option value="admin" <?php echo (isset($_GET['role']) && $_GET['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="petugas" <?php echo (isset($_GET['role']) && $_GET['role'] === 'petugas') ? 'selected' : ''; ?>>Petugas</option>
                    <option value="peminjam" <?php echo (isset($_GET['role']) && $_GET['role'] === 'peminjam') ? 'selected' : ''; ?>>Peminjam</option>
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
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Tanggal Dibuat</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada data pengguna.</td></tr>
                    <?php else: ?>
                        <?php foreach ($users as $index => $u): ?>
                            <tr>
                                <td class="ps-4"><?php echo $index + 1; ?></td>
                                <td class="fw-semibold"><?php echo htmlspecialchars($u['nama_lengkap']); ?></td>
                                <td><code><?php echo htmlspecialchars($u['username']); ?></code></td>
                                <td>
                                    <span class="badge bg-<?php echo ($u['role'] === 'admin') ? 'danger' : (($u['role'] === 'petugas') ? 'warning text-dark' : 'info'); ?> text-capitalize">
                                        <?php echo $u['role']; ?>
                                    </span>
                                </td>
                                <td><?php echo $u['created_at']; ?></td>
                                <td class="text-end pe-4">
                                    <a href="<?php echo $config['base_url']; ?>/index.php?route=admin/users/edit&id=<?php echo $u['id_user']; ?>" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <?php if ($u['id_user'] != $_SESSION['user_id']): ?>
                                        <a href="<?php echo $config['base_url']; ?>/index.php?route=admin/users/delete&id=<?php echo $u['id_user']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus pengguna ini?');" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </a>
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





