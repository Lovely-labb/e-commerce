<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// Check if the 'user' session variable is set
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    // If the user session variable is not set, redirect to the login page
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/adminpage.css">
</head>
<body>

  <!-- Navigation Bar -->
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


</body>
</html>
