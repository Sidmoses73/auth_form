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