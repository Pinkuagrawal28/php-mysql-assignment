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
    <h1>Step 3</h1>
    <form action="./form?q=3" method="POST" autocomplete="on" enctype="multipart/form-data">
  <label for="marks">Enter Marks like English|80 in separate lines:</label>
  <textarea id="marks" name="marks" rows="10" cols="175" placeholder="English|80" required></textarea>
  <div id="error-message" style="color: red; margin-top: 5px;"></div>
<button type="submit" name="submit">Next</button>
</form>
    <?php require_once BASE_PATH . '/app/components/footer.component.php'; ?>
</body>
</html>
</body>
</html>