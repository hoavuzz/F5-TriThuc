<?php

require_once __DIR__ . "/database.php";

class QuizzModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConn();
    }


    public function getCoursesbyId($course_id) {
        try {
            $sql = "SELECT * FROM courses WHERE course_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$course_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getLessonbyId($lesson_id) {
        try {
            $sql = "SELECT * FROM lessons WHERE lesson_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$lesson_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function addQuizzes($course_id, $lesson_id, $title, $description, $time_limit, $total_score, $pass_score, $is_active){
        $sql = "INSERT INTO quizzes (course_id , lesson_id, title, description, time_limit, total_score, pass_score, is_active)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$course_id, $lesson_id, $title, $description, $time_limit, $total_score, $pass_score, $is_active]);
        return $this->db->lastInsertId();
    }

    public function getQuizid($lesson_id){
        $sql = "SELECT quiz_id FROM quizzes WHERE lesson_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$lesson_id]);
        return $stmt->fetchColumn();
    }

    public function addQuestion($quiz_id, $question_text, $question_type, $score){
        $sql = "INSERT INTO quiz_questions (quiz_id, question_text, question_type, score)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$quiz_id, $question_text, $question_type, $score]);
        return $this->db->lastInsertId();
    }

    public function addOption($question_id , $option_text, $is_correct) {
        $sql = "INSERT INTO quiz_options (question_id, option_text, is_correct)
                VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$question_id, $option_text, $is_correct]);
        return $this->db->lastInsertId();
        
    }

    public function getQuizbyCourseidandLessonid($course_id, $lesson_id) {
        $sql = "SELECT * FROM quizzes WHERE course_id = ? AND lesson_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$course_id, $lesson_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQuestionbyQuizid($quiz_id) {
        $sql = "SELECT * FROM quiz_questions WHERE quiz_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$quiz_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOptionbyQuestionid($question_id) {
        $sql = "SELECT * FROM quiz_options WHERE question_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$question_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateQuestion($question_id, $question_text, $score) {
        $sql = "UPDATE quiz_questions SET question_text = ?, score = ? WHERE question_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$question_text, $score, $question_id]);
    }

    public function updateOption($option_id, $option_text, $is_correct) {
        $sql = "UPDATE quiz_options SET option_text = ?, is_correct = ? WHERE option_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$option_text, $is_correct, $option_id]);
    }

    public function deleteQuestion($question_id) {
        $sql = "DELETE FROM quiz_questions WHERE question_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$question_id]);
    }

    public function getQuizbyLessonId($lesson_id) {
        try {
            $sql = "SELECT * FROM quizzes WHERE lesson_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$lesson_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function saveQuizResult($user_id, $quiz_id, $score, $max_score, $is_passed, $duration) {
        try {
            $sql = "INSERT INTO quiz_sessions (user_id, quiz_id, score, is_passed, duration) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id, $quiz_id, $score, $is_passed, $duration]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function getQuiz($lesson_id){
        $sql = "SELECT * FROM quizzes WHERE lesson_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$lesson_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Lấy toàn bộ dòng
    }
    public function getContentbyId($lesson_id) {
        $sql = "SELECT * FROM contents WHERE lesson_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$lesson_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // chỉ lấy 1 dòng
    }



}
