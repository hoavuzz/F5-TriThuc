<?php
//quản lí home, abuot...
$act = isset($_GET['act']) ? $_GET['act'] : 'home';
switch ($act) {
    case 'home':
        include_once "../site/view/home.php";
        break;
    case 'about':
        //xử lí dữ liệu

        //hiển thị ra view
        include_once "../site/views/page.about.php";
        break;

    case 'contact':
        //xử lí dữ liệu

        //hiển thị ra view
        include_once "../site/views/page.contact.php";
        break;
        
         case 'contact':
        //xử lí dữ liệu

        //hiển thị ra view
        include_once "../site/views/page.contact.php";
        break;
    case 'search':
        //xử lí dữ liệu
        // $keyword = $_GET['keyword'];
        // $ProductModel =new ();
        // $productlist =$ProductModel ->search($keyword);
        //hiển thị ra view
        include_once "../site/views/product.search.php";
        break;

    default:
        # code...
        break;
}
