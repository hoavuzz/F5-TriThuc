<?php
session_start();
// $_SESSION['cart'] = [];
// echo "đây là trang index nè"
//điều hướng đến các controller;
$ctrl = isset($_GET['mod']) ? ($_GET['mod']) : 'page';
require_once("../site/views/header.php");
switch ($ctrl) {
    case 'page':
        include_once "../site/controllers/PageController.php";

        break;
    case 'user':

        include_once "../site/controllers/UserController.php";
        break;
    case 'product':
        include_once "../site/controllers/ProductController.php";
        break;
    case 'cart';
        include_once "../site/controllers/cartcontroller.php";
        break;
    default:

        break;

}
include_once("../site/views/footer.php");