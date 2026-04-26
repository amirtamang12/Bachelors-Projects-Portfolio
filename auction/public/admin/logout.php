<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other page you want after logout
    header("Location: login.php");
    exit();
} else {
    // If the user is not logged in, redirect them to the login page
    header("Location: login.php");
    exit();
}
