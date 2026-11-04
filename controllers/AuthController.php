<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/LogAktivitas.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class AuthController {
    public function showLogin() {
        AuthMiddleware::guest();
        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function login() {
        AuthMiddleware::guest();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                set_flash_message('danger', 'Username/Password Salah');
                $config = include __DIR__ . '/../config/app.php';
                header('Location: ' . $config['base_url'] . '/index.php?route=login');
                exit;
            }

            $userModel = new User();
            $user = $userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Catat log aktivitas
                $logModel = new LogAktivitas();
                $logModel->catat($user['id_user'], 'LOGIN', 'Pengguna ' . $user['username'] . ' berhasil login.');

                set_flash_message('success', 'Selamat datang kembali, ' . $user['nama_lengkap'] . '!');
                AuthMiddleware::redirectByRole($user['role']);
            } else {
                set_flash_message('danger', 'Username/Password Salah');
                $config = include __DIR__ . '/../config/app.php';
                header('Location: ' . $config['base_url'] . '/index.php?route=login');
                exit;
            }
        }
    }

    public function logout() {
        AuthMiddleware::check();

        $user_id = $_SESSION['user_id'] ?? null;
        $username = $_SESSION['username'] ?? '';

        if ($user_id) {
            $logModel = new LogAktivitas();
            $logModel->catat($user_id, 'LOGOUT', 'Pengguna ' . $username . ' keluar sistem.');
        }

        session_unset();
        session_destroy();

        $config = include __DIR__ . '/../config/app.php';
        session_start();
        set_flash_message('success', 'Anda telah berhasil logout.');
        header('Location: ' . $config['base_url'] . '/index.php?route=login');
        exit;
    }
}
