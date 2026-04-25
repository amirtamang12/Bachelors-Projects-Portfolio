<?php
// after clicking logout user goes to login page again for logging in
session_start();
unset($_SESSION["login"]);
unset($_SESSION["Email"]);
header("Location:login.php");
?>