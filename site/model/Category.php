<?php
require_once __DIR__ . '/../model/Database.php';

class Category {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConn();
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM categories ORDER BY category_id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
