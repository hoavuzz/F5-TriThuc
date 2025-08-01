<?php
session_start();

$ctrl = isset($_GET['mod']) ? $_GET['mod'] : 'quiz';

require_once("../site/view/header.php");

switch ($ctrl) {
    case 'quiz':
        include_once "../site/controller/Quiz-controller.php";
        // include_once "../site/view/quiz.php";
        break;
    default:
        echo "<p>Không tìm thấy trang yêu cầu.</p>";
        break;
}

require_once("../site/view/footer.php");
