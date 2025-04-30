<?php

require_once BASE_PATH . '/app/configs/dbh.php';
require_once BASE_PATH . '/vendor/autoload.php'; // PHPMailer autoload

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usermail'])) {
    $email = filter_var($_POST['usermail'], FILTER_SANITIZE_EMAIL);

    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (! $user) {
        echo "No user found with that email address.";
        exit;
    }

    // Generate token and expiry
    $token  = bin2hex(random_bytes(50));
    $expiry = time() + 3600; // 1 hour

    // Store token in database
    $update = $pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
    $update->execute([$token, $expiry, $email]);

    // Send reset email
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'pinku.kumar@innoraft.com';
        $mail->Password   = 'test75';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('pinku.kumar@innoraft.com', 'MailerPHP');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = 'Click the link to reset your password: <a href="http://localhost/changepassword?token=' . $token . '">Reset Password</a>';

        $mail->send();
        echo "A password reset link has been sent to your email.";
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

} else {
    echo "Invalid request.";
}
