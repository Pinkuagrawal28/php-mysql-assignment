<?php
require_once BASE_PATH . '/app/configs/dbh.php';
require_once BASE_PATH . '/app/configs/session.php';

if (empty($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname    = trim($_POST['fname']);
    $lname    = trim($_POST['lname']);
    $fullname = $fname . ' ' . $lname;

    if (empty($fname) || empty($lname)) {
        $_SESSION['error_message'] = "First name and Last name are required!";
        header('Location: /form?q=1');
        exit();
    }

    $userId = $_SESSION['user_id'];

    $checkStmt = $pdo->prepare("SELECT id FROM profiles WHERE user_id = ?");
    $checkStmt->execute([$userId]);
    $profile = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($profile) {
        $updateStmt = $pdo->prepare("UPDATE profiles SET name = :fullname WHERE user_id = :user_id");
        $updateStmt->execute([
            ':fullname' => $fullname,
            ':user_id'  => $userId,
        ]);
    } else {
        $insertStmt = $pdo->prepare("INSERT INTO profiles (name, user_id, created_at) VALUES (:fullname, :user_id, NOW())");
        $insertStmt->execute([
            ':fullname' => $fullname,
            ':user_id'  => $userId,
        ]);
    }

    $_SESSION['success_message'] = "Profile saved!";
    header('Location: /form?q=2');
    exit();
}
