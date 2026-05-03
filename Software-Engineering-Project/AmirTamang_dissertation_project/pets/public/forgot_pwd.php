<?php
session_start();
$hostname = 'db';
$username = 'admin1';
$password = 'password';
$dbname = 'pets';
$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

//for forgot password*************************************************************
if (isset($_POST['submit'])) {
    // get the user's email address
    $email = $_POST['email'];

    // check if the email exists in the database
    $stmt = $pdo->prepare('SELECT user_id, email FROM tbl_user WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // generate a unique token
        $token = bin2hex(random_bytes(32));

        // store the token and its expiration date in the database
        $expiration_date = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expires in 1 hour
        $stmt = $pdo->prepare('UPDATE tbl_user SET reset_token = :token, token_expiration = :expiration WHERE user_id = :user_id');
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expiration', $expiration_date);
        $stmt->bindParam(':user_id', $user['user_id']);
        $stmt->execute();

        // Send a password reset email to the user with a link containing the token
        $reset_link = "http://petstore.com/reset_password.php?token=$token";
        $to = $user['email'];
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $reset_link";
        $headers = "From: webmaster@yourwebsite.com";

        mail($to, $subject, $message, $headers);

        // Provide a success message to the user
        $success_message = "A password reset link has been sent to your email address. Please check your inbox.";
    } else {
        // Email not found in the database
        $error_message = "Email not found. Please check your email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PET STORE - Login Page</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <!-- forgot password Start -->
    <div class="container-fluid pt-5 py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h1 class="text-primary text-uppercase">Forgot Password</h1>
            </div>
            <div class="row g-5">
                <div class="col-lg-7">
                    <?php
                    if (isset($success_message)) {
                        echo '<div class="alert alert-success">' . $success_message . '</div>';
                    } elseif (isset($error_message)) {
                        echo '<div class="alert alert-danger">' . $error_message . '</div>';
                    }
                    ?>

                    <form method="post">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- forgot password End -->


        <div class="container-fluid bg-white mt-5 py-5">
            <div class="container pt-5 py-5">
            </div>
        </div>
        <!-- Footer Start -->

        <div class="container-fluid bg-dark text-white-50 py-4">
            <div class="container">
                <div class="row g-5">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-md-0"> &copy; <a class="text-white" href="#">Pet Store 2023. </a> All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>


        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
</body>

</html>