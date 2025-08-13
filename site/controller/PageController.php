<?php
$act = isset($_GET['act']) ? $_GET['act'] : 'home';

switch ($act) {
    case 'home':
        include_once "../site/model/Course.php";
        require_once("model/Category.php");
        $courseModel = new Course();
        $categoryModel = new Category();
        $courses = $courseModel->getAllCourses(); // hoặc khóa học nổi bật
        $freeCourses = $courseModel->getFreeCourses(6);
        $mostViewedCourses = $courseModel->getMostViewedCourses(6);
        include_once "../site/view/home.php";
        break;
    case 'detail':
        if (isset($_GET['id'])) {
            $course = $courseModel->getCourseById($_GET['id']);
            include_once "../site/view/course/course_detail.php";
        } else {
            echo "Không tìm thấy ID khóa học!";
        }

        break;
    case 'category':
        require_once("model/Category.php");
        if (isset($_GET['id'])) {
            $category_id = $_GET['id'];
            $courses = $courseModel->getByCategory($category_id);
            require_once("view/course/course_list.php");
        } else {
            echo "Không tìm thấy danh mục.";
        }
        break;
    case 'quiz':
        include_once "../site/view/Quiz-controller.php";
        break;

    default:
        echo "404 - Trang không tồn tại";
        break;
}
