<?php
$config = include __DIR__ . '/../../config/app.php';
?>
<!-- Navbar Top -->
<nav class="navbar navbar-top navbar-expand navbar-light px-3 px-md-4">
    <div class="container-fluid ps-0 pe-0">
        <div class="navbar-brand mb-0 h6 fw-bold text-dark text-truncate py-1" style="max-width: 55vw; min-width: 0;">
            <i class="bi bi-grid-1x2-fill me-2 text-primary"></i> <span>Aplikasi Peminjaman Alat</span>
        </div>
        <ul class="navbar-nav ms-auto align-items-center flex-shrink-0">
            <?php
                $dashboardRoutes = ['admin' => 'admin/dashboard', 'petugas' => 'petugas/dashboard', 'peminjam' => 'peminjam/dashboard'];
                $fallbackRoute = $dashboardRoutes[$_SESSION['role'] ?? ''] ?? 'login';
            ?>
            <li class="nav-item me-2">
                <button type="button" class="btn btn-sm btn-outline-dark" onclick="window.history.length > 1 ? window.history.back() : window.location.href='<?php echo $config['base_url']; ?>/index.php?route=<?php echo $fallbackRoute; ?>'" aria-label="Kembali ke halaman sebelumnya">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </button>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-dark fw-semibold py-1 px-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-1 text-secondary"></i> 
                    <span class="d-none md-inline"><?php echo htmlspecialchars($_SESSION['nama_lengkap'] ?? 'User'); ?></span>
                    <span class="badge bg-secondary text-capitalize ms-1"><?php echo htmlspecialchars($_SESSION['role'] ?? ''); ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item" href="<?php echo $config['base_url']; ?>/index.php?route=logout"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<div class="main-content">
    <?php $flash = get_flash_message(); if ($flash): ?>
        <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show shadow-sm" role="alert">
            <?php echo $flash['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
