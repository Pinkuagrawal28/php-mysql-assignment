<?php
require_once BASE_PATH . '/app/configs/dbh.php';
require_once BASE_PATH . '/app/configs/session.php';

// --- Validators ---
class Validators
{
    public function test_input(string $data): string
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }
}

// --- Helpers ---
class Helpers
{
    public function handleMarks($rawMarks)
    {
        $structuredMarks = [];

        foreach ($rawMarks as $mark) {
            $mark = trim($mark);
            if (empty($mark)) {
                continue;
            }

            $pos = strpos($mark, "|");
            if ($pos === false) {
                continue;
            }

            $subject = trim(substr($mark, 0, $pos));
            $score   = trim(substr($mark, $pos + 1));

            if ($subject && is_numeric($score)) {
                $structuredMarks[$subject] = $score;
            }
        }

        return $structuredMarks;
    }
}

$validators = new Validators();
$helpers    = new Helpers();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["marks"])) {
        $_SESSION['error'] = "Please enter at least one subject and mark.";
        header("Location: ./form?q=3");
        exit;
    }

    $rawMarks    = explode("\n", $validators->test_input($_POST["marks"]));
    $parsedMarks = $helpers->handleMarks($rawMarks);

    if (empty($parsedMarks)) {
        $_SESSION['error'] = "No valid subject|mark entries found.";
        header("Location: ./form?q=3");
        exit;
    }

    $userId = $_SESSION['user_id'] ?? null;

    if (! $userId) {
        http_response_code(403);
        require_once BASE_PATH . '/app/views/shared/403.view.php';
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT id FROM profiles WHERE user_id = ?");
        $stmt->execute([$userId]);
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        if (! $profile) {
            $_SESSION['error'] = "Profile not found. Please complete previous steps.";
            header("Location: ./form?q=3");
            exit;
        }

        $profileId = $profile['id'];

        foreach ($parsedMarks as $subjectName => $marks) {
            $stmt = $pdo->prepare("SELECT id FROM subjects WHERE name = ?");
            $stmt->execute([$subjectName]);
            $subject = $stmt->fetch(PDO::FETCH_ASSOC);

            if (! $subject) {
                $insertSub = $pdo->prepare("INSERT INTO subjects (name) VALUES (?)");
                $insertSub->execute([$subjectName]);
                $subjectId = $pdo->lastInsertId();
            } else {
                $subjectId = $subject['id'];
            }

            $stmt = $pdo->prepare("SELECT id FROM student_marks WHERE profile_id = ? AND subject_id = ?");
            $stmt->execute([$profileId, $subjectId]);
            $existingMark = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingMark) {
                $stmt = $pdo->prepare("UPDATE student_marks SET marks = ? WHERE id = ?");
                $stmt->execute([$marks, $existingMark['id']]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO student_marks (profile_id, subject_id, marks) VALUES (?, ?, ?)");
                $stmt->execute([$profileId, $subjectId, $marks]);
            }
        }

        $_SESSION['success'] = "Marks saved successfully!";
        header("Location: ./form?q=4");
        exit;

    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        $_SESSION['error'] = "Something went wrong. Please try again.";
        header("Location: ./form?q=3");
        exit;
    }
}
