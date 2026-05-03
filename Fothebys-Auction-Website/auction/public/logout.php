<?php
// Start or resume the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other page you prefer
    header('Location: login.php');
    exit;
} else {
    // If the user is not logged in, you can handle this case as needed,
    // such as redirecting to the login page or displaying a message.
    echo 'You are not logged in.';
}
