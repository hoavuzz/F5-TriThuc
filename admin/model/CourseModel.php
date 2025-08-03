<?php
class CourseModel
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    // Lấy tất cả khóa học
    public function getAllCourses(): array
    {
        $stmt = $this->conn->query("SELECT * FROM courses ORDER BY course_id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 khóa học theo ID
    public function getCourseById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE course_id = ?");
        $stmt->execute([$id]);
        $course = $stmt->fetch(PDO::FETCH_ASSOC);
        return $course ?: null;
    }

    // Thêm khóa học
    public function addCourse(array $data): bool
    {
        $stmt = $this->conn->prepare("
            INSERT INTO courses (teacher_id, category_id, name, price, image, description, language, views, created_at)
            VALUES (:teacher_id, :category_id, :name, :price, :image, :description, :language, 0, NOW())
        ");
        return $stmt->execute([
            ':teacher_id'  => $data['teacher_id'],
            ':category_id' => $data['category_id'],
            ':name'        => $data['name'],
            ':price'       => $data['price'],
            ':image'       => $data['image'],
            ':description' => $data['description'],
            ':language'    => $data['language'],
        ]);
    }

    // Cập nhật khóa học
    public function updateCourse(int $id, array $data): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE courses 
            SET teacher_id = :teacher_id,
                category_id = :category_id,
                name = :name,
                price = :price,
                image = :image,
                description = :description,
                language = :language,
                updated_at = NOW()
            WHERE course_id = :id
        ");
        return $stmt->execute([
            ':teacher_id'  => $data['teacher_id'],
            ':category_id' => $data['category_id'],
            ':name'        => $data['name'],
            ':price'       => $data['price'],
            ':image'       => $data['image'],
            ':description' => $data['description'],
            ':language'    => $data['language'],
            ':id'          => $id
        ]);
    }

    // Xóa khóa học
    public function deleteCourse(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE course_id = ?");
        return $stmt->execute([$id]);
    }
}
