<?php
session_start(); // start session to store login info

require_once BASE_PATH . '/app/configs/dbh.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['name']);
    $password = $_POST['passwd'];

    if (empty($username) || empty($password)) {
        die('Please fill in both fields.');
    }

    $query = "SELECT id, username, pwd FROM users WHERE username = ?";
    $stmt  = $pdo->prepare($query);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['pwd'])) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: /form?q=1");
        exit();
    } else {
        echo "Invalid credentials.";
    }
}
