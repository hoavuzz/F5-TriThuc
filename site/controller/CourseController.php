<?php
require_once __DIR__ . '/../model/Course.php';
require_once __DIR__ . '/../model/Lesson.php';
require_once __DIR__ . '/../model/Category.php';
$lessonModel = new Lesson();
$courseModel = new Course();
$categoryModel = new Category();
$categories = $categoryModel->getAllCategories();

$act = isset($_GET['act']) ? $_GET['act'] : 'list';

switch ($act) {
    case 'list':
        $courses = $courseModel->getAllCourses();
        require __DIR__ . '/../view/course_list.php';
        break;

    case 'filter':
        $category_id = $_GET['category_id'] ?? null;
        $price = $_GET['price'] ?? null;
        $levels = $_GET['level'] ?? [];
        $durations = $_GET['duration'] ?? [];

        $courses = $courseModel->filterCourses($category_id, $price, $levels, $durations);
        require __DIR__ . '/../view/course_list.php';
        break;
    case 'detail':
        $id = intval($_GET['id']);
        $course = $courseModel->getCourseById($id);

        if ($course) {
            // Lấy danh sách bài học
            require_once __DIR__ . '/../model/Lesson.php';
            $lessonModel = new Lesson();
            $lessons = $lessonModel->getLessonsByCourse($id);

            require_once __DIR__ . '/../view/course_detail.php';
        } else {
            echo "<p>Khóa học không tồn tại</p>";
        }
        break;


    case 'lesson':
        if (!empty($_GET['id'])) {
            $lesson_id = intval($_GET['id']);

            // Lấy bài học hiện tại
            $lesson = $lessonModel->getLessonById($lesson_id);

            if ($lesson) {
                // Lấy thông tin khóa học chứa bài này
                $course = $courseModel->getCourseById($lesson['course_id']);

                // Lấy danh sách bài học để làm sidebar
                $lessons = $lessonModel->getLessonsByCourse($lesson['course_id']);

                require __DIR__ . '/../site/view/lesson_view.php';
            } else {
                echo "<p>Bài học không tồn tại</p>";
            }
        } else {
            echo "<p>Không có ID bài học</p>";
        }
        break;
    case 'viewLesson':
        if (!empty($_GET['id'])) {
            $lesson_id = intval($_GET['id']);

            // Lấy bài học hiện tại
            $lesson = $lessonModel->getLessonById($lesson_id);

            if ($lesson) {
                // Lấy thông tin khóa học chứa bài này
                $course = $courseModel->getCourseById($lesson['course_id']);

                // Lấy danh sách section + bài học
                // (nếu bạn có model Section thì dùng, còn không thì thay bằng getLessonsByCourse)
                $sections = []; // tạm để tránh lỗi
                $lessons = $lessonModel->getLessonsByCourse($lesson['course_id']);

                require __DIR__ . '/../view/lesson_view.php';
            } else {
                echo "<p>Bài học không tồn tại</p>";
            }
        } else {
            echo "<p>Không có ID bài học</p>";
        }
        break;
    case 'profile':
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?mod=user&act=loginStudent");
            exit;
        }

        $user_id = $_SESSION['user']['user_id'];
        $user = $UserModel->getUserById($user_id);
        $courses = $UserModel->getPurchasedCourses($user_id); // lấy qua order + order_items

        if ($user) {
            include "../site/view/profile.php";
        } else {
            echo "Không tìm thấy thông tin tài khoản!";
        }
        break;
}
