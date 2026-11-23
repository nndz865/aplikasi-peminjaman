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

    public function exportCsv() {
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

        $filename = 'laporan_peminjaman_' . date('Y-m-d_H-i-s') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        
        // UTF-8 BOM for Excel
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // Header CSV
        fputcsv($output, ['ID Peminjaman', 'Nama Peminjam', 'Nama Alat', 'Jumlah', 'Tanggal Pinjam', 'Tanggal Kembali Rencana', 'Tanggal Kembali Aktual', 'Status', 'Denda (Rp)', 'Petugas']);

        foreach ($laporans as $row) {
            fputcsv($output, [
                $row['id'] ?? '',
                $row['nama_peminjam'] ?? '',
                $row['nama_alat'] ?? '',
                $row['jumlah'] ?? 0,
                $row['tanggal_pinjam'] ?? '',
                $row['tanggal_kembali_rencana'] ?? '',
                $row['tanggal_kembali_aktual'] ?? '',
                $row['status'] ?? '',
                $row['denda'] ?? 0,
                $row['nama_petugas'] ?? '-'
            ]);
        }

        fclose($output);
        exit;
    }
}
