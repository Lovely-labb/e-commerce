<?php
include('../database/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'] ;
    $address = $_POST['address'];
    $number = $_POST['number'];
    $role = $_POST['role'] ?? 'user'; 
    

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
        header('Location: ../registration.php?error=' . $error);
        exit;
    }

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->execute(['username' => $username, 'email' => $email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        $error = "Username or email already exists!";
        header('Location: ../registration.php?error=' . $error);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, address, number, role) VALUES (:username, :email, :password, :address, :number, :role)");
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'address' => $address,
        'number' => $number,
        'role' => $role,
    ]);

    $success = "Registration Succes!";
    header('Location: ../index.php?success=' . $success);
    exit;
} else {
    header('Location: ../registration.php');
    exit;
}
?>