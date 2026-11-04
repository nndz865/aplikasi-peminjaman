<?php
require_once __DIR__ . '/../config/database.php';

class LogAktivitas {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function catat($id_user, $aktivitas, $deskripsi) {
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $stmt = $this->db->prepare("INSERT INTO log_aktivitas (id_user, aktivitas, deskripsi, ip_address) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$id_user, $aktivitas, $deskripsi, $ip_address]);
    }

    public function getAll($limit = 100) {
        $stmt = $this->db->prepare("SELECT l.*, u.nama_lengkap, u.username, u.role 
                                    FROM log_aktivitas l 
                                    JOIN users u ON l.id_user = u.id_user 
                                    ORDER BY l.id_log DESC LIMIT ?");
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countAll() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM log_aktivitas");
        $res = $stmt->fetch();
        return $res['total'] ?? 0;
    }
}
