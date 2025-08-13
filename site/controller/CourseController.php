<?php
require_once __DIR__ . '/../model/Course.php';
require_once __DIR__ . '/../model/Lesson.php';
require_once __DIR__ . '/../model/Category.php';
require_once __DIR__ . '/../model/ContentModel.php';
require_once "../site/controller/QuizController.php";
$quizController = new QuizzController();
$lessonModel = new Lesson();
$courseModel = new Course();
$categoryModel = new Category();
$contentModel = new ContentModel();
$categories = $categoryModel->getAllCategories();

$act = isset($_GET['act']) ? $_GET['act'] : 'list';

switch ($act) {
    case 'list':
        $courses = $courseModel->getAllCourses();
        require __DIR__ . '/../view/course/course_list.php';
        break;

    case 'filter':
        $category_id = $_GET['category_id'] ?? null;
        $price = $_GET['price'] ?? null;
        $levels = $_GET['level'] ?? [];
        $durations = $_GET['duration'] ?? [];

        $courses = $courseModel->filterCourses($category_id, $price, $levels, $durations);
        require __DIR__ . '/../view/course/course_list.php';
        break;
   case 'detail':
        $course_id = $_GET['id'] ?? null;
        if (!$course_id) {
            header('Location: index.php?mod=course');
            exit;
        }

        $course = $courseModel->getCourseById($course_id);
        $lessons = $lessonModel->getLessonsByCourse($course_id);

        // Lấy toàn bộ nội dung từng bài học trong khóa học
        $contents = [];
        foreach ($lessons as $lesson) {
            $lessonContents = $contentModel->getContentsByLesson($lesson['lesson_id']);
            $contents = array_merge($contents, $lessonContents);
        }

        $lessonCount = count($lessons);
        

        

        require __DIR__ . '/../view/course/course_detail.php';
        break;

 case 'lesson':
        $course_id = $_GET['course_id'] ?? null;
        $lesson_id = $_GET['lesson_id'] ?? null;
        $content_id = $_GET['content_id'] ?? null;

        if (!$course_id || !$lesson_id) {
            header("Location: index.php?mod=course&act=list");
            exit;
        }

        $course = $courseModel->getCourseById($course_id);
        $lesson = $lessonModel->getLessonById($lesson_id);
        $lessons = $lessonModel->getLessonsByCourse($course_id);
        $contents = $contentModel->getContentsByLesson($lesson_id);

        // Lấy tất cả nội dung của khóa học (nội dung thuộc tất cả bài học)
        $allContents = [];
        foreach ($lessons as $l) {
            $lessonContents = $contentModel->getContentsByLesson($l['lesson_id']);
            $allContents = array_merge($allContents, $lessonContents);
        }

        // Lấy content hiện tại theo content_id hoặc lấy content đầu tiên
        $content_id = $_GET['content_id'] ?? null;
        if (!$content_id && !empty($allContents)) {
            $content_id = $allContents[0]['content_id'];
        }

        $currentContent = null;
        foreach ($allContents as $content) {
            if ($content['content_id'] == $content_id) {
                $currentContent = $content;
                break;
            }
        }
        if (!$currentContent && !empty($allContents)) {
            $currentContent = $allContents[0];
        }

        $video_link = $currentContent['video_link'] ?? null;
        
        $lessonCount = count($lessons);
        require __DIR__ . '/../view/course/lesson_detail.php';
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

                require __DIR__ . '/../view/course/lesson_view.php';
            } else {
                echo "<p>Bài học không tồn tại</p>";
            }
        } else {
            echo "<p>Không có ID bài học</p>";
        }
        break;
    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'teacher_id' => $_SESSION['user']['user_id'],
                'name'       => $_POST['name'],
                'language'   => $_POST['language'],
                'price'      => $_POST['price'],
                'description' => $_POST['description']
            ];
            if ($courseModel->addCourse($data)) {
                header("Location: index.php?mod=course&act=myCourses");
            } else {
                $error = "Thêm khóa học thất bại!";
            }
        }
        include "../site/view/course/add.php";
        break;

    case 'edit':
        $course_id = $_GET['id'];
        $course = $courseModel->getCourseById($course_id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'course_id'  => $course_id,
                'teacher_id' => $_SESSION['user']['user_id'],
                'name'       => $_POST['name'],
                'language'   => $_POST['language'],
                'price'      => $_POST['price'],
                'description' => $_POST['description']
            ];
            if ($courseModel->updateCourse($course_id, $data)) {
                header("Location: index.php?mod=course&act=myCourses");
            } else {
                $error = "Cập nhật thất bại!";
            }
        }
        include "../site/view/course/edit.php";
        break;

    case 'delete':
        $course_id = $_GET['id'];
        $courseModel->deleteCourse($course_id, $_SESSION['user']['user_id']);
        header("Location: index.php?mod=course&act=myCourses");
        break;

    case 'lessonList':
        if (!empty($_GET['course_id'])) {
            $course_id = intval($_GET['course_id']);
            $course = $courseModel->getCourseById($course_id);
            $lessons = $lessonModel->getLessonsByCourse($course_id);

            require __DIR__ . '/../view/course/lesson_list.php';
        } else {
            echo "<p>Không có ID khóa học</p>";
        }
        break;
        case 'quiz':
        $lesson_id= isset($_GET['lesson_id']) ? intval($_GET['lesson_id']) : null;
        $course_id= isset($_GET['course_id']) ? intval($_GET['course_id']) : null;
        if (isset($_GET['submit'])) {
            $title = $_GET['quiz_title'] ?? '';
            $desc = $_GET['quiz_description'] ?? '';
            $total = $_GET['total_score'] ?? '';
            $pass  = $_GET['pass_score'] ?? '';
            // Tiếp tục xử lý hoặc lưu session
        }
        $quizController->renderQuiz($lesson_id, $course_id);
        break;

    case 'question':
        $lesson_id= isset($_GET['lesson_id']) ? intval($_GET['lesson_id']) : null;
        $course_id= isset($_GET['course_id']) ? intval($_GET['course_id']) : null;
        $title = $_GET['quiz_title'] ?? '';
        $description = $_GET['quiz_description'] ?? '';
        $total_score = $_GET['total_score'] ?? '';
        $pass_score = $_GET['pass_score'] ?? '';
        $time_limit = $_GET['time'] ?? '';
        $method = $_GET['meth'] ?? '';
        $quizController->renderSquestionPage($lesson_id, $course_id, $title, $description, $total_score, $pass_score, $time_limit, $method);
        break;

    case 'editquiz':
        $lesson_id = isset($_GET['lesson_id']) ? intval($_GET['lesson_id']) : null;
        $course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : null;
        $quizController->renderEditQuizPage($lesson_id, $course_id);
        break;

    case 'updatequestion':
        $quizController->updateQuestion();
        break;
    
    case 'deletequestion':
        $question_id = isset($_GET['question_id']) ? intval($_GET['question_id']) : null;
        $lesson_id = isset($_GET['lesson_id']) ? intval($_GET['lesson_id']) : null;
        $course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : null;
        $quizController->deleteQuestion($question_id, $lesson_id, $course_id);
        break;

    case 'getQuiz':
        $lesson_id = isset($_GET['id']) ? intval($_GET['id']) : null;
        $user_id = $_SESSION['user']['user_id'] ?? null;
        $quizController->getQuiz($lesson_id);
        break;
    case 'submitQuiz':
        $lesson_id = isset($_GET['lesson_id']) ? intval($_GET['lesson_id']) : null;
        $user_id = $_SESSION['user']['user_id'] ?? null;
        $quizController->submitQuiz($lesson_id);
        break;
}
