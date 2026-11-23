<?php
$page_title = 'Pengaturan Profil - Sistem Peminjaman Lab';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
require_once __DIR__ . '/../layouts/navbar.php';
$user = $user ?? [];
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 px-4 border-0 d-flex align-items-center">
                <i class="bi bi-person-gear text-primary fs-4 me-2"></i>
                <h4 class="fw-bold mb-0 text-dark">Pengaturan Profil Pengguna</h4>
            </div>
            <div class="card-body p-4">
                <form action="<?php echo $config['base_url']; ?>/index.php?route=profile/update" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="username">Username (Tidak dapat diubah)</label>
                        <input id="username" type="text" class="form-control bg-light" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" disabled readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="role">Role / Hak Akses</label>
                        <input id="role" type="text" class="form-control bg-light text-capitalize" value="<?php echo htmlspecialchars($user['role'] ?? ''); ?>" disabled readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="nama_lengkap">Nama Lengkap</label>
                        <input id="nama_lengkap" type="text" name="nama_lengkap" class="form-control" value="<?php echo htmlspecialchars($user['nama_lengkap'] ?? ''); ?>" required>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="password_baru">Password Baru <span class="text-muted fw-normal">(Kosongkan jika tidak ingin mengubah password)</span></label>
                        <input id="password_baru" type="password" name="password_baru" class="form-control" placeholder="Masukkan password baru">
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
