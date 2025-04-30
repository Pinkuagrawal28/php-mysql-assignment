<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once BASE_PATH . '/app/components/metadata.component.php'; ?>
  <title>Home</title>
</head>
<body>
    <?php require_once BASE_PATH . '/app/components/header.component.php'; ?>
    <h1>Register as a New User</h1>
    <form id="registerForm">
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>

    <button type="button" id="sendOtpBtn">Send OTP</button><br>

    <div id="otpSection" style="display: none;">
      <input type="text" name="otp" placeholder="Enter OTP"><br>
      <button type="submit">Verify OTP & Register</button>
    </div>
  </form>

  <p id="message"></p>

    <a href="/login" title="Login instead">Login</a>
    <?php require_once BASE_PATH . '/app/components/footer.component.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
    $('#sendOtpBtn').click(function () {
  $.ajax({
    type: 'POST',
    url: 'otpsend',
    data: $('#registerForm').serialize(),
    success: function (response) {
      $('#message').text(response);
      $('#otpSection').show();
    },
    error: function (xhr, status, error) {
      console.log("OTP send error:", xhr.responseText);
    }
  });
});

$('#registerForm').submit(function (e) {
  e.preventDefault();
  $.ajax({
    type: 'POST',
    url: 'otpverify',
    data: $('#registerForm').serialize(),
    success: function (response) {
      $('#message').text(response);
      if (response.includes('success')) {
        window.location.href = '/login';
      }
    },
    error: function (xhr, status, error) {
      console.log("OTP verify error:", xhr.responseText);
    }
  });
});

  </script>
</body>
</html>