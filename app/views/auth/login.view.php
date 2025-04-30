<?php
  // Redirect to homepage if already logged in
  if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    header("Location: home.php"); // Or any page you want
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
<html>
<body>
    <?php require_once BASE_PATH . '/app/components/header.component.php'; ?>
    <h1>Login to the Page</h1>
    <form action="/login" method="POST">
    User Name: <input type="text" name="name"><br>
    Password: <input name="passwd" type="Password"><br>
    <input type="submit">
    </form>
    <a href="/register" title="Register instead">Register</a>
    <a href="/reset" title="Forgot your Password">Forgot Password</a>
    <?php require_once BASE_PATH . '/app/components/footer.component.php'; ?>
</body>
</html>
</body>
</html>