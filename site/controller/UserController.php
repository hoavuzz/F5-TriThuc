<?php

require_once "../site/model/UserModel.php";

$act = $_GET['act'] ?? 'loginStudent';
$UserModel = new UserModel();

switch ($act) {

    // ==== LOGIN STUDENT ====
    case 'loginStudent':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $UserModel->getUserByEmail($email);

            if ($user && $user['role'] === 'student') {
                if ($password === $user['password']) { // so sánh mật khẩu thường
                    $_SESSION['user'] = [
                        'user_id'  => $user['user_id'],
                        'username' => $user['username'],
                        'email'    => $user['email'],
                        'role'     => $user['role']
                    ];
                    header("Location: index.php");
                    exit;
                } else {
                    $errorLogin = "Mật khẩu không đúng!";
                }
            } else {
                $errorLogin = "Tài khoản sinh viên không tồn tại!";
            }
            include "../site/view/login_student.php";
        } else {
            include "../site/view/login_student.php";
        }
        break;

    // ==== LOGIN TEACHER ====
    case 'loginTeacher':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $UserModel->getUserByEmail($email);

            if ($user && $user['role'] === 'teacher') {
                if ($password === $user['password']) { // so sánh mật khẩu thường
                    if ($user['status'] == 0) {
                        $errorLogin = "Tài khoản giảng viên của bạn đang chờ admin duyệt!";
                        include "../site/view/login_teacher.php";
                        exit;
                    }
                    $_SESSION['user'] = [
                        'user_id'  => $user['user_id'],
                        'username' => $user['username'],
                        'email'    => $user['email'],
                        'role'     => $user['role']
                    ];
                    header("Location: index.php");
                    exit;
                } else {
                    $errorLogin = "Mật khẩu không đúng!";
                }
            } else {
                $errorLogin = "Tài khoản giảng viên không tồn tại!";
            }
            include "../site/view/login_teacher.php";
        } else {
            include "../site/view/login_teacher.php";
        }
        break;

    // ==== REGISTER STUDENT ====
    case 'registerStudent':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email    = $_POST['email'] ?? '';
            $phone    = $_POST['phone'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm_password'] ?? '';

            if ($password !== $confirm) {
                $error = "Mật khẩu không khớp!";
                include "../site/view/register_student.php";
            } else {
                $data = [
                    'username'     => $username,
                    'email'        => $email,
                    'phone'        => $phone,
                    'password'     => $password, // lưu mật khẩu thường
                    'role'         => 'student',
                    'status'       => 1,
                    'teacher_file' => null
                ];
                $result = $UserModel->addUser($data);
                if ($result) {
                    header("Location: index.php?mod=user&act=loginStudent");
                    exit;
                } else {
                    $error = "Đăng ký thất bại. Email có thể đã tồn tại!";
                    include "../site/view/register_student.php";
                }
            }
        } else {
            include "../site/view/register_student.php";
        }
        break;

    // ==== REGISTER TEACHER ====
    case 'registerTeacher':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email    = $_POST['email'] ?? '';
            $phone    = $_POST['phone'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm_password'] ?? '';

            if ($password !== $confirm) {
                $error = "Mật khẩu không khớp!";
                include "../site/view/register_teacher.php";
                break;
            }

            if (!isset($_FILES['teacher_file']) || $_FILES['teacher_file']['error'] !== UPLOAD_ERR_OK) {
                $error = "Vui lòng tải lên file chứng minh!";
                include "../site/view/register_teacher.php";
                break;
            }

            $file = $_FILES['teacher_file'];
            $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                $error = "File không hợp lệ! Chỉ chấp nhận JPG, PNG, PDF.";
                include "../site/view/register_teacher.php";
                break;
            }

            if ($file['size'] > 2 * 1024 * 1024) {
                $error = "File quá lớn! Tối đa 2MB.";
                include "../site/view/register_teacher.php";
                break;
            }

            $uploadDir = __DIR__ . "/../uploads/teachers/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $newFileName = uniqid("teacher_", true) . "." . $ext;
            $uploadPath  = $uploadDir . $newFileName;

            if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $error = "Không thể lưu file upload!";
                include "../site/view/register_teacher.php";
                break;
            }

            $data = [
                'username'     => $username,
                'email'        => $email,
                'phone'        => $phone,
                'password'     => $password, // lưu mật khẩu thường
                'role'         => 'teacher',
                'status'       => 0,
                'teacher_file' => $newFileName
            ];

            $result = $UserModel->addUser($data);

            if ($result) {
                header("Location: index.php?mod=user&act=loginTeacher");
                exit;
            } else {
                $error = "Đăng ký thất bại. Email có thể đã tồn tại!";
                include "../site/view/register_teacher.php";
            }
        } else {
            include "../site/view/register_teacher.php";
        }
        break;

    // ==== LOGOUT ====
    case 'logout':
        session_destroy();
        header("Location: index.php");
        break;
    // ==== PROFILE USER ====
    case 'profile':
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?mod=user&act=loginStudent");
            exit;
        }

        $user_id = $_SESSION['user']['user_id'];
        $user = $UserModel->getUserById($user_id);

        // Nếu submit form update
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? $user['username'];
            $email    = $_POST['email'] ?? $user['email'];
            $phone    = $_POST['phone'] ?? $user['phone'];

            $data = [
                'username' => trim($username),
                'email'    => trim($email),
                'phone'    => trim($phone)
            ];

            $updated = $UserModel->updateUser($user_id, $data);

            if ($updated) {
                // Cập nhật lại session
                $_SESSION['user']['username'] = $data['username'];
                $_SESSION['user']['email']    = $data['email'];
                $success = "Cập nhật thông tin thành công!";
                $user = $UserModel->getUserById($user_id); // load lại dữ liệu
            } else {
                $error = "Không thể cập nhật thông tin!";
            }
        }

        // Lấy danh sách khóa học đã mua
        $courses = $UserModel->getPurchasedCourses($user_id);

        include "../site/view/profile_student.php";
        break;

    default:
        echo "Không tìm thấy chức năng phù hợp!";
        break;
}
