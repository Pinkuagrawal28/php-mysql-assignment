<?php
session_start();

require_once BASE_PATH . '/app/configs/dbh.php';

// --- Validators ---
class Validators
{
    public function test_input(string $data): string
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    public function isPhoneNumber(string $phone): bool
    {
        return preg_match('/^\+?[0-9]{7,15}$/', $phone);
    }
}

$validators = new Validators();

if (empty($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["phone"]) || ! $validators->isPhoneNumber($_POST["phone"])) {
        $_SESSION["error"] = "Invalid phone number!";
        header("Location: ./form?q=4");
        exit();
    }

    $phone = $validators->test_input($_POST["phone"]);

    try {
        $stmt = $pdo->prepare("SELECT id FROM profiles WHERE user_id = ?");
        $stmt->execute([$userId]);
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($profile) {
            $stmt = $pdo->prepare("UPDATE profiles SET phone_number = :phone WHERE user_id = :user_id");
        } else {
            $stmt = $pdo->prepare("INSERT INTO profiles (phone_number, user_id, name, photo_path, created_at)
                                   VALUES (:phone, :user_id, '', '', NOW())");
        }

        $stmt->execute([
            ':phone'   => $phone,
            ':user_id' => $userId,
        ]);

        $_SESSION["success"] = "Phone number saved!";
        header("Location: ./response");
        exit();

    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        $_SESSION["error"] = "Something went wrong.";
        header("Location: ./form?q=4");
        exit();
    }
}
