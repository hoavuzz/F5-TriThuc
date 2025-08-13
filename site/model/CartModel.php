<?php
require_once('database.php');

class CartModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConn();
    }

    public function delete($id) {
        $sql = "DELETE FROM cart_items WHERE cart_item_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function getOrCreateCartId($user_id) {
        $stmt = $this->conn->prepare("SELECT cart_id FROM carts WHERE user_id = ? AND status = 'active' LIMIT 1");
        $stmt->execute([$user_id]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['cart_id'];
        } else {
            $stmtInsert = $this->conn->prepare("INSERT INTO carts (user_id, status) VALUES (?, 'active')");
            $stmtInsert->execute([$user_id]);
            return $this->conn->lastInsertId();
        }
    }
}
