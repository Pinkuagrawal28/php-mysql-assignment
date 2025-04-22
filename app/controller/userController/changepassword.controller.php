<?php
require_once BASE_PATH . '/app/configs/dbh.php';

// STEP 1: Show form if token is valid
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token exists and is still valid
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > ?");
    $stmt->execute([$token, time()]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user): ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <title>Reset Password</title>
        </head>
        <body>
            <h1>Reset Your Password</h1>
            <form action="/resetpassword" method="POST">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                <div>
                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" required>
                </div>
                <div>
                    <input type="submit" value="Reset Password">
                </div>
            </form>
        </body>
        </html>
    <?php else:
        echo "This password reset link is invalid or has expired.";
    endif;
  }