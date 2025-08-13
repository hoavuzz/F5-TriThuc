<?php
class UserModel {
    private PDO $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    // ===== USERS =====
    public function getAllUsers() {
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($data) {
        $sql = "INSERT INTO users (username, email, phone, password, role, status, teacher_file) 
                VALUES (:username, :email, :phone, :password, :role, :status, :teacher_file)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // public function updateUser($data) {
    //     $sql = "UPDATE users 
    //             SET username = :username, email = :email, phone = :phone, 
    //                 role = :role, status = :status, teacher_file = :teacher_file 
    //             WHERE user_id = :user_id";
    //     $stmt = $this->conn->prepare($sql);
    //     return $stmt->execute($data);
    // }

    public function deleteUserById($id) {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function updateStatus($user_id, $status) {
        $sql = "UPDATE users SET status = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $user_id]);
    }

    // ===== TEACHERS =====
    public function getApprovedTeachers() {
        $sql = "SELECT t.*, u.username, u.email, u.phone 
                FROM teachers t
                JOIN users u ON t.user_id = u.user_id
                WHERE u.role = 'teacher' AND u.status = 1";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendingTeachers() {
        $sql = "SELECT * FROM users WHERE role = 'teacher' AND status = 0";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTeacher($user_id) {
        $sql = "INSERT INTO teachers (user_id, bio, expertise, education_level, verified) 
                VALUES (?, '', '', '', 1)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$user_id]);
    }

    public function deleteTeacher($teacher_id) {
        $sql = "DELETE FROM teachers WHERE teacher_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$teacher_id]);
    }
    public function updateUser(array $data) {
    $sql = "UPDATE users SET username=?, email=?, phone=?, role=?, status=?, teacher_file=? WHERE user_id=?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        $data['username'],
        $data['email'],
        $data['phone'],
        $data['role'],
        $data['status'],
        $data['teacher_file'],
        $data['user_id']
    ]);

    // Nếu role = teacher và status = 1 thì thêm vào bảng teachers
    if ($data['role'] === 'teacher' && $data['status'] == 1) {
        $check = $this->conn->prepare("SELECT * FROM teachers WHERE user_id=?");
        $check->execute([$data['user_id']]);
        if (!$check->fetch()) {
            $insert = $this->conn->prepare("INSERT INTO teachers (user_id, bio, expertise, education_level, verified) VALUES (?, '', '', '', 1)");
            $insert->execute([$data['user_id']]);
        }
    }
}

/// home
function getDashboardStats($conn)
{
  // Tổng doanh thu
  $q1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_price) as total FROM orders WHERE status='paid'"));
  // Tổng đơn
  $q2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders"));
  // Trung bình
  $q3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(total_price) as avg FROM orders"));
  // Học viên
  $q4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as students FROM users WHERE role='student'"));
  // Giáo viên
  $q5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as teachers FROM teachers WHERE verified=1"));

  // Biểu đồ doanh thu theo ngày
  $chart = mysqli_query($conn, "
        SELECT DATE(created_at) as day, SUM(total_price) as total
        FROM orders
        WHERE status='paid'
        GROUP BY day
        ORDER BY day DESC
        LIMIT 7
    ");

  $labels = [];
  $data = [];
  while ($row = mysqli_fetch_assoc($chart)) {
    $labels[] = $row['day'];
    $data[] = $row['total'];
  }

  return [
    'revenue' => $q1['total'] ?? 0,
    'orders' => $q2['count'] ?? 0,
    'avg_order' => round($q3['avg'] ?? 0),
    'students' => $q4['students'],
    'teachers' => $q5['teachers'],
    'chart_labels' => array_reverse($labels),
    'chart_data' => array_reverse($data)
  ];
}

}
