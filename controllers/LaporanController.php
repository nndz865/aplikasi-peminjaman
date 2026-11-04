<?php
require_once __DIR__ . '/../models/Peminjaman.php';
require_once __DIR__ . '/../models/Alat.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

class LaporanController {
    public function index() {
        RoleMiddleware::allow(['petugas']);
        $peminjamanModel = new Peminjaman();

        $status = $_GET['status'] ?? '';
        $start_date = $_GET['start_date'] ?? '';
        $end_date = $_GET['end_date'] ?? '';
        $search = $_GET['search'] ?? '';

        $filters = [
            'search' => $search,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        $laporans = $peminjamanModel->getAll($status ?: null, null, $filters);
        $totalDenda = 0;
        foreach ($laporans as $l) {
            $totalDenda += $l['denda'];
        }

        $config = include __DIR__ . '/../config/app.php';
        require_once __DIR__ . '/../views/petugas/laporan/index.php';
    }
}
