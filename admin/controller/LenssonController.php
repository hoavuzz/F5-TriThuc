<?php
require_once "conf.php";
require_once "../admin/model/LessonModel.php";
$LessonModel = new LessonModel($pdo);

$act = $_GET['act'] ?? 'list';

switch ($act) {
    case 'list':
        $lessons = $LessonModel->getAllLessons();
        include "../admin/view/course/lesson-list.php";
        break;

    case 'add':
    // Lấy danh sách khóa học để chọn
    $courses = $pdo->query("SELECT course_id, name FROM courses")->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'course_id' => $_POST['course_id'],
            'title'     => $_POST['title'],
            'status'    => $_POST['status'] ?? 1
        ];
        $LessonModel->addLesson($data);
        header("Location: index.php?mod=lesson&act=list");
        exit;
    }
    include "../admin/view/course/lesson-add.php";
    break;

case 'edit':
    $id = $_GET['id'] ?? 0;
    $lesson = $LessonModel->getLessonById($id);
    if (!$lesson) {
        die("Bài học không tồn tại!");
    }

    // Lấy danh sách khóa học
    $courses = $pdo->query("SELECT course_id, name FROM courses")->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'course_id' => $_POST['course_id'],
            'title'     => $_POST['title'],
            'status'    => $_POST['status'] ?? 1
        ];
        $LessonModel->updateLesson($id, $data);
        header("Location: index.php?mod=lesson&act=list");
        exit;
    }
    include "../admin/view/course/lesson-edit.php";
    break;

    case 'delete':
        $id = $_GET['id'] ?? 0;
        $LessonModel->deleteLesson($id);
        header("Location: index.php?mod=lesson&act=list");
        break;

    default:
        echo "Không tìm thấy chức năng!";
        break;
}
