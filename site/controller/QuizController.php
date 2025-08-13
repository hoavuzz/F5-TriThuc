<?php
    require_once '../site/model/database.php';
    require_once "../site/model/QuizzModel.php";

    class QuizzController{
        private $db;
        private $quizzModel;
        public function __construct(){
            $this->db = new Database();
            $this->quizzModel = new QuizzModel($this->db);
        }

        public function renderQuiz($lesson_id, $course_id){
            
            $course = $this->quizzModel->getCoursesbyId($course_id);
            $lesson = $this->quizzModel->getLessonbyId($lesson_id);
            $_SESSION['current_course'] = $course;
            $_SESSION['current_lesson'] = $lesson;
                // print_r($courses[0]['name']);
            include_once '../site/view/quiz/quizz.php';
        }
        public function renderSquestionPage($lesson_id, $course_id, $title, $description, $total_score, $pass_score, $time_limit, $method){

            // Lưu thông tin quiz vào session (nếu cần dùng lại sau)
            $_SESSION['quiz_info'] = [
                'title' => $title,
                'description' => $description,
                'total_score' => $total_score,
                'pass_score' => $pass_score,
                'time_limit' => $time_limit,
                'method' => $method,
                'lesson_id' => $lesson_id,
                'course_id' => $course_id
            ];

            // Xử lý khi người dùng submit form
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
                $question = $_POST['question'] ?? '';
                $score = $_POST['score'] ?? 10;
                $answers = [
                    $_POST['answer1'] ?? '',
                    $_POST['answer2'] ?? '',
                    $_POST['answer3'] ?? '',
                    $_POST['answer4'] ?? ''
                ];
                $correct = $_POST['correct'] ?? [];

                // Khởi tạo quiz nếu chưa có
                if (!isset($_SESSION['quiz_id'])) {
                    $quiz_id = $this->quizzModel->addQuizzes($course_id, $lesson_id, $title, $description, $time_limit, $total_score, $pass_score, $method);
                    $_SESSION['quiz_id'] = $quiz_id;
                } else {
                    $quiz_id = $_SESSION['quiz_id'];
                }

                if ($method== '1') {
                    // Xử lý câu hỏi nhiều lựa chọn
                    $question_type = 'multiple';
                } else {
                    // Xử lý câu hỏi đoạn văn
                    $question_type = 'text';
                }
                // Thêm câu hỏi và đáp án
                $quiz_id = $this->quizzModel->getQuizid($lesson_id);
                $question_id = $this->quizzModel->addQuestion($quiz_id, $question, $question_type, $score);
                foreach ($answers as $index => $ans) {
                    $is_correct = in_array($index + 1, $correct) ? 1 : 0;
                    $this->quizzModel->addOption($question_id, $ans, $is_correct);
                }

                // Nếu nhấn "Xong" thì kết thúc
                if ($_POST['action'] === 'finish') {
                    unset($_SESSION['quiz_id']);
                    header("Location: index.php?mod=course&act=quiz");
                    exit;
                }

                // Quay lại trang thêm câu hỏi, giữ lại thông tin trên URL
                $redirectUrl = "index.php?mod=course&act=question"
                    . "&lesson_id=$lesson_id"
                    . "&course_id=$course_id"
                    . "&quiz_title=" . urlencode($title)
                    . "&quiz_description=" . urlencode($description)
                    . "&total_score=$total_score"
                    . "&pass_score=$pass_score"
                    . "&time=$time_limit"
                    . "&meth=$method";

                header("Location: $redirectUrl");
                exit;
            }

            // Render trang nhập câu hỏi
            include_once '../site/view/quiz/quiz-u-s.php';
        }

        public function renderEditQuizPage($lesson_id, $course_id) {
            // Lấy tất cả các quiz trong bài học và khóa học
            $quizes = $this->quizzModel->getQuizbyCourseidandLessonid($course_id, $lesson_id);
            $questions = [];

            foreach ($quizes as $quiz) {
                // Lấy tất cả câu hỏi trong từng quiz
                $quiz_questions = $this->quizzModel->getQuestionbyQuizid($quiz['quiz_id']);

                foreach ($quiz_questions as $q) {
                    // Lấy tất cả các lựa chọn (options) tương ứng với câu hỏi
                    $q['options'] = $this->quizzModel->getOptionbyQuestionid($q['question_id']);

                    // Đưa câu hỏi (gồm cả options) vào mảng questions
                    $questions[] = $q;
                }
            }

            // Truyền dữ liệu sang view để hiển thị form chỉnh sửa
            include_once '../site/view/quiz/editQuiz.php';
        }

        public function updateQuestion() {
            $question_id = $_POST['question_id'];
            $question_text = $_POST['question_text'];
            $score = $_POST['score'];

            $lesson_id = $_POST['lesson_id'];
            $course_id = $_POST['course_id'];

            // Cập nhật câu hỏi
            $this->quizzModel->updateQuestion($question_id, $question_text, $score);

            // Xử lý option
            if (isset($_POST['options'])) {
                $correct_option_id = $_POST['correct_option_' . $question_id] ?? null;

                foreach ($_POST['options'] as $option_id => $option) {
                    $option_text = $option['text'];
                    $is_correct = ($option_id == $correct_option_id) ? 1 : 0;
                    $this->quizzModel->updateOption($option_id, $option_text, $is_correct);
                }
            }

            // Quay về trang edit
            header("Location: index.php?mod=course&act=editquiz&lesson_id=$lesson_id&course_id=$course_id");
            exit();
        }

        public function deleteQuestion($question_id, $lesson_id, $course_id) {
            $this->quizzModel->deleteQuestion($question_id);
            header("Location: index.php?mod=course&act=editquiz&lesson_id=$lesson_id&course_id=$course_id");
        }


        public function getQuiz($lesson_id) {
            $quizzes = $this->quizzModel->getQuizbyLessonId($lesson_id);
            $time_limit = $quizzes[0]['time_limit'] ?? 0;
            $question_data = [];

            if (!empty($quizzes)) {
                $quiz_id = $quizzes[0]['quiz_id'];
                $questions = $this->quizzModel->getQuestionbyQuizid($quiz_id);
                foreach ($questions as $question) {
                    $options = $this->quizzModel->getOptionbyQuestionid($question['question_id']);
                    $question_data[$question['question_id']] = [
                        'question_text' => $question['question_text'],
                        'score' => $question['score'],
                        'question_type' => $question['question_type'],
                        'options' => $options
                    ];
                }
            }

            include_once '../site/view/quiz/doQuiz.php';
        }

    public function submitQuiz($lesson_id) {
        $user_id = $_POST['user_id'] ?? null;
        $quiz_id = $_POST['quiz_id'] ?? null;
        $score = floatval($_POST['score'] ?? 0); // Điểm client gửi lên
        $max_score = floatval($_POST['max_score'] ?? 0);
        $duration = intval($_POST['duration'] ?? 0);
        $answers = json_decode($_POST['answers'] ?? '{}', true);

        // Lấy thông tin quiz
        $quizz = $this->quizzModel->getQuiz($lesson_id);
        $pass_score = $quizz['pass_score'] ?? 0;

        // Lấy thông tin lesson & content
        $lesson = $this->quizzModel->getLessonbyId($lesson_id);
        $course_id = $lesson['course_id'] ?? null;
        $content = $this->quizzModel->getContentbyId($lesson_id);
        $content_id = $content['content_id'] ?? null;

        // Nếu thiếu thông tin thì quay lại trang bài học
        if (!$user_id || !$quiz_id) {
            header("Location: index.php?mod=course&act=lesson&course_id=$course_id&lesson_id=$lesson_id&content_id=$content_id");
            return;
        }

        // Tính điểm lại từ server
        $questions = $this->quizzModel->getQuestionbyQuizid($quiz_id);
        $server_score = 0;

        foreach ($questions as $question) {
            $question_id = $question['question_id'];
            $question_type = $question['question_type'];
            $question_score = floatval($question['score']);

            if (isset($answers[$question_id])) {
                if ($question_type === 'multiple') {
                    $correct_option = $this->quizzModel->getOptionbyQuestionid($question_id);
                    foreach ($correct_option as $option) {
                        if ($option['is_correct'] && $option['option_id'] == $answers[$question_id]) {
                            $server_score += $question_score;
                            break;
                        }
                    }
                } elseif ($question_type === 'text') {
                    $correct_option = $this->quizzModel->getOptionbyQuestionid($question_id);
                    foreach ($correct_option as $option) {
                        if ($option['is_correct'] && strtolower(trim($option['option_text'])) === strtolower($answers[$question_id])) {
                            $server_score += $question_score;
                            break;
                        }
                    }
                }
            }
        }

        // Xác định đạt hay không dựa vào pass_score từ DB
        $is_passed = ($server_score >= $pass_score) ? 1 : 0;

        // So sánh điểm client gửi lên và server tính được để chống gian lận
        if (abs($server_score - $score) > 0.01) {
            echo json_encode(['status' => 'error', 'message' => 'Điểm không khớp giữa client và server']);
            return;
        }

        // Lưu kết quả vào DB
$result = $this->quizzModel->saveQuizResult($user_id, $quiz_id, $server_score, $max_score, $is_passed, $duration);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Kết quả đã được lưu thành công']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Lỗi khi lưu kết quả']);
        }

        // Chuyển hướng về bài học
        header("Location: index.php?mod=course&act=lesson&course_id=$course_id&lesson_id=$lesson_id&content_id=$content_id");
    }


        
    }

    