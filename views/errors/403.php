<?php
$page_title = '403 Forbidden - Aplikasi Peminjaman Alat';
$baseUrl = $config['base_url'] ?? 'http://localhost/aplikasi-peminjaman-1/public';
require_once __DIR__ . '/../layouts/header.php';
?>
<div class="container text-center py-5" style="margin-top: 10vh;">
    <div class="display-1 fw-bold text-danger mb-3">403</div>
    <h2 class="fw-bold mb-2">Akses Ditolak (Forbidden)</h2>
    <p class="text-muted mb-4">Anda tidak memiliki hak akses yang diperlukan untuk membuka halaman ini.</p>
    <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php" class="btn btn-primary px-4 py-2">Kembali ke Beranda</a>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>



