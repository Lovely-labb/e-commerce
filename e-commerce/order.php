<?php
session_start();
include('database/db.php');
 
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $user_id = $user['id'];
 
} else {
    header('Location: index.php');
    exit;
}
 
$query = "SELECT o.order_id, p.pt_name, o.quantity, o.order_date, p.pt_img, p.pt_type
          FROM order_tbl o
          JOIN products_tbl p ON o.product_id = p.product_id
          WHERE o.id = :user_id";
 
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY ORDERS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/order.css">
</head>
<body>
<div class="navbar" style="background-color: #00247E;">
    <a href="welcome.php">Home</a>
    <span class="username">Welcome: <?php echo $user['username']; ?>!</span>
    <a href="php/logout.php">Logout</a>
    <a href="order.php">Orders</a>
  </div>
 
    <div class="container mt-5">
        <h2 class="text-center mb-4">My Orders</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover order-table">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Order Date</th>
                        <th>Product Type</th>
                        <th>Product Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($orders) > 0): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo $order['order_id']; ?></td>
                                <td><?php echo $order['pt_name']; ?></td>
                                <td><?php echo $order['quantity']; ?></td>
                                <td><?php echo $order['order_date']; ?></td>
                                <td><?php echo $order['pt_type']; ?></td>
                                <td>
                                    <img src="product/product_img/<?php echo htmlspecialchars($order['pt_img']); ?>" alt="Product Image" class="img-fluid">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 
 