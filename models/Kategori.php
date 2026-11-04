<?php
require_once __DIR__ . '/../config/database.php';

class Kategori {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll($search = null) {
        $sql = "SELECT k.*, (SELECT COUNT(*) FROM alat a WHERE a.id_kategori = k.id_kategori) as jumlah_alat FROM kategori k WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $sql .= " AND (k.nama_kategori LIKE ? OR k.deskripsi LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        $sql .= " ORDER BY k.id_kategori DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO kategori (nama_kategori, deskripsi) VALUES (?, ?)");
        return $stmt->execute([$data['nama_kategori'], $data['deskripsi']]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE kategori SET nama_kategori = ?, deskripsi = ? WHERE id_kategori = ?");
        return $stmt->execute([$data['nama_kategori'], $data['deskripsi'], $id]);
    }

    public function delete($id) {
        // Cek relasi dengan alat
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM alat WHERE id_kategori = ?");
        $stmt->execute([$id]);
        $res = $stmt->fetch();
        if ($res['total'] > 0) {
            return false; // Masih digunakan
        }

        $stmt = $this->db->prepare("DELETE FROM kategori WHERE id_kategori = ?");
        return $stmt->execute([$id]);
    }

    public function countAll() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM kategori");
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
}
