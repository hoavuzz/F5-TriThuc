<?php
require_once __DIR__ . '/../model/Database.php';

class Lesson
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConn();
    }

    // Lấy một bài học theo ID
    public function getLessonById($lesson_id)
    {
        $sql = "SELECT * FROM lessons WHERE lesson_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$lesson_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách bài học theo khóa học
    public function getLessonsByCourse($course_id)
    {
        $sql = "SELECT * FROM lessons WHERE course_id = ? ORDER BY lesson_id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy nội dung bài học (chi tiết)
    public function getLessonContent($lesson_id)
    {
        $sql = "SELECT content FROM lessons WHERE lesson_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$lesson_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $row['content'] : null;
    }
    // Thêm bài học
    public function addLesson($data)
    {
        $sql = "INSERT INTO lessons (course_id, title, content, created_at, updated_at)
            VALUES (:course_id, :title, :content, NOW(), NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Sửa bài học
    public function updateLesson($lesson_id, $data)
    {
        $sql = "UPDATE lessons 
            SET title=:title, content=:content, updated_at=NOW()
            WHERE lesson_id=:lesson_id AND course_id=:course_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Xoá bài học
    public function deleteLesson($lesson_id, $course_id)
    {
        $sql = "DELETE FROM lessons WHERE lesson_id=:lesson_id AND course_id=:course_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['lesson_id' => $lesson_id, 'course_id' => $course_id]);
    }
}
