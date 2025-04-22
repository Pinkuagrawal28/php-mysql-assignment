<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once BASE_PATH . '/app/components/metadata.component.php'; ?>
  <title>Home</title>
</head>
<body>
    <?php require_once BASE_PATH . '/app/components/header.component.php'; ?>
    <h1>Forgot Your Password</h1>
    <form action="/sendresetlink" method="POST" name="recover_psw">
        <div class="">
            <label for="email_address" class="">E-Mail Address</label>
              <div class="">
                <input type="text" id="email_address" class="form-control" name="usermail" required autofocus>
              </div>
        </div>

        <div class="">
            <input type="submit" value="Recover" name="recover">
        </div>
    </form>
    <div id="message"></div>
    <a href="/login">Go Back to Login</a>
    <a href="/register">Go Back to SignUp</a>
    <?php require_once BASE_PATH . '/app/components/footer.component.php'; ?>
</body>
</html>
