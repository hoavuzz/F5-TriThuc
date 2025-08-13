<?php
session_start();

// // Kiểm tra quyền đăng nhập admin
// if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
//     header("Location: ../site/index.php?mod=user&act=loginStudent");
//     exit;
// }

// Điều hướng đến các controller trong admin
$ctrl = isset($_GET['mod']) ? $_GET['mod'] : 'page';

require_once("view/header.php");

switch ($ctrl) {
    case 'page':
        require_once 'config.php';
        require_once 'controller/PageController.php';

        $controller = new DashboardController($db);
        $controller->index();
        break;
    case 'user':
        include_once "controller/UserController.php";
        break;

    case 'product':
        include_once "controller/ProductController.php";
        break;

    case 'order':
        include_once "controller/OrderController.php";
        break;

    case 'lesson':
        include_once "controller/LenssonController.php";
        break;

    case 'course':
        include_once "controller/courseController.php";
        break;
    case 'category':
        include_once "controller/categoryController.php";
        break;


    default:
        echo "<h2>Module không tồn tại!</h2>";
        break;
}

// require_once("view/admin_footer.php");
