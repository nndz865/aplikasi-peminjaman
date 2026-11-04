<?php
$page_title = 'Login - Aplikasi Peminjaman Alat UKK RPL';
require_once __DIR__ . '/../layouts/header.php';
$config = include __DIR__ . '/../../config/app.php';
?>
<style>
    .login-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login-card {
        width: 100%;
        max-width: 420px;
        background: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        overflow: hidden;
    }
</style>

<div class="login-container px-3">
    <div class="login-card p-4 p-md-5">
        <div class="text-center mb-4">
            <div class="bg-dark border border-secondary text-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                <i class="bi bi-tools fs-3"></i>
            </div>
            <h4 class="fw-bold text-dark">Peminjaman Alat</h4>
            <p class="text-muted small">UKK Rekayasa Perangkat Lunak 2026/2027</p>
        </div>

        <?php $flash = get_flash_message(); if ($flash): ?>
            <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show py-2 small" role="alert">
                <?php echo $flash['message']; ?>
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?php echo $config['base_url']; ?>/index.php?route=login-process" method="POST">
            <div class="mb-3">
                <label class="form-label small fw-semibold text-muted">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control border-start-0 ps-0" placeholder="Masukkan username" required autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-semibold text-muted">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Masukkan password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </button>
        </form>

        <div class="mt-4 p-3 bg-light rounded-3 small text-muted">
            <p class="fw-bold mb-1 text-dark"><i class="bi bi-info-circle me-1"></i> Akun Demo:</p>
            <ul class="mb-0 ps-3">
                <li>Admin: <code>admin</code> / <code>Admin123!</code></li>
                <li>Petugas: <code>petugas</code> / <code>Petugas123!</code></li>
                <li>Peminjam: <code>peminjam</code> / <code>Peminjam123!</code></li>
            </ul>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>






