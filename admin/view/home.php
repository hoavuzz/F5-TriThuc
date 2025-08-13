<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .stat-title { font-size: 0.9rem; color: #6c757d; }
        .stat-value { font-size: 1.5rem; font-weight: bold; }
    </style>
</head>
<body>
<div class="container-fluid p-4">
    <h3 class="mb-4">📊 Sales Dashboard</h3>
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card p-3">
                <div class="stat-title">Total Revenue</div>
                <div class="stat-value text-success">$<?= number_format($data['totalRevenue'], 2) ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <div class="stat-title">Total Orders</div>
                <div class="stat-value"><?= $data['totalOrders'] ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <div class="stat-title">Avg Order Value</div>
                <div class="stat-value">$<?= number_format($data['avgOrderValue'], 2) ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <div class="stat-title">Returning Customer Rate</div>
                <div class="stat-value text-primary"><?= number_format($data['returningCustomerRate'], 1) ?>%</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-md-8">
            <div class="card p-3">
                <h6>Orders Over Time</h6>
                <canvas id="lineChart"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6>Order Status</h6>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
const ordersOverTime = <?= json_encode($data['ordersOverTime']) ?>;
const orderStatus = <?= json_encode($data['orderStatus']) ?>;

new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: ordersOverTime.map(o => o.date),
        datasets: [{
            label: 'Orders',
            data: ordersOverTime.map(o => o.orders),
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.2)',
            fill: true,
            tension: 0.4
        }]
    }
});

new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(orderStatus),
        datasets: [{
            data: Object.values(orderStatus),
            backgroundColor: ['#198754', '#ffc107', '#dc3545']
        }]
    }
});
</script>
</body>
</html>
