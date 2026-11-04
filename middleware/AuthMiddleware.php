<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/app.php';

class AuthMiddleware {
    public static function check() {
        if (!isset($_SESSION['user_id'])) {
            set_flash_message('danger', 'Silakan login terlebih dahulu.');
            $config = include __DIR__ . '/../config/app.php';
            header('Location: ' . $config['base_url'] . '/index.php?route=login');
            exit;
        }
    }

    public static function guest() {
        if (isset($_SESSION['user_id'])) {
            self::redirectByRole($_SESSION['role']);
        }
    }

    public static function redirectByRole($role) {
        $config = include __DIR__ . '/../config/app.php';
        switch ($role) {
            case 'admin':
                header('Location: ' . $config['base_url'] . '/index.php?route=admin/dashboard');
                break;
            case 'petugas':
                header('Location: ' . $config['base_url'] . '/index.php?route=petugas/dashboard');
                break;
            case 'peminjam':
                header('Location: ' . $config['base_url'] . '/index.php?route=peminjam/dashboard');
                break;
            default:
                header('Location: ' . $config['base_url'] . '/index.php?route=login');
                break;
        }
        exit;
    }
}
