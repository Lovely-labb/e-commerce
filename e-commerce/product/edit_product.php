<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('../database/db.php');


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $type = $_POST['product_type'];
    $price = $_POST['product_price'];

    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $image = $_FILES['image']['name'];
        $target_dir = "../product/product_img/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

        $query = "UPDATE products_tbl SET pt_name=?, pt_type=?, pt_price=?, pt_img=? WHERE product_id=?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$name, $type, $price, $image, $id]);
    } else {
        $query = "UPDATE products_tbl SET pt_name=?, pt_type=?, pt_price=? WHERE product_id=?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$name, $type, $price, $id]);
    }

    header('Location: ../products_page.php');
    exit;
}
?>