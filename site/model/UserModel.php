<?php
require_once __DIR__ . '/../model/Database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConn();
    }

    // Lấy user theo email
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy user theo ID
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE user_id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm user mới
    public function addUser($data) {
        $sql = "INSERT INTO users (username, email, phone, password, role, status, teacher_file)
                VALUES (:username, :email, :phone, :password, :role, :status, :teacher_file)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':username'     => $data['username'],
            ':email'        => $data['email'],
            ':phone'        => $data['phone'],
            ':password'     => $data['password'], // LƯU MẬT KHẨU THƯỜNG
            ':role'         => $data['role'],
            ':status'       => $data['status'],
            ':teacher_file' => $data['teacher_file'] ?? null
        ]);
    }

    // Cập nhật trạng thái (duyệt/tạm dừng)
    public function updateStatus($userId, $status) {
        $sql = "UPDATE users SET status = :status WHERE user_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':id'     => $userId
        ]);
    }
    //student sửa thông tin cá nhân
    public function updateUser($user_id, $data) {
    $sql = "UPDATE users SET username = ?, email = ?, phone = ?, updated_at = NOW() WHERE user_id = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        $data['username'],
        $data['email'],
        $data['phone'],
        $user_id
    ]);
}


    // Lấy danh sách teacher đang chờ duyệt
    public function getPendingTeachers() {
        $sql = "SELECT * FROM users WHERE role = 'teacher' AND status = 0";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPurchasedCourses($user_id) {
    $sql = "SELECT c.course_id, c.name, c.language, c.price, c.updated_at
            FROM orders o
            JOIN order_items oi ON o.order_id = oi.order_id
            JOIN courses c ON oi.course_id = c.course_id
            WHERE o.user_id = ?
            ORDER BY o.created_at DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
