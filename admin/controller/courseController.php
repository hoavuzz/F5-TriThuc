<?php
require_once "conf.php";
require_once "../admin/model/CourseModel.php";
$CourseModel = new CourseModel($pdo);

$act = $_GET['act'] ?? 'list';

switch ($act) {
    case 'list':

        $courses = $CourseModel->getAllCourses();
        include "../admin/view/course/course-list.php";
        break;

    case 'add':
       
        // $categories = $categoryModel->getCategoryNameById($category_id);
        $categories = $pdo->query("SELECT category_id, name FROM categories")->fetchAll(PDO::FETCH_ASSOC);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imageName = '';
            if (!empty($_FILES['image']['name'])) {
                $imageName = time() . "_" . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/courses/" . $imageName);
            }

            $data = [
                'teacher_id'  => $_POST['teacher_id'],
                'category_id' => $_POST['category_id'],
                'name'        => $_POST['name'],
                'price'       => $_POST['price'],
                'image'       => $imageName,
                'description' => $_POST['description'],
                'views'       => $_POST['views'] ?? 0,
                'language'    => $_POST['language']
            ];
            $CourseModel->addCourse($data);
            header("Location: index.php?mod=course&act=list");
            exit;
        }
        include "../admin/view/course/course-add.php";
        break;

    case 'edit':
        $id = $_GET['id'] ?? 0;
        $course = $CourseModel->getCourseById($id);
        if (!$course) {
            die("Khóa học không tồn tại!");
        }

        // $teachers = $pdo->query("SELECT teacher_id, name FROM teachers")->fetchAll(PDO::FETCH_ASSOC);
        $categories = $pdo->query("SELECT category_id, name FROM categories")->fetchAll(PDO::FETCH_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imageName = $course['image'];
            if (!empty($_FILES['image']['name'])) {
                $imageName = time() . "_" . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/courses/" . $imageName);
            }

            $data = [
                'teacher_id'  => $_POST['teacher_id'],
                'category_id' => $_POST['category_id'],
                'name'        => $_POST['name'],
                'price'       => $_POST['price'],
                'image'       => $imageName,
                'description' => $_POST['description'],
                'views'       => $_POST['views'],
                'language'    => $_POST['language']
            ];
            $CourseModel->updateCourse($id, $data);
            header("Location: index.php?mod=course&act=list");
            exit;
        }
        include "../admin/view/course/course-edit.php";
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
