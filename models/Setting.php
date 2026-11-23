<?php
require_once __DIR__ . '/../config/database.php';

class Setting {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getSettings() {
        $stmt = $this->db->query("SELECT * FROM settings WHERE id = 1");
        return $stmt->fetch();
    }

    public function updateSettings($lab_name, $denda, $max_hari) {
        $stmt = $this->db->prepare("UPDATE settings SET lab_name = ?, denda_per_hari = ?, max_hari_pinjam = ? WHERE id = 1");
        return $stmt->execute([$lab_name, $denda, $max_hari]);
    }
}
