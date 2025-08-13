<?php if (empty($cart_items)) : ?>
    <div style="text-align:center; margin:50px auto; font-size:20px; color:#c00;">
        🛒 Giỏ hàng trống. Không thể thanh toán.
    </div>
    <?php exit; ?>
<?php endif; ?>

<style>
.checkout-container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 30px;
    border: 1px solid #ddd;
    border-radius: 12px;
    background-color: #fff;
    display: flex;
    gap: 40px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.checkout-left {
    flex: 2;
}
.checkout-right {
    flex: 1;
    border-left: 1px solid #eee;
    padding-left: 30px;
}
.checkout-left h2,
.checkout-right h2 {
    margin-bottom: 20px;
    color: #333;
    font-size: 22px;
}
.cart-item {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px dashed #ddd;
}
.cart-item .item-image {
    width: 100px;
    height: 70px;
    background-color: #f0f0f0;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
.cart-item .item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.cart-item .item-info {
    flex: 1;
}
.cart-item .item-name {
    font-size: 16px;
    font-weight: 500;
    color: #333;
    margin-bottom: 4px;
}
.cart-item .item-price {
    color: #ff6600;
    font-weight: bold;
}
.cart-total {
    margin-top: 20px;
    font-size: 18px;
    font-weight: bold;
    color: #e55b00;
    border-top: 1px solid #ccc;
    padding-top: 15px;
}
select,
button {
    padding: 12px;
    font-size: 16px;
    margin-top: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    width: 100%;
}
button {
    background-color: #ff6600;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}
button:hover {
    background-color: #e55b00;
}
.checkout-right img.qr-code {
    width: 100%;
    max-width: 250px;
    margin: 20px auto 10px;
    display: block;
    border: 1px solid #ccc;
    padding: 8px;
    border-radius: 10px;
}
.checkout-right ul {
    padding-left: 20px;
    line-height: 1.6;
    color: #333;
}
.checkout-right p {
    color: #444;
    line-height: 1.6;
}
</style>

<div class="checkout-container">
    <div class="checkout-left">
        <h2>Thông tin thanh toán</h2>
        <form method="post">
            <label for="payment_method">Phương thức thanh toán:</label>
            <select name="payment_method" id="payment_method" required>
                <option value="">-- Chọn phương thức --</option>
                <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                <option value="momo">Ví MoMo</option>
                <option value="vnpay">VNPAY</option>
            </select>

            <h2 style="margin-top: 40px;">Giỏ hàng của bạn</h2>
            <?php foreach ($cart_items as $item): ?>
                <div class="cart-item">
                    <div class="item-image">
                        <img src="../public/image/<?= htmlspecialchars($item['image']) ?>" alt="">
                    </div>
                    <div class="item-info">
                        <div class="item-name"><?= htmlspecialchars($item['name']) ?></div>
                        <div class="item-price"><?= number_format($item['price'] ?? 0, 0, ',', '.') ?>đ</div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="cart-total">
                Tổng cộng: <?= number_format($total_price ?? 0, 0, ',', '.') ?>đ
            </div>

            <button type="submit" style="margin-top: 30px;">Xác nhận thanh toán</button>
        </form>
    </div>

    <div class="checkout-right">
        <h2>Hướng dẫn thanh toán</h2>

        <div id="bank_info" style="display: none;">
            <p>💳 Nếu chọn <strong>chuyển khoản ngân hàng</strong>, vui lòng chuyển đến:</p>
            <ul>
                <li><strong>Ngân hàng:</strong> MBBank</li>
                <li><strong>Số tài khoản:</strong> 0123456789</li>
                <li><strong>Chủ tài khoản:</strong> Lữ Thông Thái</li>
                
            </ul>
            <img src="../public/image/nh.jpg" alt="QR chuyển khoản" class="qr-code">
        </div>

        <div id="momo_info" style="display: none;">
            <p>📱 Nếu chọn <strong>MoMo</strong>, vui lòng chuyển khoản đến:</p>
            <ul>
                <li><strong>Số điện thoại:</strong> 0909123456</li>
                <li><strong>Chủ tài khoản:</strong> Lữ Thông Thái</li>
                
            </ul>
            <img src="../public/image/momo.jpg" alt="QR MoMo" class="qr-code">
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const paymentSelect = document.getElementById('payment_method');
    const bankInfo = document.getElementById('bank_info');
    const momoInfo = document.getElementById('momo_info');

    function toggleInstructions() {
        const method = paymentSelect.value;
        bankInfo.style.display = method === 'bank_transfer' ? 'block' : 'none';
        momoInfo.style.display = method === 'momo' ? 'block' : 'none';
    }

    paymentSelect.addEventListener('change', toggleInstructions);
    toggleInstructions(); // để load mặc định nếu đã chọn
});
</script>
