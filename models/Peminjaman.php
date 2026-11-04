<?php
require_once __DIR__ . '/../config/database.php';

class Peminjaman {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function ajukanPinjam($id_user, $id_alat, $jumlah, $tanggal_pinjam, $tanggal_rencana_kembali, $keperluan) {
        $stmt = $this->db->prepare("CALL sp_pinjam_alat(?, ?, ?, ?, ?, ?, @res, @msg)");
        $stmt->execute([$id_user, $id_alat, $jumlah, $tanggal_pinjam, $tanggal_rencana_kembali, $keperluan]);
        
        $out = $this->db->query("SELECT @res AS result, @msg AS message")->fetch();
        return $out;
    }

    public function getAll($status = null, $user_id = null, $filters = []) {
        $sql = "SELECT p.*, u.nama_lengkap, a.nama_alat, a.lokasi 
                FROM peminjaman p 
                JOIN users u ON p.id_user = u.id_user 
                JOIN alat a ON p.id_alat = a.id_alat 
                WHERE 1=1";
        $params = [];

        if (!empty($status)) {
            $sql .= " AND p.status = ?";
            $params[] = $status;
        }

        if (!empty($user_id)) {
            $sql .= " AND p.id_user = ?";
            $params[] = $user_id;
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $sql .= " AND p.tanggal_pinjam BETWEEN ? AND ?";
            $params[] = $filters['start_date'];
            $params[] = $filters['end_date'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (p.kode_peminjaman LIKE ? OR u.nama_lengkap LIKE ? OR a.nama_alat LIKE ?)";
            $params[] = "%" . $filters['search'] . "%";
            $params[] = "%" . $filters['search'] . "%";
            $params[] = "%" . $filters['search'] . "%";
        }

        $sql .= " ORDER BY p.id_peminjaman DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT p.*, u.nama_lengkap, u.username, a.nama_alat, a.stok as stok_sekarang, a.lokasi 
                                    FROM peminjaman p 
                                    JOIN users u ON p.id_user = u.id_user 
                                    JOIN alat a ON p.id_alat = a.id_alat 
                                    WHERE p.id_peminjaman = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateStatus($id, $status) {
        // Ambil data peminjaman dulu
        $peminjaman = $this->findById($id);
        if (!$peminjaman) return false;

        $stmt = $this->db->prepare("UPDATE peminjaman SET status = ? WHERE id_peminjaman = ?");
        return $stmt->execute([$status, $id]);
    }

    public function prosesPengembalian($id, $tanggal_kembali_aktual) {
        $peminjaman = $this->findById($id);
        if (!$peminjaman || $peminjaman['status'] !== 'disetujui') {
            return ['success' => false, 'message' => 'Transaksi tidak valid atau belum disetujui.'];
        }

        if ($tanggal_kembali_aktual < $peminjaman['tanggal_pinjam']) {
            return ['success' => false, 'message' => 'Tanggal kembali aktual tidak boleh lebih awal dari tanggal pinjam.'];
        }

        // Hitung denda menggunakan function MySQL hitung_denda()
        $stmt = $this->db->prepare("SELECT hitung_denda(?, ?) as denda");
        $stmt->execute([$peminjaman['tanggal_rencana_kembali'], $tanggal_kembali_aktual]);
        $resDenda = $stmt->fetch();
        $denda = $resDenda['denda'] ?? 0;

        try {
            $this->db->beginTransaction();

            // Update tanggal kembali aktual, denda, dan status menjadi selesai (trigger trg_tambah_stok akan otomatis menambah stok)
            $stmtUp = $this->db->prepare("UPDATE peminjaman SET tanggal_kembali_aktual = ?, denda = ?, status = 'selesai' WHERE id_peminjaman = ?");
            $stmtUp->execute([$tanggal_kembali_aktual, $denda, $id]);

            $this->db->commit();
            return ['success' => true, 'message' => 'Pengembalian berhasil diproses. Denda: Rp ' . number_format($denda, 0, ',', '.'), 'denda' => $denda];
        } catch (\Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'message' => 'Gagal memproses pengembalian: ' . $e->getMessage()];
        }
    }

    public function countByStatus($status) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM peminjaman WHERE status = ?");
        $stmt->execute([$status]);
        $res = $stmt->fetch();
        return $res['total'] ?? 0;
    }

    public function countAll() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM peminjaman");
        $res = $stmt->fetch();
        return $res['total'] ?? 0;
    }

    public function sumTotalDenda() {
        $stmt = $this->db->query("SELECT SUM(denda) as total FROM peminjaman");
        $res = $stmt->fetch();
        return $res['total'] ?? 0;
    }

    public function countTerlambat() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM peminjaman WHERE status = 'disetujui' AND CURDATE() > tanggal_rencana_kembali");
        $res = $stmt->fetch();
        return $res['total'] ?? 0;
    }

    public function countUserStats($user_id) {
        $stmt = $this->db->prepare("SELECT 
            SUM(CASE WHEN status = 'menunggu' THEN 1 ELSE 0 END) as menunggu,
            SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as disetujui,
            SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) as selesai,
            SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as ditolak,
            SUM(denda) as total_denda,
            COUNT(*) as total
            FROM peminjaman WHERE id_user = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }
}
