<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/LogAktivitas.php';
require_once __DIR__ . '/../models/Kategori.php';
require_once __DIR__ . '/../models/Alat.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

class UserController {
    public function index() {
        RoleMiddleware::allow(['admin']);
        $userModel = new User();
        $roleFilter = $_GET['role'] ?? '';
        $search = $_GET['search'] ?? '';
        $users = $userModel->getAll($roleFilter, $search);

        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/admin/users/index.php';
    }

    public function create() {
        RoleMiddleware::allow(['admin']);
        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/admin/users/create.php';
    }

    public function store() {
        RoleMiddleware::allow(['admin']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $config = include __DIR__ . '/../config/app.php';
            
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                set_flash_message('danger', 'Token CSRF tidak valid.');
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/users');
                exit;
            }

            $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? '';

            if (empty($nama_lengkap) || empty($username) || empty($password) || empty($role)) {
                set_flash_message('danger', 'Semua field wajib diisi.');
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/users/create');
                exit;
            }

            if (!in_array($role, ['admin', 'petugas', 'peminjam'])) {
                set_flash_message('danger', 'Role tidak valid.');
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/users/create');
                exit;
            }

            $userModel = new User();
            if ($userModel->findByUsername($username)) {
                set_flash_message('danger', 'Username sudah digunakan.');
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/users/create');
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $success = $userModel->create([
                'nama_lengkap' => $nama_lengkap,
                'username' => $username,
                'password' => $hashedPassword,
                'role' => $role
            ]);

            if ($success) {
                $logModel = new LogAktivitas();
                $logModel->catat($_SESSION['user_id'], 'TAMBAH USER', "Menambahkan user baru: $username ($role)");
                set_flash_message('success', 'Pengguna berhasil ditambahkan.');
            } else {
                set_flash_message('danger', 'Gagal menambahkan pengguna.');
            }

            header('Location: ' . $config['base_url'] . '/index.php?route=admin/users');
            exit;
        }
    }

    public function edit() {
        RoleMiddleware::allow(['admin']);
        $id = $_GET['id'] ?? null;
        $config = include __DIR__ . '/../config/app.php';
        if (!$id) {
            header('Location: ' . $config['base_url'] . '/index.php?route=admin/users');
            exit;
        }

        $userModel = new User();
        $user = $userModel->findById($id);
        if (!$user) {
            set_flash_message('danger', 'Pengguna tidak ditemukan.');
            header('Location: ' . $config['base_url'] . '/index.php?route=admin/users');
            exit;
        }

        require_once __DIR__ . '/../views/admin/users/edit.php';
    }

    public function update() {
        RoleMiddleware::allow(['admin']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $config = include __DIR__ . '/../config/app.php';

            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                set_flash_message('danger', 'Token CSRF tidak valid.');
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/users');
                exit;
            }

            $id = $_POST['id_user'] ?? null;
            $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? '';

            if (!$id || empty($nama_lengkap) || empty($username) || empty($role)) {
                set_flash_message('danger', 'Data wajib diisi.');
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/users/edit&id=' . $id);
                exit;
            }

            $userModel = new User();
            $existing = $userModel->findByUsername($username);
            if ($existing && $existing['id_user'] != $id) {
                set_flash_message('danger', 'Username sudah digunakan oleh pengguna lain.');
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/users/edit&id=' . $id);
                exit;
            }

            if ($id == $_SESSION['user_id'] && $role !== 'admin') {
                $totalAdmin = $userModel->countAdmin();
                if ($totalAdmin <= 1) {
                    set_flash_message('danger', 'Tidak dapat mengubah role admin terakhir.');
                    header('Location: ' . $config['base_url'] . '/index.php?route=admin/users/edit&id=' . $id);
                    exit;
                }
            }

            $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : '';
            $success = $userModel->update($id, [
                'nama_lengkap' => $nama_lengkap,
                'username' => $username,
                'password' => $hashedPassword,
                'role' => $role
            ]);

            if ($success) {
                $logModel = new LogAktivitas();
                $logModel->catat($_SESSION['user_id'], 'EDIT USER', "Mengubah data user ID: $id ($username)");
                set_flash_message('success', 'Pengguna berhasil diperbarui.');
            } else {
                set_flash_message('danger', 'Gagal memperbarui pengguna.');
            }

            header('Location: ' . $config['base_url'] . '/index.php?route=admin/users');
            exit;
        }
    }

    public function delete() {
        RoleMiddleware::allow(['admin']);
        $id = $_GET['id'] ?? null;
        $config = include __DIR__ . '/../config/app.php';

        $userModel = new User();
        $targetUser = $userModel->findById($id);

        if (!$targetUser) {
            set_flash_message('danger', 'Pengguna tidak ditemukan.');
            header('Location: ' . $config['base_url'] . '/index.php?route=admin/users');
            exit;
        }

        if ($id == $_SESSION['user_id']) {
            set_flash_message('danger', 'Tidak dapat menghapus akun yang sedang Anda gunakan.');
            header('Location: ' . $config['base_url'] . '/index.php?route=admin/users');
            exit;
        }

        if ($targetUser['role'] === 'admin') {
            $totalAdmin = $userModel->countAdmin();
            if ($totalAdmin <= 1) {
                set_flash_message('danger', 'Tidak dapat menghapus akun admin terakhir.');
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/users');
                exit;
            }
        }

        $success = $userModel->delete($id);
        if ($success) {
            $logModel = new LogAktivitas();
            $logModel->catat($_SESSION['user_id'], 'HAPUS USER', "Menghapus user ID: $id");
            set_flash_message('success', 'Pengguna berhasil dihapus.');
        } else {
            set_flash_message('danger', 'Gagal menghapus pengguna.');
        }

        header('Location: ' . $config['base_url'] . '/index.php?route=admin/users');
        exit;
    }
}
