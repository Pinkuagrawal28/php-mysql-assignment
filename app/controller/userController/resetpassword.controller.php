<?php

require_once BASE_PATH . '/app/configs/dbh.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'], $_POST['new_password'])) {
    $token          = $_POST['token'];
    $newPassword    = $_POST['new_password'];
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Verify the token again
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > ?");
    $stmt->execute([$token, time()]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Update password and clear token
        $update = $pdo->prepare("UPDATE users SET pwd = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?");
        $update->execute([$hashedPassword, $token]);

        echo "Your password has been reset successfully. <a href='/login'>Login</a>";
    } else {
        echo "Invalid or expired token.";
    }
}
