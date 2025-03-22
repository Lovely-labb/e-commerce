<?php
session_start();
include('../database/db.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    // Fetch product image to delete from folder
    $query = "SELECT pt_img FROM products_tbl WHERE product_id=?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $imagePath = "../product/product_img/" . $product['pt_img'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete image file
        }

        // Delete product from database
        $query = "DELETE FROM products_tbl WHERE product_id=?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);

        header('Location: ../products_page.php');
        exit;
    }
} else {
    header('Location: ../products_page.php');
    exit;
}
?>