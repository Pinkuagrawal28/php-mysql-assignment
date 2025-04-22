<header>
  Form Gen
  <?php

      if (isset($_SESSION['username'])) {
          echo "Welcome, " . $_SESSION['username'] . "!";
      } else {
          echo '<a href="/login">Login</a>';
      }
  ?>
<?php require_once BASE_PATH . '/app/components/logout.component.php'; ?>
  <hr>
</header>
