<?php
require_once __DIR__ . '/../model/database.php';

class Course
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConn();
    }
    // Lấy tất cả khóa học
    public function getAllCourses()
    {
        $sql = "SELECT * FROM courses ORDER BY course_id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lọc danh sách khóa học theo các điều kiện
    public function filterCourses($category_id = null, $price = null, $levels = [], $durations = [])
    {
        $sql = "SELECT * FROM courses WHERE 1=1";
        $params = [];

        // Lọc theo danh mục
        if (!empty($category_id)) {
            $sql .= " AND category_id = ?";
            $params[] = $category_id;
        }

        // Lọc theo giá
        if (!empty($price)) {
            if ($price == "free") {
                $sql .= " AND price = 0";
            } elseif ($price == "under500") {
                $sql .= " AND price < 500000";
            } elseif ($price == "500-1000") {
                $sql .= " AND price BETWEEN 500000 AND 1000000";
            } elseif ($price == "over1000") {
                $sql .= " AND price > 1000000";
            }
        }

        // Lọc theo trình độ
        if (!empty($levels)) {
            $placeholders = implode(',', array_fill(0, count($levels), '?'));
            $sql .= " AND level IN ($placeholders)";
            $params = array_merge($params, $levels);
        }

        // Lọc theo thời lượng
        if (!empty($durations)) {
            $duration_conditions = [];
            foreach ($durations as $duration) {
                if ($duration == "under5") {
                    $duration_conditions[] = "time < 5";
                } elseif ($duration == "5-20") {
                    $duration_conditions[] = "(time >= 5 AND time <= 20)";
                } elseif ($duration == "over20") {
                    $duration_conditions[] = "time > 20";
                }
            }
            if (!empty($duration_conditions)) {
                $sql .= " AND (" . implode(" OR ", $duration_conditions) . ")";
            }
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy khóa học theo views
    public function getMostViewedCourses($limit = 6)
    {
        $sql = "SELECT * FROM courses ORDER BY views DESC LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy khóa học miễn phí
    public function getFreeCourses($limit = 6)
    {
        $sql = "SELECT * FROM courses WHERE price = 0 ORDER BY course_id DESC LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy thông tin khóa học theo ID
    public function getCourseById($id)
    {
        $sql = "SELECT * FROM courses WHERE course_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getCoursesByTeacher($teacher_id) {
    try {
        $sql = "SELECT course_id, name, language, price, updated_at 
                FROM courses 
                WHERE teacher_id = :teacher_id
                ORDER BY updated_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error in getCoursesByTeacher: " . $e->getMessage());
        return [];
    }
}
// Thêm khoá học
public function addCourse($data) {
    $sql = "INSERT INTO courses (teacher_id, name, language, price, description, created_at, updated_at)
            VALUES (:teacher_id, :name, :language, :price, :description, NOW(), NOW())";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute($data);
}

// Sửa khoá học
public function updateCourse($course_id, $data) {
    $sql = "UPDATE courses 
            SET name=:name, language=:language, price=:price, description=:description, updated_at=NOW()
            WHERE course_id=:course_id AND teacher_id=:teacher_id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute($data);
}

// Xoá khoá học
public function deleteCourse($course_id, $teacher_id) {
    $sql = "DELETE FROM courses WHERE course_id=:course_id AND teacher_id=:teacher_id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute(['course_id'=>$course_id,'teacher_id'=>$teacher_id]);
}

}
