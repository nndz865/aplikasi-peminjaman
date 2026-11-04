<?php
require_once __DIR__ . '/../models/Kategori.php';
require_once __DIR__ . '/../models/LogAktivitas.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

class KategoriController {
    public function index() {
        RoleMiddleware::allow(['admin']);
        $kategoriModel = new Kategori();
        $search = $_GET['search'] ?? '';
        $kategoris = $kategoriModel->getAll($search);

        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/admin/kategori/index.php';
    }

    public function store() {
        RoleMiddleware::allow(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                set_flash_message('danger', 'Token CSRF tidak valid.');
                $config = include __DIR__ . '/../config/app.php';
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/kategori');
                exit;
            }

            $nama_kategori = trim($_POST['nama_kategori'] ?? '');
            $deskripsi = trim($_POST['deskripsi'] ?? '');

            if (empty($nama_kategori)) {
                set_flash_message('danger', 'Nama kategori wajib diisi.');
                $config = include __DIR__ . '/../config/app.php';
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/kategori');
                exit;
            }

            $kategoriModel = new Kategori();
            $success = $kategoriModel->create(['nama_kategori' => $nama_kategori, 'deskripsi' => $deskripsi]);

            if ($success) {
                $logModel = new LogAktivitas();
                $logModel->catat($_SESSION['user_id'], 'TAMBAH KATEGORI', "Menambahkan kategori: $nama_kategori");
                set_flash_message('success', 'Kategori berhasil ditambahkan.');
            } else {
                set_flash_message('danger', 'Gagal menambahkan kategori.');
            }

            $config = include __DIR__ . '/../config/app.php';
            header('Location: ' . $config['base_url'] . '/index.php?route=admin/kategori');
            exit;
        }
    }

    public function update() {
        RoleMiddleware::allow(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                set_flash_message('danger', 'Token CSRF tidak valid.');
                $config = include __DIR__ . '/../config/app.php';
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/kategori');
                exit;
            }

            $id = $_POST['id_kategori'] ?? null;
            $nama_kategori = trim($_POST['nama_kategori'] ?? '');
            $deskripsi = trim($_POST['deskripsi'] ?? '');

            if (!$id || empty($nama_kategori)) {
                set_flash_message('danger', 'Data tidak lengkap.');
                $config = include __DIR__ . '/../config/app.php';
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/kategori');
                exit;
            }

            $kategoriModel = new Kategori();
            $success = $kategoriModel->update($id, ['nama_kategori' => $nama_kategori, 'deskripsi' => $deskripsi]);

            if ($success) {
                $logModel = new LogAktivitas();
                $logModel->catat($_SESSION['user_id'], 'EDIT KATEGORI', "Memperbarui kategori ID: $id ($nama_kategori)");
                set_flash_message('success', 'Kategori berhasil diperbarui.');
            } else {
                set_flash_message('danger', 'Gagal memperbarui kategori.');
            }

            $config = include __DIR__ . '/../config/app.php';
            header('Location: ' . $config['base_url'] . '/index.php?route=admin/kategori');
            exit;
        }
    }

    public function delete() {
        RoleMiddleware::allow(['admin']);
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $config = include __DIR__ . '/../config/app.php';
            header('Location: ' . $config['base_url'] . '/index.php?route=admin/kategori');
            exit;
        }

        $kategoriModel = new Kategori();
        $success = $kategoriModel->delete($id);

        $config = include __DIR__ . '/../config/app.php';
        if ($success) {
            $logModel = new LogAktivitas();
            $logModel->catat($_SESSION['user_id'], 'HAPUS KATEGORI', "Menghapus kategori ID: $id");
            set_flash_message('success', 'Kategori berhasil dihapus.');
        } else {
            set_flash_message('danger', 'Gagal menghapus kategori. Kategori masih digunakan oleh data alat.');
        }

        header('Location: ' . $config['base_url'] . '/index.php?route=admin/kategori');
        exit;
    }
}
