<?php
$host = 'localhost'; // Database host
$dbname = 'ecommerce'; // Database name
$username = 'root'; // Database username (usually root in local environments)
$password = ''; // Database password (usually empty in local environments)
 
try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>