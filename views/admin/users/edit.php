<?php
$page_title = 'Edit User - Aplikasi Peminjaman Alat';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';
require_once __DIR__ . '/../../layouts/navbar.php';

$userData = $user ?? [];
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold py-3">
                <i class="bi bi-pencil-square me-2 text-primary"></i> Form Edit Pengguna
            </div>
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($config['base_url'] ?? ''); ?>/index.php?route=admin/users/update" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                    <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($userData['id_user'] ?? ''); ?>">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?php echo htmlspecialchars($userData['nama_lengkap'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($userData['username'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru <span class="text-muted fw-normal">(Kosongkan jika tidak ingin mengubah password)</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tetap">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Role Pengguna</label>
                        <select name="role" class="form-select" required>
                            <option value="admin" <?php echo (($userData['role'] ?? '') === 'admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="petugas" <?php echo (($userData['role'] ?? '') === 'petugas') ? 'selected' : ''; ?>>Petugas</option>
                            <option value="peminjam" <?php echo (($userData['role'] ?? '') === 'peminjam') ? 'selected' : ''; ?>>Peminjam</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo htmlspecialchars($config['base_url'] ?? ''); ?>/index.php?route=admin/users" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Perbarui User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>



