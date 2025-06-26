<?php
session_start();
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=? AND is_verified=1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
    } else {
        $error = "Invalid credentials or unverified account.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <form method="post">
        <h2>Please Login With Your Email & Password </h2>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Login</button>
  <a class="forgotpass" href="index.php">Register</a> |
  <a class="forgotpass" href="reset_request.php">Forgot Password?</a> 
</form>
</body>
</html>