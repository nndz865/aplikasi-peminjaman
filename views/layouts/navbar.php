<?php
$config = include __DIR__ . '/../../config/app.php';
?>
<!-- Navbar Top -->
<nav class="navbar navbar-top navbar-expand navbar-light px-4">
    <div class="container-fluid ps-0">
        <span class="navbar-brand mb-0 h6 fw-bold text-dark">
            <i class="bi bi-grid-1x2-fill me-2 text-primary"></i> Pengembangan Soal Aplikasi Peminjaman Alat
        </span>
        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-dark fw-semibold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-1 text-secondary"></i> 
                    <?php echo htmlspecialchars($_SESSION['nama_lengkap'] ?? 'User'); ?> 
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
