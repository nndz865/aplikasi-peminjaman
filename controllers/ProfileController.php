<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../config/session.php';

class ProfileController {
    public function edit() {
        AuthMiddleware::check();
        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);
        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/profile/edit.php';
    }

    public function update() {
        AuthMiddleware::check();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $config = include __DIR__ . '/../config/app.php';
            
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                set_flash_message('danger', 'Token CSRF tidak valid.');
                header('Location: ' . $config['base_url'] . '/index.php?route=profile/edit');
                exit;
            }

            $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
            $password_baru = $_POST['password_baru'] ?? '';

            if (empty($nama_lengkap)) {
                set_flash_message('danger', 'Nama lengkap wajib diisi.');
                header('Location: ' . $config['base_url'] . '/index.php?route=profile/edit');
                exit;
            }

            $userModel = new User();
            $data = ['nama_lengkap' => $nama_lengkap];
            if (!empty($password_baru)) {
                $data['password'] = password_hash($password_baru, PASSWORD_DEFAULT);
            }

            if ($userModel->update($_SESSION['user_id'], $data)) {
                $_SESSION['nama_lengkap'] = $nama_lengkap;
                set_flash_message('success', 'Profil berhasil diperbarui.');
            } else {
                set_flash_message('danger', 'Gagal memperbarui profil.');
            }
            header('Location: ' . $config['base_url'] . '/index.php?route=profile/edit');
            exit;
        }
    }
}
