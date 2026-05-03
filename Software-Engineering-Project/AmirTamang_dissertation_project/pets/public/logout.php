<?php
session_start();

// check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // unset all session variables
    session_unset();

    // destroy the session
    session_destroy();

    // redirect to the login page
    header("Location: login.php");
    exit();
} else {
    // if the user is not logged in, redirect them to the login page
    header("Location: login.php");
    exit();
}
