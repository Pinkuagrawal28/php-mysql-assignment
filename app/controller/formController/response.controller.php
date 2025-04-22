<?php
    require_once BASE_PATH . '/app/configs/dbh.php';

    if (empty($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }

    $userId = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("SELECT p.name, p.phone_number, p.photo_path, u.email
                           FROM profiles p
                           JOIN users u ON p.user_id = u.id
                           WHERE p.user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (! $userData) {
            $_SESSION['error'] = "Profile not found.";
            header("Location: /profile");
            exit();
        }

        $stmt = $pdo->prepare("SELECT s.name AS subject, sm.marks
                           FROM student_marks sm
                           JOIN subjects s ON sm.subject_id = s.id
                           WHERE sm.profile_id = (SELECT id FROM profiles WHERE user_id = :user_id)");
        $stmt->execute([':user_id' => $userId]);
        $marks             = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $userData['marks'] = [];

        foreach ($marks as $mark) {
            $userData['marks'][$mark['subject']] = $mark['marks'];
        }

        $userData['folder'] = $userData['photo_path'] ?: '/default-photo.jpg';

    } catch (PDOException $e) {
        // Handle errors
        $_SESSION['error'] = "Something went wrong while fetching the data.";
        header("Location: /profile");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once BASE_PATH . '/app/components/metadata.component.php'; ?>
  <title>Home</title>
</head>
<body>
    <?php require_once BASE_PATH . '/app/components/header.component.php'; ?>

    <h2>The Form Results</h2>

    <div>
        <strong>Full Name:</strong>                                                                                                                                                                                                                                                                                         <?php echo htmlspecialchars($userData['name']); ?><br><br>
        <strong>Phone Number:</strong>                                                                                                                                                                                                                                                                                                                 <?php echo htmlspecialchars($userData['phone_number']); ?><br><br>
        <strong>Email:</strong>                                                                                                                                                                                                                                                         <?php echo htmlspecialchars($userData['email']); ?><br><br>
    </div>

    <div>
        <img src="<?php echo htmlspecialchars($userData['folder']); ?>" height="234" width="456" alt="User Photo"/>
    </div>

    <h3>Marks</h3>
    <table id="marks-table" border="1">
        <tr>
            <th>Subject</th>
            <th>Marks</th>
        </tr>
        <?php foreach ($userData['marks'] as $subject => $marks): ?>
            <tr>
                <td><?php echo htmlspecialchars($subject); ?></td>
                <td><?php echo htmlspecialchars($marks); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <form action="./Helpers/FormPDF.php" method="POST" autocomplete="on" enctype="multipart/form-data">
        <button type="submit" name="submit">Download Your Data</button>
    </form>

    <?php require_once BASE_PATH . '/app/components/footer.component.php'; ?>
</body>
</html>
