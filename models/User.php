<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT id_user, nama_lengkap, username, role, created_at FROM users WHERE id_user = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getAll($role = null, $search = null) {
        $sql = "SELECT id_user, nama_lengkap, username, role, created_at FROM users WHERE 1=1";
        $params = [];

        if (!empty($role)) {
            $sql .= " AND role = ?";
            $params[] = $role;
        }

        if (!empty($search)) {
            $sql .= " AND (nama_lengkap LIKE ? OR username LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        $sql .= " ORDER BY id_user DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO users (nama_lengkap, username, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['nama_lengkap'],
            $data['username'],
            $data['password'],
            $data['role']
        ]);
    }

    public function update($id, $data) {
        if (!empty($data['password'])) {
            $stmt = $this->db->prepare("UPDATE users SET nama_lengkap = ?, username = ?, password = ?, role = ? WHERE id_user = ?");
            return $stmt->execute([
                $data['nama_lengkap'],
                $data['username'],
                $data['password'],
                $data['role'],
                $id
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE users SET nama_lengkap = ?, username = ?, role = ? WHERE id_user = ?");
            return $stmt->execute([
                $data['nama_lengkap'],
                $data['username'],
                $data['role'],
                $id
            ]);
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id_user = ?");
        return $stmt->execute([$id]);
    }

    public function countByRole($role) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM users WHERE role = ?");
        $stmt->execute([$role]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    public function countAll() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM users");
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    public function countAdmin() {
        return $this->countByRole('admin');
    }
}
