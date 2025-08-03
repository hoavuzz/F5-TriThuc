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
    case 'approveTeacher':
        $user_id = $_GET['user_id'] ?? 0;

        if ($user_id) {
            // 1. Cập nhật status = 1 (đã duyệt)
            $UserModel->updateStatus($user_id, 1);

            // 2. Kiểm tra xem đã có trong bảng teachers chưa
            $sql = "SELECT * FROM teachers WHERE user_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id]);
            $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$teacher) {
                // 3. Nếu chưa thì thêm mới
                $UserModel->addTeacher($user_id);
            }

            // Quay về danh sách giáo viên chờ duyệt
            header("Location: index.php?mod=user&act=listTeachers");
            exit;
        } else {
            echo "Thiếu user_id!";
        }
        break;



    default:
        echo "Không tìm thấy chức năng!";
        break;
}
