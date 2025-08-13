<?php
class DashboardModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Tổng doanh thu
    public function getTotalRevenue()
    {
        $sql = "SELECT SUM(total_price) AS revenue FROM orders WHERE status = 'paid'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['revenue'] ?? 0;
    }

    // Tổng số đơn hàng
    public function getTotalOrders()
    {
        $sql = "SELECT COUNT(*) AS total FROM orders";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    // Giá trị trung bình đơn hàng
    public function getAvgOrderValue()
    {
        $sql = "SELECT AVG(total_price) AS avg_value FROM orders";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['avg_value'] ?? 0;
    }

    // Tỉ lệ khách hàng quay lại
    public function getReturningCustomerRate()
    {
        // Tổng khách hàng
        $sql = "SELECT COUNT(DISTINCT user_id) AS total_customers FROM orders";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        $totalCustomers = $row['total_customers'] ?? 1;

        // Khách hàng quay lại (có hơn 1 đơn)
        $sql2 = "SELECT COUNT(user_id) AS returning FROM (
                    SELECT user_id FROM orders GROUP BY user_id HAVING COUNT(order_id) > 1
                 ) AS temp";
        $result2 = $this->conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        $returning = $row2['returning'] ?? 0;

        return ($returning / $totalCustomers) * 100;
    }

    // Số đơn hàng theo trạng thái
    public function getOrderStatus()
    {
        $sql = "SELECT status, COUNT(*) AS total FROM orders GROUP BY status";
        $result = $this->conn->query($sql);
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[ucfirst($row['status'])] = $row['total'];
        }
        return $rows;
    }

    // Đơn hàng theo ngày (7 ngày gần nhất)
    public function getOrdersOverTime()
    {
        $sql = "SELECT DATE(created_at) AS date, COUNT(*) AS orders
                FROM orders
                GROUP BY DATE(created_at)
                ORDER BY date ASC
                LIMIT 7";
        $result = $this->conn->query($sql);
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
}
