<?php
require_once __DIR__ . '/../models/Setting.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class SettingController {
    public function index() {
        AuthMiddleware::checkRole('admin');
        $settingModel = new Setting();
        $settings = $settingModel->getSettings();
        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/admin/settings.php';
    }

    public function update() {
        AuthMiddleware::checkRole('admin');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settingModel = new Setting();
            $settingModel->updateSettings($_POST['lab_name'], $_POST['denda'], $_POST['max_hari']);
            set_flash_message('success', 'Pengaturan sistem berhasil diperbarui.');
            $config = include __DIR__ . '/../config/app.php';
            header('Location: ' . $config['base_url'] . '/index.php?route=admin/settings');
            exit;
        }
    }
}
