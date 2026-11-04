<?php
require_once __DIR__ . '/../models/LogAktivitas.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

class LogAktivitasController {
    public function index() {
        RoleMiddleware::allow(['admin']);
        $logModel = new LogAktivitas();
        $logs = $logModel->getAll(200);

        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/admin/log-aktivitas/index.php';
    }
}
