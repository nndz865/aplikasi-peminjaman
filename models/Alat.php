<?php
require_once __DIR__ . '/../config/database.php';

class Alat {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll($kategori_id = null, $search = null, $available_only = false) {
        $sql = "SELECT a.*, k.nama_kategori FROM alat a JOIN kategori k ON a.id_kategori = k.id_kategori WHERE 1=1";
        $params = [];

        if (!empty($kategori_id)) {
            $sql .= " AND a.id_kategori = ?";
            $params[] = $kategori_id;
        }

        if (!empty($search)) {
            $sql .= " AND (a.nama_alat LIKE ? OR a.deskripsi LIKE ? OR a.lokasi LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        if ($available_only) {
            $sql .= " AND a.stok > 0";
        }

        $sql .= " ORDER BY a.id_alat DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT a.*, k.nama_kategori FROM alat a JOIN kategori k ON a.id_kategori = k.id_kategori WHERE a.id_alat = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO alat (id_kategori, nama_alat, deskripsi, stok, kondisi, lokasi, gambar) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['id_kategori'],
            $data['nama_alat'],
            $data['deskripsi'],
            $data['stok'],
            $data['kondisi'],
            $data['lokasi'],
            $data['gambar'] ?? null
        ]);
    }

    public function update($id, $data) {
        $fields = "id_kategori = ?, nama_alat = ?, deskripsi = ?, stok = ?, kondisi = ?, lokasi = ?";
        $params = [$data['id_kategori'], $data['nama_alat'], $data['deskripsi'], $data['stok'], $data['kondisi'], $data['lokasi']];
        if (array_key_exists('gambar', $data)) { $fields .= ", gambar = ?"; $params[] = $data['gambar']; }
        $params[] = $id;
        $stmt = $this->db->prepare("UPDATE alat SET $fields WHERE id_alat = ?");
        return $stmt->execute($params);
    }

    public function delete($id) {
        // Cek relasi peminjaman
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM peminjaman WHERE id_alat = ?");
        $stmt->execute([$id]);
        $res = $stmt->fetch();
        if ($res['total'] > 0) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM alat WHERE id_alat = ?");
        return $stmt->execute([$id]);
    }

    public function countAll() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM alat");
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    public function sumStok() {
        $stmt = $this->db->query("SELECT SUM(stok) as total FROM alat");
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    public function getLowStock($threshold = 2) {
        $stmt = $this->db->prepare("SELECT id_alat, nama_alat, stok, kondisi FROM alat WHERE stok <= ? ORDER BY stok ASC, nama_alat ASC");
        $stmt->execute([(int)$threshold]);
        return $stmt->fetchAll();
    }

    public function getByCategoryStats() {
        $stmt = $this->db->query("SELECT k.nama_kategori, COUNT(a.id_alat) as total_alat, SUM(a.stok) as total_stok FROM kategori k LEFT JOIN alat a ON k.id_kategori = a.id_kategori GROUP BY k.id_kategori");
        return $stmt->fetchAll();
    }
}
