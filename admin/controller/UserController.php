<?php
require_once "conf.php";               
require_once "../admin/model/UserModel.php";   

$UserModel = new UserModel($pdo);              

$act = isset($_GET['act']) ? $_GET['act'] : 'list';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $teacher_file = $_POST['old_teacher_file'] ?? ''; // file cũ

    // Nếu có upload file mới
    if (!empty($_FILES['teacher_file']['name'])) {
        $uploadDir = "../uploads/";
        $fileName = time() . "_" . basename($_FILES['teacher_file']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['teacher_file']['tmp_name'], $targetPath)) {
            $teacher_file = $fileName;
        }
    }

    $data = [
        'email'        => $_POST['email'] ?? '',
        'phone'        => $_POST['phone'] ?? '',
        'username'     => $_POST['username'] ?? '',
        'role'         => $_POST['role'] ?? 'student',
        'status'       => $_POST['status'] ?? 1,
        'teacher_file' => $teacher_file,
        'user_id'      => $_POST['user_id'] ?? 0,
    ];

    $UserModel->updateUser($data);
    header("Location: index.php?mod=user&act=list");
    exit;
}

switch ($act) {
    case 'list':
        $users = $UserModel->getAllUsers(); 
        include "../admin/view/user_admin.php"; 
        break;

    case 'delete':
        if (!isset($_GET['id'])) die("Thiếu ID để xóa!");
        $UserModel->deleteUserById($_GET['id']);
        header("Location: index.php?mod=user&act=list");
        break;

    default:
        echo "Không tìm thấy chức năng!";
        break;
}
