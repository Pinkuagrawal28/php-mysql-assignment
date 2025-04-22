<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once BASE_PATH . '/app/components/metadata.component.php'; ?>
  <title>Home</title>
</head>
<html>
<body>
    <?php require_once BASE_PATH . '/app/components/header.component.php'; ?>
    <h1>Step 1</h1>
    <form action="/form?q=1" method="POST" autocomplete="on" enctype="multipart/form-data">
    <label for="fname">First name:</label>
    <input type="text" id="fname" name="fname" value="" maxlength="10" placeholder="John" required autofocus oninput="updateFullName()">
    <div id="fname-error" style="color: red; margin-bottom: 10px;"></div>

    <label for="lname">Last name:</label>
    <input type="text" id="lname" name="lname" value="" maxlength="10" placeholder="Doe" required oninput="updateFullName()">
    <div id="lname-error" style="color: red; margin-bottom: 10px;"></div>

    <label for="name">Full name:</label>
    <input type="text" id="name" name="name" value="" readonly="readonly" placeholder="John Doe">
    <button type="submit" name="topage2">Next</button>
  </form>
    <?php require_once BASE_PATH . '/app/components/footer.component.php'; ?>

    <script>
    // JavaScript function to update the full name
    function updateFullName() {
      const firstName = document.getElementById("fname").value;
      const lastName = document.getElementById("lname").value;
      const fullName = firstName + " " + lastName;
      document.getElementById("name").value = fullName;
    }
  </script>
</body>
</html>