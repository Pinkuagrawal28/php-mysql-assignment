<?php

require './../vendor/autoload.php';
require './../app/configs/dbh.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

$name     = $_POST['name'];
$email    = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$otp = rand(100000, 999999);

$_SESSION['otp']       = $otp;
$_SESSION['user_data'] = [
    'name'     => $name,
    'email'    => $email,
    'password' => $password,
];

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
    $mail->Subject = 'Your OTP Code';
    $mail->Body    = "Your OTP is: $otp";

    $mail->send();
    echo "OTP sent successfully to $email";
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}
