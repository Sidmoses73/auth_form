<?php
session_start();
require 'db.php';
require 'mailer/send_mail.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $code = rand(100000, 999999);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, verification_code) VALUES (?, ?, ?, ?)");
    try {
        $stmt->execute([$name, $email, $password, $code]);
        sendVerificationEmail($email, $code);
        $_SESSION['email'] = $email;
        header("Location: verify.php");
        exit();
    } catch (PDOException $e) {
        $error = "Email already exists.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post">
    <h2>Please Register & Login</h2>
  <input type="text" name="name" placeholder="Full Name" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Sign Up</button>
  <a class="login" href="login.php">Login</a> 
</form>
</body>
</html>