<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

function sendVerificationEmail($to, $code) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'localhost';
        $mail->SMTPAuth = false;
        $mail->Username = '';
        $mail->Password = '';
        $mail->SMTPSecure = 'false';
        $mail->Port = 1025;
        $mail->setFrom('noreply@example.com', 'Auth form');
        $mail->addAddress($to);
        $mail->Subject = 'Your Verification Code';
        $mail->Body = "Your verification code is: $code";
        $mail->send();
    } catch (Exception $e) {
        die("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}

function sendPasswordReset($to, $token) {
    $link = "http://sidmosestech.com/reset_password.php?token=$token";
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'localhost';
        $mail->SMTPAuth = false;
        $mail->Username = '';
        $mail->Password = '';
        $mail->SMTPSecure = 'false';
        $mail->Port = 1025;
        $mail->setFrom('noreply@example.com', 'Auth form');
        $mail->addAddress($to);
        $mail->Subject = 'Password Reset';
        $mail->Body = "Click to reset password: $link";
        $mail->send();
    } catch (Exception $e) {
        die("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}
?>
