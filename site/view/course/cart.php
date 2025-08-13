<style>
    body {
        background-color: #f7f7f7;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .cart-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        display: flex;
        gap: 40px;
        flex-wrap: wrap;
    }

    .cart-main {
        flex: 2;
        min-width: 0;
    }

    .cart-right {
        flex: 1;
        min-width: 280px;
        padding: 20px;
        background-color: #fefefe;
        border-left: 1px solid #eee;
        border-radius: 8px;
    }

    .cart-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 24px;
        color: #333;
    }

    .cart-item {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .item-image {
        width: 220px;
        height: 130px;
        flex-shrink: 0;
        background-color: #f0f0f0;
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    .item-name {
        flex: 1;
        font-size: 17px;
        font-weight: 500;
        color: #222;
    }

    .item-price {
        width: 120px;
        font-size: 16px;
        font-weight: bold;
        color: #e55b00;
        text-align: right;
    }

    .item-delete a {
        color: #d60000;
        font-size: 14px;
        text-decoration: none;
        margin-left: 10px;
    }

    .item-delete a:hover {
        text-decoration: underline;
    }

    .cart-buttons {
        margin-top: 30px;
    }

    .btn-secondary {
        display: inline-block;
        padding: 10px 20px;
        background: #e0e0e0;
        color: #333;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-secondary:hover {
        background-color: #ccc;
    }

    .btn-pay {
        margin-top: 30px;
        width: 100%;
        padding: 14px;
        background: #ff6600;
        color: #fff;
        font-size: 17px;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-pay:hover {
        background-color: #e55b00;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin: 12px 0;
        font-size: 15px;
        color: #444;
    }

    .summary-row.total {
        font-size: 18px;
        font-weight: bold;
        color: #111;
        border-top: 1px solid #ddd;
        padding-top: 12px;
    }
</style>


<?php
// session_start();
$conn = new mysqli("localhost", "root", "", "du_an_1");
$conn->set_charset("utf8");

// Lấy user_id từ session đăng nhập
$user_id = isset($_SESSION['user']['user_id']) ? intval($_SESSION['user']['user_id']) : 0;

// Nếu chưa đăng nhập thì chuyển hướng về trang đăng nhập
if ($user_id === 0) {
    header("Location: index.php?mod=login_student");
    exit;
}



// Lấy cart_id active của user đăng nhập
$cart_id = 0;
$res = $conn->query("SELECT cart_id FROM carts WHERE user_id = $user_id AND status = 'active' LIMIT 1");
if ($row = $res->fetch_assoc()) {
    $cart_id = $row['cart_id'];
}

// Lấy sản phẩm trong giỏ hàng
$cartItems = [];
if ($cart_id) {
    $sql = $sql = "SELECT ci.cart_item_id, c.name AS name, c.price, c.image, c.course_id
        FROM cart_items ci
        JOIN courses c ON ci.course_id = c.course_id
        WHERE ci.cart_id = $cart_id";

    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }
}
?>


<div class="cart-container">
    <div class="cart-main">
        <h2>Giỏ hàng của bạn</h2>
        <?php if (!empty($cartItems)): ?>
            <div class="cart-title">Khóa học đã chọn (<?php echo count($cartItems); ?> khóa học)</div>
            <?php
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item['price'];
            ?>
                <div class="cart-item" style="display:flex;align-items:center;gap:16px;margin-bottom:8px;">
                    <div class="item-image" style="width:60px;height:60px;background:#eee;display:flex;align-items:center;justify-content:center;">
                        <?php if ($item['image']): ?>
                            <img src="../public/image/<?php echo htmlspecialchars($item['image']); ?>" alt="">
                        <?php else: ?>

                        <?php endif; ?>
                    </div>
                    <div class="item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                    <div class="item-price"><?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ</div>
                    <!-- Nút xóa sản phẩm -->
                    <div class="item-delete">
                        <a href="index.php?mod=cart&act=delete&id=<?= $item['cart_item_id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa khóa học này khỏi giỏ hàng?')">Xóa</a>
                    </div>
                </div>
            <?php } ?>
            <div class="cart-buttons">
                <a href="index.php?mod=home" class="btn-secondary">← Tiếp tục mua sắm</a>
            </div>
        <?php else: ?>
            <p>Giỏ hàng của bạn đang trống.</p>
        <?php endif; ?>
    </div>
    <div class="cart-right">
        <h3>Tóm tắt đơn hàng</h3>
        <div class="summary-row">
            <span>Tạm tính:</span>
            <span><?php echo number_format($subtotal ?? 0, 0, ',', '.'); ?> VNĐ</span>
        </div>
        <div class="summary-row">
            <span>Giảm giá:</span>
            <span class="discount">-0 VNĐ</span>
        </div>
        <div class="summary-row total">
            <span>Tổng cộng:</span>
            <span><?php echo number_format($subtotal ?? 0, 0, ',', '.'); ?> VNĐ</span>
        </div>
        <form action="index.php" method="get">
            <input type="hidden" name="mod" value="checkout">
            <button type="submit" class="btn-pay">Tiến hành thanh toán</button>
        </form>
    </div>
</div>