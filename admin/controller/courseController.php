<?php
require_once "conf.php";
require_once "../admin/model/CourseModel.php";
$CourseModel = new CourseModel($pdo);

$act = $_GET['act'] ?? 'list';

switch ($act) {
    case 'list':
        $courses = $CourseModel->getAllCourses();
        include "../admin/view/list.php";
        break;

    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Upload ảnh
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $image = uniqid("course_") . "." . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/../../uploads/courses/" . $image);
            }

            $data = [
                'teacher_id'  => $_POST['teacher_id'],
                'category_id' => $_POST['category_id'],
                'name'        => $_POST['name'],
                'price'       => $_POST['price'],
                'image'       => $image,
                'description' => $_POST['description'],
                'language'    => $_POST['language']
            ];
            $CourseModel->addCourse($data);
            header("Location: index.php?mod=course&act=list");
            exit;
        }
        include "../view/course/add.php";
        break;

    case 'edit':
        $id = $_GET['id'] ?? 0;
        $course = $CourseModel->getCourseById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý upload ảnh (nếu có)
            $image = $course['image'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $image = uniqid("course_") . "." . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/../../uploads/courses/" . $image);
            }

            $data = [
                'teacher_id'  => $_POST['teacher_id'],
                'category_id' => $_POST['category_id'],
                'name'        => $_POST['name'],
                'price'       => $_POST['price'],
                'image'       => $image,
                'description' => $_POST['description'],
                'language'    => $_POST['language']
            ];
            $CourseModel->updateCourse($id, $data);
            header("Location: index.php?mod=course&act=list");
            exit;
        }

        include "../view/course/edit.php";
        break;

    case 'delete':
        $id = $_GET['id'] ?? 0;
        $CourseModel->deleteCourse($id);
        header("Location: index.php?mod=course&act=list");
        break;

    default:
        echo "Không tìm thấy chức năng!";
        break;
}
