<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <?php
    if (isset($_GET['error'])) {
        echo "<p style='color:red; text-align:center;'>" . $_GET['error'] . "</p>";
    
    }

    if (isset($_GET['success'])) {
        echo "<p style='color:green; text-align:center;'>" . $_GET['success'] . "</p>";
    }
    ?>

    <form method="POST" action="php/login_auth.php">
        <input type="text" name="username" class="input-field" placeholder="Username" required autocomplete="off"><br>
        <input type="password" name="password" class="input-field" placeholder="Password" required autocomplete="off"><br>
        <button type="submit" class="btn">Login</button>
    </form>

    <a href="registration.php">Registration</a>
</div>

</body>
</html>
