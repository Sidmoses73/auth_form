<?php
require 'db.php';
require 'send_mail.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(50));
    $stmt = $pdo->prepare("UPDATE users SET reset_token=? WHERE email=?");
    $stmt->execute([$token, $email]);
    sendPasswordReset($email, $token);
    echo "Reset link sent!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Auth Form</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <form method="post">
    <h2>Enter Your Email To Receive Reset Link</h2>
  <input type="email" name="email" placeholder="Your Email" required>
  <button type="submit">Send Reset Link</button>
  <a class="login" href="login.php">Login</a>
</form>
</body>
</html>
