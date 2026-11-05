<?php
$role = $_SESSION['role'] ?? '';
$config = include __DIR__ . '/../../config/app.php';
?>
<!-- Sidebar -->
<div id="appSidebar" class="sidebar d-flex flex-column flex-shrink-0">
    <div class="brand text-white">
        <i class="bi bi-tools text-info me-2"></i>UKK RPL 2026/2027
    </div>
    <div class="sidebar-user mx-3 mt-3 mb-2 p-3">
        <div class="d-flex align-items-center gap-2">
            <div class="sidebar-avatar"><i class="bi bi-person-fill"></i></div>
            <div class="text-truncate">
                <div class="small text-muted">Masuk sebagai</div>
                <strong class="d-block text-truncate"><?php echo htmlspecialchars($_SESSION['nama_lengkap'] ?? 'User'); ?></strong>
            </div>
        </div>
        <span class="badge bg-light text-dark border mt-2 text-capitalize"><?php echo htmlspecialchars($role); ?></span>
    </div>
    <ul class="nav nav-pills flex-column mb-auto mt-3">
        <?php if ($role === 'admin'): ?>
            <li class="nav-item">
                <a href="<?php echo $config['base_url']; ?>/index.php?route=admin/dashboard" class="nav-link <?php echo (isset($_GET['route']) && $_GET['route'] === 'admin/dashboard') ? 'active' : ''; ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo $config['base_url']; ?>/index.php?route=admin/users" class="nav-link <?php echo (isset($_GET['route']) && strpos($_GET['route'], 'admin/users') !== false) ? 'active' : ''; ?>">
                    <i class="bi bi-people"></i> Manajemen User
                </a>
            </li>
            <li>
                <a href="<?php echo $config['base_url']; ?>/index.php?route=admin/peminjam" class="nav-link <?php echo (isset($_GET['route']) && strpos($_GET['route'], 'admin/peminjam') !== false) ? 'active' : ''; ?>">
                    <i class="bi bi-person-lines-fill"></i> Data Peminjam
                </a>
            </li>
            <li>
                <a href="<?php echo $config['base_url']; ?>/index.php?route=admin/kategori" class="nav-link <?php echo (isset($_GET['route']) && strpos($_GET['route'], 'admin/kategori') !== false) ? 'active' : ''; ?>">
                    <i class="bi bi-tags"></i> Kategori Alat
                </a>
            </li>
            <li>
                <a href="<?php echo $config['base_url']; ?>/index.php?route=admin/alat" class="nav-link <?php echo (isset($_GET['route']) && strpos($_GET['route'], 'admin/alat') !== false) ? 'active' : ''; ?>">
                    <i class="bi bi-cpu"></i> Data Alat
                </a>
            </li>
            <li>
                <a href="<?php echo $config['base_url']; ?>/index.php?route=admin/pengembalian" class="nav-link <?php echo (isset($_GET['route']) && strpos($_GET['route'], 'admin/pengembalian') !== false) ? 'active' : ''; ?>">
                    <i class="bi bi-arrow-return-left"></i> Pengembalian Alat
                </a>
            </li>
            <li>
                <a href="<?php echo $config['base_url']; ?>/index.php?route=admin/log-aktivitas" class="nav-link <?php echo (isset($_GET['route']) && strpos($_GET['route'], 'admin/log-aktivitas') !== false) ? 'active' : ''; ?>">
                    <i class="bi bi-clock-history"></i> Log Aktivitas
                </a>
            </li>
        <?php elseif ($role === 'petugas'): ?>
            <li class="nav-item">
                <a href="<?php echo $config['base_url']; ?>/index.php?route=petugas/dashboard" class="nav-link <?php echo (isset($_GET['route']) && $_GET['route'] === 'petugas/dashboard') ? 'active' : ''; ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo $config['base_url']; ?>/index.php?route=petugas/persetujuan" class="nav-link <?php echo (isset($_GET['route']) && strpos($_GET['route'], 'petugas/persetujuan') !== false) ? 'active' : ''; ?>">
                    <i class="bi bi-check2-square"></i> Persetujuan Pinjam
                </a>
            </li>
            <li>
                <a href="<?php echo $config['base_url']; ?>/index.php?route=petugas/pengembalian" class="nav-link <?php echo (isset($_GET['route']) && strpos($_GET['route'], 'petugas/pengembalian') !== false) ? 'active' : ''; ?>">
                    <i class="bi bi-arrow-return-left"></i> Pengembalian Alat
                </a>
            </li>
            <li>
                <a href="<?php echo $config['base_url']; ?>/index.php?route=petugas/laporan" class="nav-link <?php echo (isset($_GET['route']) && strpos($_GET['route'], 'petugas/laporan') !== false) ? 'active' : ''; ?>">
                    <i class="bi bi-file-earmark-text"></i> Laporan Transaksi
                </a>
            </li>
        <?php elseif ($role === 'peminjam'): ?>
            <li class="nav-item">
                <a href="<?php echo $config['base_url']; ?>/index.php?route=peminjam/dashboard" class="nav-link <?php echo (isset($_GET['route']) && $_GET['route'] === 'peminjam/dashboard') ? 'active' : ''; ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo $config['base_url']; ?>/index.php?route=peminjam/daftar-alat" class="nav-link <?php echo (isset($_GET['route']) && strpos($_GET['route'], 'peminjam/daftar-alat') !== false) ? 'active' : ''; ?>">
                    <i class="bi bi-box-seam"></i> Katalog Alat
                </a>
            </li>
            <li>
                <a href="<?php echo $config['base_url']; ?>/index.php?route=peminjam/pengajuan" class="nav-link <?php echo (isset($_GET['route']) && strpos($_GET['route'], 'peminjam/pengajuan') !== false) ? 'active' : ''; ?>">
                    <i class="bi bi-plus-circle"></i> Ajukan Peminjaman
                </a>
            </li>
            <li>
                <a href="<?php echo $config['base_url']; ?>/index.php?route=peminjam/pengembalian" class="nav-link <?php echo (isset($_GET['route']) && strpos($_GET['route'], 'peminjam/pengembalian') !== false) ? 'active' : ''; ?>">
                    <i class="bi bi-arrow-return-left"></i> Pengembalian Alat
                </a>
            </li>
            <li>
                <a href="<?php echo $config['base_url']; ?>/index.php?route=peminjam/riwayat" class="nav-link <?php echo (isset($_GET['route']) && strpos($_GET['route'], 'peminjam/riwayat') !== false) ? 'active' : ''; ?>">
                    <i class="bi bi-clock-history"></i> Riwayat & Denda
                </a>
            </li>
        <?php endif; ?>
    </ul>
    <div class="p-3 border-top border-secondary">
        <a href="<?php echo $config['base_url']; ?>/index.php?route=logout" class="btn btn-outline-light w-100 btn-sm">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
        </a>
    </div>
</div>
