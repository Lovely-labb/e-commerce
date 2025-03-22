<?php
session_start();
include('../database/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['product_id']) && !empty($_POST['user_id']) && !empty($_POST['quantity'])) {
        $pt_id = $_POST['product_id'];
        $id = $_POST['user_id'];
        $quantity = $_POST['quantity'];
        $order_date = date("Y-m-d");

        try {
            $conn->beginTransaction();

            // Insert order
            $query = "INSERT INTO order_tbl (id, product_id, quantity, order_date)
                      VALUES (:id, :product_id, :quantity, :order_date)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':product_id', $pt_id);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':order_date', $order_date);
            $stmt->execute();

            // Remove item from cart (if it exists)
            $delete_query = "DELETE FROM cart_tbl WHERE user_id = :user_id AND product_id = :product_id";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bindParam(':user_id', $id);
            $delete_stmt->bindParam(':product_id', $pt_id);
            $delete_stmt->execute();

            $conn->commit();

            // Redirect back to welcome.php after successful order
            header("Location: ../welcome.php?order_success=1");
            exit;
        } catch (Exception $e) {
            $conn->rollBack();
            header("Location: ../welcome.php?order_error=" . urlencode($e->getMessage()));
            exit;
        }
    } else {
        header("Location: ../welcome.php?order_error=Invalid request");
        exit;
    }
}
?>

