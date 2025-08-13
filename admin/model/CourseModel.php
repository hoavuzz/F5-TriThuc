<?php
class CourseModel
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

   public function getAllCourses(): array
{
    $sql = "
        SELECT 
            courses.course_id,
            courses.teacher_id,
            courses.category_id,
            courses.name,
            courses.price,
            courses.image,
            courses.description,
            courses.views,
            courses.language,
            courses.created_at,
            categories.name AS category_name
        FROM courses
        LEFT JOIN categories ON courses.category_id = categories.category_id
        ORDER BY courses.course_id DESC
    ";
    $stmt = $this->conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function getCourseById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE course_id = ?");
        $stmt->execute([$id]);
        $course = $stmt->fetch(PDO::FETCH_ASSOC);
        return $course ?: null;
    }

    public function addCourse(array $data): bool
    {
        $stmt = $this->conn->prepare("
            INSERT INTO courses (teacher_id, category_id, name, price, image, description, views, language, created_at)
            VALUES (:teacher_id, :category_id, :name, :price, :image, :description, :views, :language, NOW())
        ");
        return $stmt->execute([
            ':teacher_id'   => $data['teacher_id'],
            ':category_id'  => $data['category_id'],
            ':name'         => $data['name'],
            ':price'        => $data['price'],
            ':image'        => $data['image'],
            ':description'  => $data['description'],
            ':views'        => $data['views'] ?? 0,
            ':language'     => $data['language']
        ]);
    }

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
                views = :views,
                language = :language
            WHERE course_id = :id
        ");
        return $stmt->execute([
            ':teacher_id'   => $data['teacher_id'],
            ':category_id'  => $data['category_id'],
            ':name'         => $data['name'],
            ':price'        => $data['price'],
            ':image'        => $data['image'],
            ':description'  => $data['description'],
            ':views'        => $data['views'],
            ':language'     => $data['language'],
            ':id'           => $id
        ]);
    }

    public function deleteCourse(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE course_id = ?");
        return $stmt->execute([$id]);
    }

}


