<?php

require './../app/configs/dbh.php';

$enteredOtp = $_POST['otp'];

if ($enteredOtp == $_SESSION['otp']) {
    $user = $_SESSION['user_data'];
    $stmt = $pdo->prepare("INSERT INTO users (username, email, pwd) VALUES (?, ?, ?)");
    $stmt->execute([$user['name'], $user['email'], $user['password']]);

    unset($_SESSION['otp'], $_SESSION['user_data']);
    echo "Registration success. Redirecting...";
} else {
    echo "Invalid OTP. Try again.";
}
