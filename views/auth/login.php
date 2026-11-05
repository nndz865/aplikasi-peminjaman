<?php
$page_title = 'Login - Aplikasi Peminjaman Alat UKK RPL';
require_once __DIR__ . '/../layouts/header.php';
$config = include __DIR__ . '/../../config/app.php';
?>
<style>
    body { background: #f5f7fb; }
    .login-container { min-height: 100vh; display: flex; align-items: center; padding: 2rem 1rem; background: radial-gradient(circle at 10% 10%, #fff1c2, transparent 32%), #f5f7fb; }
    .login-shell { width: 100%; max-width: 980px; overflow: hidden; border-radius: 24px; background: #fff; box-shadow: 0 24px 70px rgba(15, 23, 42, .14); }
    .login-intro { min-height: 560px; padding: 3rem; color: #fff; background: linear-gradient(145deg, #111827, #273449); }
    .login-form { padding: 3rem; }
    .login-logo { width: 64px; height: 64px; display: inline-flex; align-items: center; justify-content: center; border-radius: 18px; color: #111827; background: #ffd000; font-size: 1.8rem; }
    .login-form .form-control { min-height: 48px; border: 1px solid #dbe1ea; box-shadow: none; }
    .login-form .input-group-text { border-color: #dbe1ea; background: #f8fafc; color: #64748b; }
    .login-form .btn-primary { min-height: 50px; }
    .demo-account { border: 1px solid #e5e7eb; background: #f8fafc; }
    @media (max-width: 767px) { .login-intro { min-height: auto; padding: 2rem; } .login-form { padding: 2rem; } }
</style>

<div class="login-container">
    <div class="login-shell row g-0">
        <div class="col-lg-5 login-intro d-flex flex-column justify-content-between">
            <div>
                <div class="login-logo mb-4"><i class="bi bi-tools"></i></div>
                <p class="text-warning fw-bold text-uppercase small mb-2">Sistem Inventaris Digital</p>
                <h1 class="display-6 fw-bold mb-3 text-white">Peminjaman Alat Praktikum</h1>
                <p class="text-light opacity-75 mb-0">Kelola inventaris, ajukan peminjaman, dan pantau pengembalian alat secara tertib.</p>
            </div>
            <div class="small text-light opacity-75 mt-5"><i class="bi bi-shield-check me-2"></i>Akses aman untuk Admin, Petugas, dan Peminjam</div>
        </div>
        <div class="col-lg-7 login-form">
            <div class="mb-4">
                <p class="text-primary fw-bold small text-uppercase mb-2">Selamat datang kembali</p>
                <h2 class="fw-bold text-dark mb-2">Masuk ke akun Anda</h2>
                <p class="text-muted mb-0">Gunakan username dan password untuk melanjutkan.</p>
            </div>

            <?php $flash = get_flash_message(); if ($flash): ?>
                <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show py-2 small" role="alert">
                    <?php echo $flash['message']; ?>
                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?php echo $config['base_url']; ?>/index.php?route=login-process" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="login-username">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input id="login-username" type="text" name="username" class="form-control" placeholder="Contoh: admin" autocomplete="username" required autofocus>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold" for="login-password">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input id="login-password" type="password" name="password" class="form-control" placeholder="Masukkan password" autocomplete="current-password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold"><i class="bi bi-box-arrow-in-right me-1"></i> Masuk</button>
            </form>

            <div class="demo-account mt-4 p-3 rounded-3 small">
                <p class="fw-bold mb-2 text-dark"><i class="bi bi-info-circle me-1"></i> Akun demo</p>
                <div class="row g-2 text-muted">
                    <div class="col-sm-4">Admin<br><code>admin</code> / <code>Admin123!</code></div>
                    <div class="col-sm-4">Petugas<br><code>petugas</code> / <code>Petugas123!</code></div>
                    <div class="col-sm-4">Peminjam<br><code>peminjam</code> / <code>Peminjam123!</code></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>






