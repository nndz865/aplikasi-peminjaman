<?php
$page_title = 'Form Pengajuan Peminjaman - Aplikasi Peminjaman Alat';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
require_once __DIR__ . '/../layouts/navbar.php';

$alats = $alats ?? [];
$selectedAlat = $alat ?? null;
$baseUrl = $config['base_url'] ?? '';
$csrfToken = $_SESSION['csrf_token'] ?? '';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold py-3">
                <i class="bi bi-plus-circle me-2 text-primary"></i> Form Pengajuan Peminjaman Alat
            </div>
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=peminjam/pengajuan/store" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Alat</label>
                        <select name="id_alat" class="form-select" required onchange="updateStokInfo(this)">
                            <option value="">-- Pilih Alat Praktikum --</option>
                            <?php foreach ($alats as $a): ?>
                                <option value="<?php echo (int)($a['id_alat'] ?? 0); ?>" data-stok="<?php echo (int)($a['stok'] ?? 0); ?>" <?php echo (($selectedAlat && $selectedAlat['id_alat'] == $a['id_alat']) ? 'selected' : ''); ?>>
                                    <?php echo htmlspecialchars($a['nama_alat'] ?? ''); ?> (Stok: <?php echo (int)($a['stok'] ?? 0); ?> unit - <?php echo htmlspecialchars($a['lokasi'] ?? ''); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jumlah Peminjaman</label>
                            <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
                            <div class="form-text small" id="stokInfo">Stok mencukupi.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Rencana Pengembalian</label>
                        <input type="date" name="tanggal_rencana_kembali" class="form-control" value="<?php echo date('Y-m-d', strtotime('+3 days')); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Keperluan / Keterangan Praktikum</label>
                        <textarea name="keperluan" class="form-control" rows="3" placeholder="Contoh: Praktikum Jaringan Komputer Bab Routing" required></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo htmlspecialchars($baseUrl); ?>/index.php?route=peminjam/daftar-alat" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function updateStokInfo(select) {
    var opt = select.options[select.selectedIndex];
    var stok = opt.getAttribute('data-stok');
    var info = document.getElementById('stokInfo');
    if (stok) {
        info.innerHTML = "Stok tersedia: <strong>" + stok + " unit</strong>";
    } else {
        info.innerHTML = "";
    }
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>



