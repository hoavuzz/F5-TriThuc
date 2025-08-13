<?php
session_start();
// $_SESSION['cart'] = [];
// echo "đây là trang index nè"
//điều hướng đến các controller;
$ctrl = isset($_GET['mod']) ? ($_GET['mod']) : 'page';
require_once("../site/view/header.php");
switch ($ctrl) {
    case 'page':
        include_once "../site/controller/PageController.php";

        break;
    case 'user':

        include_once "../site/controller/UserController.php";
        break;
    case 'checkout':
        require_once('controller/CheckoutController.php');
        // $controller = new CheckoutController();
        // $controller->checkout();
        break;
    case 'cart':
        require_once("controller/CartController.php");
        $controller = new CartController();
        $act = $_GET['act'] ?? 'show';

        switch ($act) {
            case 'show':
                $controller->showCart();
                break;

            case 'add':
                $controller->addToCart(); // <--- Thêm dòng này
                break;
            case 'delete':
                $controller->delete();
                break;
            default:
                echo "404 - Không tìm thấy hành động trong giỏ hàng!";
                break;
        }
        break;
    case 'course':
        include_once "../site/controller/CourseController.php";
        break;
    case 'quiz':
        include_once "../site/controller/Quiz-controller.php";
        // include_once "../site/view/quiz.php";
        break;
    default:

        break;
}
include_once("../site/view/footer.php");
