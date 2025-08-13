<?php
// Sửa lại thông tin DB cho đúng môi trường của bạn
$db = new mysqli("localhost", "root", "", "du_an_1");
if ($db->connect_error) {
    die("Kết nối thất bại: " . $db->connect_error);
}
$db->set_charset("utf8mb4");
