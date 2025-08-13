<?php
    require_once('database.php');
    class CheckoutModel
    {
        private $conn;

        public function __construct()
        {
            $this->conn = Database::getInstance()->getConn();
        }

     //lấy cart_id của giỏ hàng đang active
        public function getActiveCartId($user_id){
            $stmt=$this->conn->prepare("
                SELECT cart_id 
                FROM carts
                WHERE user_id = ? AND status = 'active'
                LIMIT 1
            ");
            $stmt->execute([$user_id]);
            $row =$stmt->fetch(PDO::FETCH_ASSOC);
        // Trả về cart_id nếu có, ngược lại trả null
        return $row ? $row['cart_id']:null;
    }
        //lấy danh sách khóa học trong giỏ hàng theo cart_id
        public function getCartItems($cart_id){
            $stmt=$this->conn->prepare("
                SELECT ci.course_id, ci.price, c.name, c.image
                FROM cart_items ci
                JOIN courses c ON ci.course_id=c.course_id
                WHERE ci.cart_id = ?");
                $stmt->execute([$cart_id]);
                // Trả về tất cả sản phẩm trong giỏ hàng (mỗi sản phẩm là một dòng mảng)
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        //tạo đơn hàng mới trong bảng order
        public function createOrder($user_id, $payment_method, $total_price){
            $sql = "INSERT INTO orders (user_id, total_price, payment_method, status, created_at)
            VALUES(?, ?, ?, 'pending', NOW())";
            
             // Tạo mảng tham số đúng thứ tự với câu lệnh SQL
            $params = [$user_id, $total_price, $payment_method];
             // Chuẩn bị và thực thi truy vấn
             $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    // Trả về ID đơn hàng vừa được tạo (tự tăng)
    return $this->conn->lastInsertId();
        }
        //Thêm sản phẩm vào bảng order_items
        public function addOrderItem($order_id, $course_id,$price){
            $sql = "INSERT INTO order_items(order_id, course_id, price)
            VALUES(?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $params =[$order_id, $course_id, $price];
            $stmt->execute($params);
        }
        //cập nhật trạng thái giỏ hàng thành đã đặt
        public function markCartOrdered($cart_id) {
    $stmt = $this->conn->prepare("
        UPDATE carts 
        SET status = 'ordered' 
        WHERE cart_id = ?
    ");
    $stmt->execute([$cart_id]);
    
    
}

    }
?>