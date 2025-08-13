<?php
require_once __DIR__ . '/../model/Home.php';

class DashboardController {
    private $model;

    public function __construct($db) {
        $this->model = new DashboardModel($db);
    }

    public function index() {
        $data = [
            'totalRevenue'         => $this->model->getTotalRevenue(),
            'totalOrders'          => $this->model->getTotalOrders(),
            'avgOrderValue'        => $this->model->getAvgOrderValue(),
            'returningCustomerRate'=> $this->model->getReturningCustomerRate(),
            'orderStatus'          => $this->model->getOrderStatus(),
            'ordersOverTime'       => $this->model->getOrdersOverTime()
        ];
        require __DIR__ . '/../view/home.php';
    }
}
