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
    <h1>Step 2</h1>
    <form action="/form?q=2" method="POST" autocomplete="on" enctype="multipart/form-data">
    <label for="imageUpload">Choose an image:</label>
    <input type="file" id="imageUpload" name="imageUpload" accept="image/*" required>
    <button type="submit" name="submit">Next</button>
    </form>
    <?php require_once BASE_PATH . '/app/components/footer.component.php'; ?>
</body>
</html>
</body>
</html>