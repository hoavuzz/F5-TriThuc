<?php
require_once __DIR__ . '/../model/Database.php';

class ContentModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConn();
    }

    // Lấy tất cả nội dung
    public function getAllContents()
    {
        $sql = "SELECT * FROM contents ORDER BY content_id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy nội dung theo ID
    public function getContentById($content_id)
    {
        $sql = "SELECT * FROM contents WHERE content_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$content_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách nội dung theo bài học
    public function getContentsByLesson($lesson_id)
    {
        $sql = "SELECT * FROM contents WHERE lesson_id = ? ORDER BY content_id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$lesson_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm nội dung mới
    public function addContent($data)
    {
        $sql = "INSERT INTO contents (lesson_id, content) VALUES (:lesson_id, :content)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Sửa nội dung
    public function updateContent($content_id, $data)
    {
        $sql = "UPDATE contents
                SET content = :content
                WHERE content_id = :content_id AND lesson_id = :lesson_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Xóa nội dung
    public function deleteContent($content_id, $lesson_id)
    {
        $sql = "DELETE FROM contents WHERE content_id = :content_id AND lesson_id = :lesson_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'content_id' => $content_id,
            'lesson_id' => $lesson_id
        ]);
    }

    // Lấy video_link từ content theo content_id
    public function getVideoLinkByContentId($content_id)
    {
        $sql = "SELECT video_link FROM contents WHERE content_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$content_id]);
        return $stmt->fetchColumn();
    }
}
