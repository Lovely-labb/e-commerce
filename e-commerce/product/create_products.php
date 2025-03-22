<?php

session_start();
include('../database/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $name = trim($_POST['product_name']);
    $type = trim($_POST['product_type']);
    $price = trim($_POST['product_price']);

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        
        $imgName   = $_FILES['image']['name'];
        $imgTmp    = $_FILES['image']['tmp_name'];
        $uploadDir = 'product_img/';
 
       
        // Create the product_img directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
 
        // Generate a unique name for the image
        $ext          = pathinfo($imgName, PATHINFO_EXTENSION);
        $newImageName = uniqid() . '.' . $ext;
        $uploadPath   = $uploadDir . $newImageName;
 
        if (!move_uploaded_file($imgTmp, $uploadPath)) {
            echo "Error uploading the image.";
            exit;
        }
    } else {
        $newImageName = null;
    }

    // Prepare and execute the INSERT query
    $stmt = $conn->prepare("INSERT INTO products_tbl (pt_name, pt_type, pt_price, pt_img) VALUES (:name, :type, :price, :image)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $newImageName);
    $stmt->execute();
 
    // Redirect with a success message
    $_SESSION['successMessage'] = "Product added successfully!";
 
    header("Location: ../products_page.php");
    exit;
}
 
// Redirect back if the request is not valid
header("Location: ../products_page.php");
exit;
?>