<?php
class LessonModel
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

   public function getAllLessons(): array
{
    $stmt = $this->conn->query("SELECT * FROM lessons ORDER BY lesson_id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getLessonById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM lessons WHERE lesson_id = ?");
        $stmt->execute([$id]);
        $lesson = $stmt->fetch(PDO::FETCH_ASSOC);
        return $lesson ?: null;
    }

    public function addLesson(array $data): bool
    {
        $stmt = $this->conn->prepare("
            INSERT INTO lessons (course_id, title, status, created_at)
            VALUES (:course_id, :title, :status, NOW())
        ");
        return $stmt->execute([
            ':course_id' => $data['course_id'],
            ':title'     => $data['title'],
            ':status'    => (int)$data['status']
        ]);
    }

    public function updateLesson(int $id, array $data): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE lessons
            SET course_id = :course_id,
                title = :title,
                status = :status,
                updated_at = NOW()
            WHERE lesson_id = :id
        ");
        return $stmt->execute([
            ':course_id' => $data['course_id'],
            ':title'     => $data['title'],
            ':status'    => (int)$data['status'],
            ':id'        => $id
        ]);
    }

    public function deleteLesson(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM lessons WHERE lesson_id = ?");
        return $stmt->execute([$id]);
    }
}
