<?php

require_once BASE_PATH . '/app/configs/dbh.php';

// Ensure user session and previous form data exist
if (! isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the file is uploaded
    if (! isset($_FILES['imageUpload']) || $_FILES['imageUpload']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION["imageUploadErr"] = "Image upload failed or image is missing.";
        header("Location: ./form?q=2");
        exit();
    }

    $imageFile        = $_FILES['imageUpload']['tmp_name'];
    $imageInfo        = getimagesize($imageFile);
    $maxFileSize      = 5 * 10 ** 6; // 5MB
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

    // Validate image
    if ($imageInfo === false) {
        $_SESSION["imageUploadErr"] = "That isn't a valid image.";
        header("Location: ./form?q=2");
        exit();
    }

    if (! in_array($imageInfo['mime'], $allowedMimeTypes)) {
        $_SESSION["imageUploadErr"] = "Only JPEG, PNG, and GIF formats are allowed.";
        header("Location: ./form?q=2");
        exit();
    }

    if ($_FILES['imageUpload']['size'] > $maxFileSize) {
        $_SESSION["imageUploadErr"] = "The image is too large. Max size is 5MB.";
        header("Location: ./form?q=2");
        exit();
    }

    $extension        = pathinfo($_FILES["imageUpload"]["name"], PATHINFO_EXTENSION);
    $imageName        = $_SESSION['username'] . "." . $extension;
    $targetDir        = BASE_PATH . "/app/assets/images/";
    $targetDirPublic  = BASE_PATH . "/public/Assets/images/";
    $targetFile       = $targetDir . time() . $imageName;
    $targetFilePublic = $targetDirPublic . time() . $imageName;
    $relativePath     = "/Assets/images/" . time() . $imageName;

    if (! is_writable($targetDir)) {
        $_SESSION["imageUploadErr"] = "Error: 'images/' folder is not writable.";
        header("Location: ./form?q=2");
        exit();
    }

    // Move uploaded file
    if (! move_uploaded_file($imageFile, $targetFile) && ! move_uploaded_file($imageFile, $targetFilePublic)) {
        $_SESSION["imageUploadErr"] = "Failed to save the uploaded image.";
        header("Location: ./form?q=2");
        exit();
    }

    // Update DB
    $query = "UPDATE profiles SET photo_path = :path WHERE user_id = :uid";
    $stmt  = $pdo->prepare($query);
    $stmt->execute([
        ':path' => $relativePath,
        ':uid'  => $userId,
    ]);

    // Redirect to the next question
    header("Location: ./form?q=3");
    exit();
}
