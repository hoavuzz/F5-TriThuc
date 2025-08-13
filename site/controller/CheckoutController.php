<?php
require_once '../site/model/CheckoutModel.php';

$act = $_GET['act'] ?? 'checkout';
$CheckoutModel = new CheckoutModel();

switch ($act){
    case 'checkout':
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?mod=user&act=loginStudent");
            exit;
        }

        $user_id = $_SESSION['user']['user_id'];
        $cart_id = $CheckoutModel->getActiveCartId($user_id);
        $cart_items = $CheckoutModel->getCartItems($cart_id);

        $total_price = 0;
        foreach ($cart_items as $item) {
            $total_price += $item['price'];
        }

        if (empty($cart_items)) {
            echo "Giỏ hàng trống. Không thể thanh toán.";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $payment_method = $_POST['payment_method'];
            $order_id = $CheckoutModel->createOrder($user_id, $payment_method, $total_price);

            foreach ($cart_items as $item) {
                $CheckoutModel->addOrderItem($order_id, $item['course_id'], $item['price']);
            }

            $CheckoutModel->markCartOrdered($cart_id);

           

            // VN{PAY integration}
            if ($_POST['payment_method'] == 'vnpay') {
                require_once("../site/config.php");

                $vnp_TxnRef = rand(1, 10000); //Mã giao dịch thanh toán tham chiếu của merchant
                $vnp_Amount = $total_price ; // Số tiền thanh toán
                $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
                $vnp_BankCode = ''; //Mã phương thức thanh toán
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount * 100,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => "Thanh toan GD: " . $vnp_TxnRef,
                    "vnp_OrderType" => "other",
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef,
                    "vnp_ExpireDate" => $expire
                );

                if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }

                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }
                //echo $vnp_Url;exit;
                header('Location: ' . $vnp_Url);
                exit;
            } else {
                header("Location: index.php?mod=home");
                exit;
            }
            
            //header("Location: index.php?mod=home");
            //exit;
        }

        include '../site/view/course/checkout.php';
        break;

    // Xử lý returnUrl của MoMo (hiển thị kết quả cho user)

        
    default:
        echo "Không tìm thấy chức năng thanh toán phù hợp!";
        break;
}
