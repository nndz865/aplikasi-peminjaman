<?php
require_once __DIR__ . '/../models/LogAktivitas.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

class LogAktivitasController {
    public function index() {
        RoleMiddleware::allow(['admin']);
        $logModel = new LogAktivitas();
        $logs = $logModel->getAll(500);

        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/admin/log-aktivitas/index.php';
    }

    public function exportCsv() {
        RoleMiddleware::allow(['admin']);
        $logModel = new LogAktivitas();
        $logs = $logModel->getAll(10000);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=log_aktivitas_' . date('Y-m-d_H-i-s') . '.csv');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID Log', 'Username', 'Nama Lengkap', 'Role', 'Aktivitas', 'Deskripsi', 'IP Address', 'Waktu']);

        foreach ($logs as $log) {
            fputcsv($output, [
                $log['id_log'],
                $log['username'],
                $log['nama_lengkap'],
                $log['role'],
                $log['aktivitas'],
                $log['deskripsi'],
                $log['ip_address'],
                $log['created_at']
            ]);
        }

        fclose($output);
        exit;
    }
}
