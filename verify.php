<?php
session_start();
require 'db.php';
$email = $_SESSION['email'] ?? '';
if (!$email) header("Location: index.php");
$stmt = $pdo->prepare("SELECT name, verification_code FROM users WHERE email=?");
$stmt->execute([$email]);
$user = $stmt->fetch();
$name = $user['name'];
$actualCode = $user['verification_code'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    if ($code == $actualCode) {
        $pdo->prepare("UPDATE users SET is_verified=1 WHERE email=?")->execute([$email]);
        header("Location: login.php");
        exit();
    } else {
        $error = "Invalid code.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
<form method="post">
    <h2>Hello, <?= htmlspecialchars($name) ?>!</h2>
<p>Please enter the verification code sent to <?= htmlspecialchars($email) ?>.</p>
  <input type="text" name="code" placeholder="Enter Code" required>
  <button type="submit">Verify</button>
</form>
</body>
</html>