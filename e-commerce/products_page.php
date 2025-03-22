<?php
session_start();
include('database/db.php');
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {

    header('Location: index.php');
    exit;
}

$query = "SELECT * FROM products_tbl";
$stmt = $conn->query($query);
 

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/productpage.css">
</head>
<body>

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

<!-- Button trigger modal -->
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addproduct">
    ADD NEW PRODUCT
  </button>

<!-- Modal -->
  <div class="modal fade" id="addproduct" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form action="product/create_products.php" method="POST" enctype="multipart/form-data">
            <label for="product_name">Product Name:</label>
            <input class="form-control" type="text" name="product_name" required>

            <label for="product_type">Product Type:</label>
            <input class="form-control" type="text" name="product_type" required>

            <label for="product_price">Product Price:</label>
            <input class="form-control" type="number" name="product_price" required>

            <label for="image">Product Image:</label>
            <input class="form-control" type="file" name="image" accept="image/*" required>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="submit" class="btn btn-success">Add Product</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>

<!-- Product Table -->
<h2 style="margin-top: 30px;">Added Products</h2>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Product Name</th>
      <th>Product Type</th>
      <th>Price</th>
      <th>Image</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $row): ?>
    <tr>
      <td><?php echo htmlspecialchars($row['pt_name']); ?></td>
      <td><?php echo htmlspecialchars($row['pt_type']); ?></td>
      <td><?php echo htmlspecialchars($row['pt_price']); ?></td>
      <td><img style="height:30px" src="product/product_img/<?php echo htmlspecialchars($row['pt_img']); ?>" alt=""></td>
      <td>
        <!-- Edit Button -->
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editbtn<?php echo $row['product_id']; ?>">Edit</button>
        <!-- Delete Button -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletebtn<?php echo $row['product_id']; ?>">Delete</button>
      </td>
    </tr>

    <!-- Edit Modal -->
    <div class="modal fade" id="editbtn<?php echo $row['product_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['product_id']; ?>" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form action="product/edit_product.php" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">

              <label for="product_name">Product Name:</label>
              <input class="form-control" type="text" name="product_name" value="<?php echo htmlspecialchars($row['pt_name']); ?>" required>

              <label for="product_type">Product Type:</label>
              <input class="form-control" type="text" name="product_type" value="<?php echo htmlspecialchars($row['pt_type']); ?>" required>

              <label for="product_price">Product Price:</label>
              <input class="form-control" type="number" name="product_price" value="<?php echo htmlspecialchars($row['pt_price']); ?>" required>

              <label>Current Image:</label><br>
              <img src="product/product_img/<?php echo htmlspecialchars($row['pt_img']); ?>" style="height:50px;"><br><br>

              <label for="image">New Product Image (optional):</label>
              <input class="form-control" type="file" name="image" accept="image/*">

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="update" class="btn btn-warning">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deletebtn<?php echo $row['product_id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['product_id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete "<strong><?php echo $row['pt_name']; ?></strong>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="product/delete_product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-danger">CONFIRM</a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
  </tbody>
</table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
