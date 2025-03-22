<?php
// Connect to database
session_start();
include('database/db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: welcome.php');
    exit;
}

// Query for User Types
$userTypesQuery = $conn->query("SELECT role, COUNT(*) as count FROM users GROUP BY role");
$userTypesData = $userTypesQuery->fetchAll(PDO::FETCH_ASSOC);

// Query for Product Categories
$productCategoriesQuery = $conn->query("SELECT pt_type, COUNT(*) as count FROM products_tbl GROUP BY pt_type");
$productCategoriesData = $productCategoriesQuery->fetchAll(PDO::FETCH_ASSOC);

// Query for Orders Per User
$ordersQuery = $conn->query("SELECT id, COUNT(*) as count FROM order_tbl GROUP BY id");
$ordersData = $ordersQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>
    <link rel="stylesheet" href="css/adminpageanalytics.css">
    <!-- <link rel="stylesheet" href="css/analytics.css"> -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});

        document.addEventListener("DOMContentLoaded", function() {
            google.charts.setOnLoadCallback(drawCharts);
        });

        function drawCharts() {
            drawUserTypesChart();
            drawProductCategoriesChart();
            drawOrdersChart();
        }

        function drawUserTypesChart() {
            var data = google.visualization.arrayToDataTable([
                ['Role', 'Count'],
                <?php
                    if (empty($ordersData)) {
                        echo "['No Data', 0],";
                    }
                    
                    foreach ($userTypesData as $row) {
                        echo "['".$row['role']."', ".$row['count']."],";
                    }
                ?>
            ]);

            var options = { title: 'User Role Distribution' };
            var chart = new google.visualization.PieChart(document.getElementById('userTypesChart'));
            chart.draw(data, options);
        }

        function drawProductCategoriesChart() {
            var data = google.visualization.arrayToDataTable([
                ['Category', 'Count'],
                <?php
                    if (empty($ordersData)) {
                        echo "['No Data', 0],";
                    }
                    
                    foreach ($productCategoriesData as $row) {
                        echo "['".$row['pt_type']."', ".$row['count']."],";
                    }
                ?>
            ]);

            var options = { title: 'Sample' };
            var chart = new google.visualization.PieChart(document.getElementById('productCategoriesChart'));
            chart.draw(data, options);
        }

        function drawOrdersChart() {
            var data = google.visualization.arrayToDataTable([
                ['User', 'Orders'],
                <?php
                    if (empty($ordersData)) {
                        echo "['No Data', 0],";
                    } else {
                        foreach ($ordersData as $row) {
                            echo "['User ".$row['id']."', ".$row['count']."],";  
                        }
                    }
                ?>
            ]);

            var options = { title: 'Orders Per User' };
            var chart = new google.visualization.PieChart(document.getElementById('ordersChart'));
            chart.draw(data, options);
        }

    </script>

</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="nav-left">
        <a href="#">Dashboard</a>
        <a href="#">Users</a>
        <a href="#">Settings</a>
        <a href="Admin_page.php" style="color:#e53935">Home</a>
        </div>
        <div class="nav-right">
        <a href="php/logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="admin_page.php">Home</a>
        <a href="#">Profile</a>
        <a href="#">Manage User</a>
        <a href="products_page.php">Products</a>
        <a href="analytics_page.php">Analytics</a>
        <a href="admin_page_orders.php">View Orders</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="chart-wrapper">
        <div class="chart-container">
            <h3>User Types</h3>
            <div id="userTypesChart"></div>
        </div>
        <div class="chart-container">
            <h3>Product Categories</h3>
            <div id="productCategoriesChart"></div>
        </div>
        <div class="chart-container">
            <h3>Orders Per User</h3>
            <div id="ordersChart"></div>
        </div>
        </div>
        
    </div>

</body>
</html>
