<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_name'])) {
    $new_name = trim($_POST['new_name']);
    if ($new_name !== '') {
        $stmt = $pdo->prepare("UPDATE users SET name=? WHERE id=?");
        $stmt->execute([$new_name, $user_id]);
    }
}
$stmt = $pdo->prepare("SELECT name FROM users WHERE id=?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth For</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    
<form method="post">
    <h2>Welcome, <?= htmlspecialchars($user['name']) ?>!</h2>
  <input type="text" name="new_name" placeholder="Update name" value="<?= htmlspecialchars($user['name']) ?>" required >
  <button type="submit">Update Name</button>
  <a class="logout" href="logout.php">Logout</a>
</form>
<br>
</body>
</html>