<?php
require_once __DIR__ . '/../models/Alat.php';
require_once __DIR__ . '/../models/Kategori.php';
require_once __DIR__ . '/../models/LogAktivitas.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

class AlatController {
    private function uploadGambar($file) {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return null;
        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK || $file['size'] > 2 * 1024 * 1024) return false;
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        if (!isset($extensions[$mime])) return false;
        $directory = __DIR__ . '/../public/assets/uploads/alat';
        if (!is_dir($directory) && !mkdir($directory, 0755, true)) return false;
        $filename = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
        return move_uploaded_file($file['tmp_name'], $directory . '/' . $filename) ? 'assets/uploads/alat/' . $filename : false;
    }

    public function index() {
        RoleMiddleware::allow(['admin']);
        $alatModel = new Alat();
        $kategoriModel = new Kategori();

        $kategori_id = $_GET['kategori'] ?? null;
        $search = $_GET['search'] ?? '';

        $alats = $alatModel->getAll($kategori_id, $search);
        $kategoris = $kategoriModel->getAll();

        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/admin/alat/index.php';
    }

    public function create() {
        RoleMiddleware::allow(['admin']);
        $kategoriModel = new Kategori();
        $kategoris = $kategoriModel->getAll();
        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/admin/alat/create.php';
    }

    public function store() {
        RoleMiddleware::allow(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                set_flash_message('danger', 'Token CSRF tidak valid.');
                $config = include __DIR__ . '/../config/app.php';
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/alat');
                exit;
            }

            $id_kategori = $_POST['id_kategori'] ?? '';
            $nama_alat = trim($_POST['nama_alat'] ?? '');
            $deskripsi = trim($_POST['deskripsi'] ?? '');
            $stok = (int)($_POST['stok'] ?? 0);
            $kondisi = trim($_POST['kondisi'] ?? 'Baik');
            $lokasi = trim($_POST['lokasi'] ?? '');
            $gambar = $this->uploadGambar($_FILES['gambar'] ?? []);

            if ($gambar === false || empty($id_kategori) || empty($nama_alat) || $stok < 0 || empty($lokasi)) {
                set_flash_message('danger', 'Data alat tidak lengkap atau stok bernilai negatif.');
                $config = include __DIR__ . '/../config/app.php';
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/alat/create');
                exit;
            }

            $alatModel = new Alat();
            $success = $alatModel->create([
                'id_kategori' => $id_kategori,
                'nama_alat' => $nama_alat,
                'deskripsi' => $deskripsi,
                'stok' => $stok,
                'kondisi' => $kondisi,
                'lokasi' => $lokasi,
                'gambar' => $gambar
            ]);

            $config = include __DIR__ . '/../config/app.php';
            if ($success) {
                $logModel = new LogAktivitas();
                $logModel->catat($_SESSION['user_id'], 'TAMBAH ALAT', "Menambahkan alat baru: $nama_alat (Stok: $stok)");
                set_flash_message('success', 'Alat berhasil ditambahkan.');
            } else {
                set_flash_message('danger', 'Gagal menambahkan alat.');
            }

            header('Location: ' . $config['base_url'] . '/index.php?route=admin/alat');
            exit;
        }
    }

    public function edit() {
        RoleMiddleware::allow(['admin']);
        $id = $_GET['id'] ?? null;
        $config = include __DIR__ . '/../config/app.php';
        if (!$id) {
            header('Location: ' . $config['base_url'] . '/index.php?route=admin/alat');
            exit;
        }

        $alatModel = new Alat();
        $kategoriModel = new Kategori();

        $alat = $alatModel->findById($id);
        $kategoris = $kategoriModel->getAll();

        if (!$alat) {
            set_flash_message('danger', 'Alat tidak ditemukan.');
            header('Location: ' . $config['base_url'] . '/index.php?route=admin/alat');
            exit;
        }

        require_once __DIR__ . '/../views/admin/alat/edit.php';
    }

    public function update() {
        RoleMiddleware::allow(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                set_flash_message('danger', 'Token CSRF tidak valid.');
                $config = include __DIR__ . '/../config/app.php';
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/alat');
                exit;
            }

            $id = $_POST['id_alat'] ?? null;
            $id_kategori = $_POST['id_kategori'] ?? '';
            $nama_alat = trim($_POST['nama_alat'] ?? '');
            $deskripsi = trim($_POST['deskripsi'] ?? '');
            $stok = (int)($_POST['stok'] ?? 0);
            $kondisi = trim($_POST['kondisi'] ?? 'Baik');
            $lokasi = trim($_POST['lokasi'] ?? '');
            $gambar = $this->uploadGambar($_FILES['gambar'] ?? []);

            if ($gambar === false || !$id || empty($id_kategori) || empty($nama_alat) || $stok < 0 || empty($lokasi)) {
                set_flash_message('danger', 'Data tidak lengkap atau stok negatif.');
                $config = include __DIR__ . '/../config/app.php';
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/alat/edit&id=' . $id);
                exit;
            }

            $alatModel = new Alat();
            $data = [
                'id_kategori' => $id_kategori,
                'nama_alat' => $nama_alat,
                'deskripsi' => $deskripsi,
                'stok' => $stok,
                'kondisi' => $kondisi,
                'lokasi' => $lokasi
            ];
            if ($gambar !== null) $data['gambar'] = $gambar;
            $success = $alatModel->update($id, $data);

            $config = include __DIR__ . '/../config/app.php';
            if ($success) {
                $logModel = new LogAktivitas();
                $logModel->catat($_SESSION['user_id'], 'EDIT ALAT', "Memperbarui alat ID: $id ($nama_alat)");
                set_flash_message('success', 'Alat berhasil diperbarui.');
            } else {
                set_flash_message('danger', 'Gagal memperbarui alat.');
            }

            header('Location: ' . $config['base_url'] . '/index.php?route=admin/alat');
            exit;
        }
    }

    public function delete() {
        RoleMiddleware::allow(['admin']);
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $config = include __DIR__ . '/../config/app.php';
            header('Location: ' . $config['base_url'] . '/index.php?route=admin/alat');
            exit;
        }

        $alatModel = new Alat();
        $success = $alatModel->delete($id);

        $config = include __DIR__ . '/../config/app.php';
        if ($success) {
            $logModel = new LogAktivitas();
            $logModel->catat($_SESSION['user_id'], 'HAPUS ALAT', "Menghapus alat ID: $id");
            set_flash_message('success', 'Alat berhasil dihapus.');
        } else {
            set_flash_message('danger', 'Gagal menghapus alat. Alat terkait dengan riwayat transaksi peminjaman.');
        }

        header('Location: ' . $config['base_url'] . '/index.php?route=admin/alat');
        exit;
    }
}
