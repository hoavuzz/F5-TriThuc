<?php
require_once __DIR__ . '/../model/Database.php';

class Lesson {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConn();
    }

    // Lấy một bài học theo ID
    public function getLessonById($lesson_id) {
        $sql = "SELECT * FROM lessons WHERE lesson_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$lesson_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách bài học theo khóa học
    public function getLessonsByCourse($course_id) {
        $sql = "SELECT * FROM lessons WHERE course_id = ? ORDER BY lesson_id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy nội dung bài học (chi tiết)
    public function getLessonContent($lesson_id) {
        $sql = "SELECT content FROM lessons WHERE lesson_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$lesson_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $row['content'] : null;
    }
}
?>
