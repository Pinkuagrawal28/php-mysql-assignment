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
    <h1>Step 4</h1>
    <form action="./form?q=4" method="POST" autocomplete="on" enctype="multipart/form-data">
<label for="phone">Phone Number with Indian Format +91 :</label>
  <input type="text" id="phone" name="phone" maxlength="13" placeholder="+91 9876543210" required oninput="validatePhone()">
  <div id="phone-error" style="color: red; margin-bottom: 10px;"></div>

  <button type="submit" name="toPage1">Next</button>
</form>
    <?php require_once BASE_PATH . '/app/components/footer.component.php'; ?>
</body>
</html>