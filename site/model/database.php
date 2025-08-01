<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "04102005";
    private $database = "du_an_1";
    private $conn;

    public static $instance;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    private function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConn() {
        return $this->conn;
    }

    public function execute($sql, $params = []) {
        if (!is_array($params)) {
            $params = [$params]; // đảm bảo là mảng
        }

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    public function getAll($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Các hàm thống kê không thay đổi

    // Các hàm thống kê riêng
    public function getTotalProducts() {
        $sql = "SELECT COUNT(*) AS total_products FROM SanPham";
        $stmt = $this->conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["total_products"] ?? 0;
    }

    public function getTotalCategories() {
        $sql = "SELECT COUNT(MaDanhMuc) AS total_categories FROM DanhMuc";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["total_categories"] ?? 0;
    }

    public function getTotalCustomers() {
        $sql = "SELECT COUNT(MaKhachHang) AS total_customers FROM KhachHang";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["total_customers"] ?? 0;
    }

    public function getTotalShow() {
        $sql = "SELECT COUNT(id) AS total_show FROM transporter";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["total_show"] ?? 0;
    }

    public function getTotalKho() {
        $sql = "SELECT COUNT(id) AS total_kho FROM storage";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["total_kho"] ?? 0;
    }
}
?>
