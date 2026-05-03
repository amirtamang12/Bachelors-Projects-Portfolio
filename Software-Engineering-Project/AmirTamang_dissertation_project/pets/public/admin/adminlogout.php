<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other page you want after logout
    header("Location: index.php");
    exit();
} else {
    // If the user is not logged in, redirect them to the login page
    header("Location: index.php");
    exit();
}
