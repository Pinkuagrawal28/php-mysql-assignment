<?php

// Check if the user is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    echo '<a href="/logout">Logout</a>'; // Logout link/button
}
?>