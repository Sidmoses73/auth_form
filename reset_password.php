<?php
require 'db.php';
$token = $_GET['token'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE users SET password=?, reset_token=NULL WHERE reset_token=?");
    $stmt->execute([$password, $token]);
    echo "Password reset successful. <a href='login.php'>Login</a>";
    exit();
}
?>
<form method="post">
  <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
  <input type="password" name="password" placeholder="New Password" required>
  <button type="submit">Reset Password</button>
</form>