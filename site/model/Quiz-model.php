<?php
include_once "Database.php";

class QuizModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllCourses() {
        $sql = "SELECT * FROM courses";
        return $this->db->getAll($sql);
    }

    public function getCourseById($courseId) {
        $sql = "SELECT * FROM courses WHERE courses_id = ?";
        return $this->db->getOne($sql, [$courseId]);
    }

    public function getLessonsByCourseId($courseId) {
        $sql = "SELECT * FROM lessons WHERE courses_id = ?";
        return $this->db->getAll($sql, [$courseId]);
    }

    public function saveQuiz($course_id, $lesson_id, $question_text, $answers, $correct_index, $meth, $time_limit = 15, $score = 10) {
        $conn = $this->db->getConn();

        // Ép kiểu $answers nếu bị truyền sai
        if (is_string($answers)) {
            $answers = json_decode($answers, true);
        }
        if (!is_array($answers)) {
            return false; // tránh lỗi foreach
        }

        try {
            $conn->beginTransaction();

            $quiz_id = $this->getOrCreateQuiz($course_id, $lesson_id, $time_limit);

            $sql_session = "INSERT INTO quiz_sessions (quiz_id, user_id, started_at) VALUES (?, ?, NOW())";
            $this->db->execute($sql_session, [$quiz_id, 1]); // user_id giả định
            $session_id = $conn->lastInsertId();

            $question_type = $this->convertMethToType($meth);
            $sql_question = "INSERT INTO quiz_questions (session_id, question_text, question_type, score) VALUES (?, ?, ?, ?)";
            $this->db->execute($sql_question, [$session_id, $question_text, $question_type, $score]);
            $question_id = $conn->lastInsertId();

            foreach ($answers as $index => $text) {
                if (trim($text) === '') continue;
                $is_correct = ($index == $correct_index) ? 1 : 0;
                $sql_option = "INSERT INTO quiz_options (question_id, `option`, is_correct) VALUES (?, ?, ?)";
                $this->db->execute($sql_option, [$question_id, $text, $is_correct]);
            }

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollBack();
            return false;
        }
    }

    private function getOrCreateQuiz($course_id, $lesson_id, $time_limit) {
        $sql = "SELECT quiz_id FROM quizzes WHERE courses_id = ? AND lesson_id = ?";
        $result = $this->db->getOne($sql, [$course_id, $lesson_id]);

        if ($result) return $result['quiz_id'];

        $now = date('Y-m-d H:i:s');
        $sql_insert = "INSERT INTO quizzes (courses_id, lesson_id, title, description, timing_limit, total_score, pass_score, is_active, created_at, updated_at)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $course_id,
            $lesson_id,
            "Quiz tự tạo",
            "Tự động tạo khi nhập câu hỏi",
            $time_limit,
            100,
            50,
            1,
            $now,
            $now
        ];
        $this->db->execute($sql_insert, $params);

        return $this->db->getConn()->lastInsertId();
    }

    private function convertMethToType($meth) {
        switch ($meth) {
            case 2: return 'passage';
            case 3: return 'text';
            default: return 'multiple_choice';
        }
    }

    public function getQuizIdByCourseAndLesson($course_id, $lesson_id) {
        $sql = "SELECT quiz_id FROM quizzes WHERE courses_id = ? AND lesson_id = ?";
        $result = $this->db->getOne($sql, [$course_id, $lesson_id]);
        return $result['quiz_id'] ?? null;
    }
}
?>
