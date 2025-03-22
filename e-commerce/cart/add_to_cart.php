<?php
session_start();
include('../database/db.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if the product is already in the cart
    $stmt = $conn->prepare("SELECT * FROM cart_tbl WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingItem) {
        // If item exists, update quantity
        $newQuantity = $existingItem['quantity'] + $quantity;
        $updateStmt = $conn->prepare("UPDATE cart_tbl SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $updateStmt->execute([$newQuantity, $user_id, $product_id]);
    } else {
        // If item does not exist, insert new row
        $insertStmt = $conn->prepare("INSERT INTO cart_tbl (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $insertStmt->execute([$user_id, $product_id, $quantity]);
    }

    // Redirect back to the welcome page
    header("Location: ../welcome.php?cart_success=true");
    exit;
} else {
    header("Location: ../welcome.php?error=invalid_request");
    exit;
}
?>
