<?php
session_start(); // Start the session
//this code section is for connecting the database
$hostname = 'db';
$username = 'admin1';
$password = 'password';
$dbname = 'pets';
$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

// for login**********************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email === "amir.yonjan12@gmail.com" && $password === "123456") {
        // User found, set session variables or perform other actions
        $_SESSION['user_id'] = 1; // You can set a user ID here if needed
        $_SESSION['email'] = $email;

        // Redirect to the dashboard or another page
        header('Location: client/dashboard.php');
        exit();
    } else {
        // User not found, display an error message
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Pet Shop Login Form</title>

    <!-- Icons font CSS-->
    <link href="Login and Register/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="Login and Register/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="Login and Register/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="Login and Register/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="Login and Register/css/main.css" rel="stylesheet" media="all">
</head>
<style type="text/css">
    .bg-gra-02 {
        background: -webkit-gradient(linear, left bottom, right top, from(#fc2c77), to(#6c4079));
        background: -webkit-linear-gradient(bottom left, #fc2c77 0%, #6c4079 100%);
        background: -moz-linear-gradient(bottom left, #fc2c77 0%, #6c4079 100%);
        background: -o-linear-gradient(bottom left, #fc2c77 0%, #6c4079 100%);
        background: linear-gradient(to top right, #e2e0e1 0%, #eee3f1 100%);
    }
</style>

<body style="background: linear-gradient(to top right, #f9f5f5 0%, #ad93b5 100%);">
    <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Login Form</h2>
                    <form method="POST" action="">
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Email</label>
                                    <input class="input--style-4" type="email" name="email">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">password</label>
                                    <input class="input--style-4" type="password" name="password">
                                </div>
                            </div>
                        </div>
                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" type="submit">Submit</button>
                        </div>
                    </form>
                    <?php
                    if (isset($error_message)) {
                        echo '<p style="color: red;">' . $error_message . '</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="Login and Register/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="Login and Register/vendor/select2/select2.min.js"></script>
    <script src="Login and Register/vendor/datepicker/moment.min.js"></script>
    <script src="Login and Register/vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="Login and Register/js/global.js"></script>

</body>

</html>
<!-- end document-->