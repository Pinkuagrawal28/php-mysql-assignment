<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    // Unset the session variables
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);

    // Destroy the session
    session_destroy();
    // Redirect to the login page or home page
    header("Location: /login"); // or home.php
    exit();
} else {
    // If not logged in, redirect to login page directly
    header("Location: /login");
    exit();
}
