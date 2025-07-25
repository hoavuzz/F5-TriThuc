<?php
   class Database{
       private $host = "localhost";
       private $username = "root";
       private $password = "";
       private $database = "du_an_1";
       private $conn;
       private $pdo;
      
       //Kiểm tra database đã tạo chưa, để tạo mới Database
       public static $instance;
       public static function getInstance(){
           if(!self::$instance){
               self::$instance = new Database();
           }
           return self::$instance;
       }
      
       public function __construct(){
           try{
               // Tạo kết nối đến database theo phương thức PDO
               $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
               $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               // echo "Connect thành công";
           }catch(PDOException $e){
               echo "Connection failed: ".$e->getMessage();
           }
       }

    public function getConnection() {
        return $this->pdo;
    }
       // Dùng cho câu lệnh SQL dạng INSERT, UPDATE hoặc DELETE
       public function execute($sql,$param = []){
           $stmt = $this->conn->prepare($sql);
           return $stmt->execute($param);
       }
       //Dùng cho câu lệnh SELECT
       public function getAll($sql){
           $stmt = $this->conn->prepare($sql);
           $stmt->execute();
           //Lấy tất cả dữ liệu
           return $stmt->fetchAll();
       }
       public function getConn(){
        return $this->conn;
    }

       public function getOne($sql){
           $stmt = $this->conn->prepare($sql);
           $stmt->execute();
           //Lấy 1 dữ liệu
           return $stmt->fetch();
       }
       public function getTotalProducts() {
        $sql = "SELECT COUNT(*) AS total_products FROM SanPham";
        
       
        $stmt = $this->conn->query($sql);
    
        if ($stmt) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
           // In ra kết quả truy vấn
    
            return $row["total_products"];
        } else {
            // Hiển thị lỗi nếu có
           
        }
        return 0;
    }
    public function getTotalCategories() {
        $sql = "SELECT COUNT(MaDanhMuc) AS total_categories FROM DanhMuc";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result ? $result["total_categories"] : 0;
    }
    public function getTotalCustomers() {
    $sql = "SELECT COUNT(MaKhachHang) AS total_customers FROM KhachHang";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row["total_customers"] : 0;
}
public function getTotalshow() {
    $sql = "SELECT COUNT(id) AS total_show FROM transporter";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row["total_show"] : 0;
}
public function getTotalkho() {
    $sql = "SELECT COUNT(id) AS total_kho FROM storage";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row["total_kho"] : 0;
}

    
    
}
?>
