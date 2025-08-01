<?php
//quản lí home, abuot...
$act = isset($_GET['act']) ? $_GET['act'] : 'home';
switch ($act) {
    case 'home':
        include 'view/home.php';
        break;

         default:
        # code...
        break;
}
