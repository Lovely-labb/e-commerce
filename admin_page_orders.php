<?php
session_start();
include('database/db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: welcome.php');
    exit;
}

$query = "SELECT o.order_id, p.pt_name, o.quantity, o.order_date, p.pt_img, p.pt_type, u.username
          FROM order_tbl o
          JOIN products_tbl p ON o.product_id = p.product_id
          JOIN users u ON o.id = u.id";
$stmt = $conn->prepare($query);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders (Admin)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/order.css">
    <link rel="stylesheet" href="css/adminpageorders.css">
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
<div class="container mt-5" style="margin-left: 220px;">
    <h2 class="text-center mb-4">All Orders</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover order-table">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                    <th>Product Type</th>
                    <th>Image</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><?php echo ($order['order_id']); ?></td>
                        <td><?php echo ($order['pt_name']); ?></td>
                        <td><?php echo ($order['quantity']); ?></td>
                        <td><?php echo ($order['order_date']); ?></td>
                        <td><?php echo ($order['pt_type']); ?></td>
                        <td><img src="product/product_img/<?php echo htmlspecialchars($order['pt_img']); ?>" alt="Product Image" class="img-fluid" style="max-width: 100px;"></td>
                        <td><?php echo htmlspecialchars($order['username']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
