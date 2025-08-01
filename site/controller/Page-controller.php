<?php
// Điều hướng trang
$page = $_GET['page'] ?? 'home';

    switch ($page) {
        case 'quiz':
            include_once "../site/view/Quiz-controller.php";
            break;
        case 'home':
            include_once "../site/view/home.php";
            break;
        default:
            echo "<p>Không tìm thấy trang yêu cầu.</p>";
            break;
    }

