<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=du_an_1;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Kết nối DB thất bại: " . $e->getMessage());
}
