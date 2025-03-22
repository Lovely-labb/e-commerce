<?php
session_start();
include('../database/db.php');

if (isset($_GET['cart_id'])) {
    $cart_id = $_GET['cart_id'];

    $query = "DELETE FROM cart_tbl WHERE cart_id = :cart_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Item removed successfully!";
    } else {
        $_SESSION['message'] = "Failed to remove item!";
    }
}

header("Location: cart.php");
exit;