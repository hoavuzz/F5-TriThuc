<?php
// Gọi model
include_once "../site/model/Quiz-model.php";
$quizmodel = new QuizModel();

// Lấy danh sách tất cả khóa học (để đổ vào select)
$courses = $quizmodel->getAllCourses();

$course_id = $_GET['course_id'] ?? null;
if ($course_id) {
    $course = $quizmodel->getCourseById($course_id);
    if (!$course) {
        echo "<p>Khóa học không tồn tại.</p>";
        exit;
    }
} else {
    $course = null;
}

// Điều hướng trang
$page = $_GET['page'] ?? 'quiz';

// Nếu là passage thì điều hướng đến đúng trang upload passage
$meth = $_GET['meth'] ?? null;
if ($page === 'quiz-upload-select' && $meth == 2) {
    $page = 'quiz-upload-passage';
}

// Xử lý khi gửi form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $page === 'quiz-upload-select') {
    // Lấy dữ liệu từ form
    $question    = $_POST['question'] ?? '';
    $answers     = $_POST['answers'] ?? [];
    $correct     = $_POST['correct_answer'] ?? -1;
    $score       = $_POST['score'] ?? 10;
    $course_id   = $_POST['course_id'] ?? null;
    $lesson_id   = $_POST['lesson_id'] ?? null;
    $meth        = $_POST['meth'] ?? 1;
    $time        = $_POST['time'] ?? 15;
    $action      = $_POST['action'] ?? '';

    // Ép kiểu để đảm bảo
    if (is_string($answers)) {
        $answers = json_decode($answers, true);
    }

    // Kiểm tra đầu vào
    if (trim($question) === '' || !is_array($answers) || count($answers) < 2 || $correct === -1) {
        echo "Vui lòng nhập đầy đủ thông tin câu hỏi.";
        exit;
    }

    // Gọi lưu quiz
    $result = $quizmodel->saveQuiz($course_id, $lesson_id, $question, $answers, $correct, $meth, $time, $score);

    if (!$result) {
        echo "Lưu quiz thất bại.";
        exit;
    }

    // Điều hướng khi lưu thành công
    // if ($action === 'done') {
    //     ob_clean(); // Xoá các output trước khi redirect
    //     header("Location: ?page=quiz");
    //     exit;
    // }

    // Nếu tiếp tục thêm câu hỏi
    $page = 'quiz-upload-select';
}

// Load view tương ứng
include_once "../site/view/$page.php";
