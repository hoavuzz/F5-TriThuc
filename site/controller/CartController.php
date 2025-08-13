<?php
class CartController {
    private $db;
    private $conn;
    private $cartModel;

    public function __construct() {
        require_once(__DIR__ . '/../model/database.php');
        $this->db = Database::getInstance();
        require_once(__DIR__ . '/../model/CartModel.php');
        $this->cartModel = new CartModel();
        $this->conn = $this->db->getConn();
        // session_start();
    }

    public function showCart() {
        $user_id = isset($_SESSION['user']['user_id']) ? intval($_SESSION['user']['user_id']) : 0;

        if ($user_id === 0) {
            header("Location: index.php?mod=auth&act=login");
            exit;
        }

        $cart_id = $this->cartModel->getOrCreateCartId($user_id);

        // Lấy danh sách khóa học trong cart
        $stmtItems = $this->conn->prepare("
            SELECT c.*, ci.cart_item_id
            FROM cart_items ci
            JOIN courses c ON ci.course_id = c.course_id
            WHERE ci.cart_id = ?
        ");
        $stmtItems->execute([$cart_id]);
        $cart_items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

        include(__DIR__ . '/../view/course/cart.php');
    }

    public function addToCart() {
        $user_id = isset($_SESSION['user']['user_id']) ? intval($_SESSION['user']['user_id']) : 0;
        if ($user_id === 0) {
            header("Location: index.php?mod=auth&act=login");
            exit;
        }

        // Lấy course_id từ GET (do dùng thẻ <a>)
        $course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
        if ($course_id <= 0) {
            die("ID khóa học không hợp lệ.");
        }

        // Lấy hoặc tạo cart
        $stmt = $this->conn->prepare("SELECT cart_id FROM carts WHERE user_id = ? AND status = 'active' LIMIT 1");
        $stmt->execute([$user_id]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cart_id = $row['cart_id'];
        } else {
            $stmtInsert = $this->conn->prepare("INSERT INTO carts (user_id, status) VALUES (?, 'active')");
            $stmtInsert->execute([$user_id]);
            $cart_id = $this->conn->lastInsertId();
        }

        // Kiểm tra xem khóa học đã có trong giỏ chưa
        $checkStmt = $this->conn->prepare("SELECT * FROM cart_items WHERE cart_id = ? AND course_id = ?");
        $checkStmt->execute([$cart_id, $course_id]);
        if ($checkStmt->rowCount() > 0) {
            header("Location: index.php?mod=cart&act=show");
            exit;
        }

        // Lấy giá khóa học
        $stmtCourse = $this->conn->prepare("SELECT price FROM courses WHERE course_id = ?");
        $stmtCourse->execute([$course_id]);
        $course = $stmtCourse->fetch(PDO::FETCH_ASSOC);
        $price = $course['price'];

        // Thêm vào bảng cart_items với giá
        $insertStmt = $this->conn->prepare("INSERT INTO cart_items (cart_id, course_id, price) VALUES (?, ?, ?)");
        $insertStmt->execute([$cart_id, $course_id, $price]);

        // Chuyển về trang giỏ hàng
        header("Location: index.php?mod=cart&act=show");
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("Lỗi: Không có ID để xóa.");
        }

        $this->cartModel->delete($id);
        header('Location: index.php?mod=cart');
        exit;
    }
}
