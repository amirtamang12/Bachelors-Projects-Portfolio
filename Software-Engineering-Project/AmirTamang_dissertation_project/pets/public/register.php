<?php
session_start();
$hostname = 'db';
$username = 'admin1';
$password = 'password';
$dbname = 'pets';
$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

// registration start*****************************************************************************
if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $username = $_POST['username'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    // Check if passwords match
    if ($password !== $repassword) {
        echo '<script>alert("Passwords do not match.")</script>';
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare('INSERT INTO tbl_user (username, password, repassword, contact, email) 
        VALUES (:username, :password, :repassword, :contact, :email)');
        $criteria = [
            ':username' => $username,
            ':password' => $hashedPassword,
            ':repassword' => $repassword,
            ':email' => $email,
            ':contact' => $contact,
        ];

        if ($stmt->execute($criteria)) {
            echo '<script>alert("New account created.")</script>';
            echo '<script>window.location.replace("login.php")</script>';
        } else {
            echo '<script>alert("An error occurred")</script>';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PET STORE - Register</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Bootstrap CSS -->

</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm py-3 py-lg-0 px-3 px-lg-0">
        <a href="index.php" class="navbar-brand ms-lg-5">
            <h1 class="m-0 text-uppercase text-dark"><i class="bi bi-shop fs-1 text-primary me-3"></i>Pet Store</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="store.php" class="nav-item nav-link">Store</a>
                <a href="service.php" class="nav-item nav-link">Services</a>
                <a href="about.php" class="nav-item nav-link">About</a>
                <a href="contact.php" class="nav-item nav-link">Contact</a>
                <?php
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    // If the user is logged in, display the "My Account" link leading to the profile page
                    echo '<a href="profile.php" class="nav-item nav-link active"><i class="bi bi-person"></i> My Account</a>';
                } else {
                    // If not logged in, display the "My Account" link leading to the login page
                    echo '<a href="login.php" class="nav-item nav-link active"><i class="bi bi-person"></i> My Account</a>';
                }
                ?>
                <a href="cart.php" class="nav-item nav-link nav-contact bg-primary text-white px-5 ms-lg-5"><i class="bi bi-cart"></i> My Cart</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Sign Up Start -->

    <div class="container-fluid pt-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h1 class="text-primary text-uppercase">Sign Up</h1>
            </div>
            <div class="row g-5">
                <div class="col-lg-7">
                    <form action="register.php" method="post">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label select-label">Full Name:</label>
                                <input type="text" name="username" class="form-control bg-light border-0 px-4" placeholder="Your Name" style="height: 55px;">
                            </div>

                            <div class="col-12">
                                <label class="form-label select-label">Email:</label>
                                <input type="email" name="email" class="form-control bg-light border-0 px-4" placeholder="Your Email" style="height: 55px;">
                            </div>

                            <div class="col-12">
                                <label class="form-label select-label">Contact</label>
                                <input type="int" name="contact" class="form-control bg-light border-0 px-4" placeholder="Your Contact Number" style="height: 55px;">
                            </div>

                            <!-- js for making password visible  -->
                            <script>
                                function togglePasswordVisibility(inputId) {
                                    var passwordInput = document.getElementById(inputId);
                                    if (passwordInput.type === "password") {
                                        passwordInput.type = "text"; // Make password visible
                                    } else {
                                        passwordInput.type = "password"; // Make password invisible
                                    }
                                }
                            </script>
                            <div class="col-12">
                                <label class="form-label select-label">Password:</label>
                                <input type="password" id="password" name="password" class="form-control bg-light border-0 px-4" placeholder="Enter a Password" style="height: 55px;">
                                <br>
                                <input type="checkbox" id="toggleCheckbox1" onchange="togglePasswordVisibility('password')">
                                <label for="toggleCheckbox1">Show Password</label>
                            </div>


                            <div class="col-12">
                                <label class="form-label select-label">Re-Enter Password:</label>
                                <input type="password" id="rePassword" name="repassword" class="form-control bg-light border-0 px-4" placeholder="Confirm your Password" style="height: 55px;">
                                <br>
                                <input type="checkbox" id="toggleCheckbox2" onchange="togglePasswordVisibility('rePassword')">
                                <label for="toggleCheckbox2">Show Re-enter Password</label>
                            </div>

                            <div class="form-check d-flex justify-content-start mb-4 pb-3">
                                <input class="form-check-input me-3" type="checkbox" value="" id="form2Example3c" />
                                <label class="form-check-label text-black" for="form2Example3">
                                    I do accept the <a href="terms_conditions.php"><u>Terms and Conditions</u></a> of your
                                    site.
                                </label>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" name="submit" type="submit">Register</button>
                            </div>

                            <p class="text-center text-muted mt-5 mb-0">Already have an account? <a href="login.php" class="fw-bold text-body"><u>Login here</u></a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sign Up End -->


        <!-- Footer Start -->
        <div class="container-fluid bg-light mt-5 py-5">
            <div class="container pt-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Get In Touch</h5>
                        <p class="mb-4">We do our best in providing best service for you.</p>
                        <p class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i>Kathmandu, Nepal</p>
                        <p class="mb-2"><i class="bi bi-envelope-open text-primary me-2"></i>petstore@gmail.com</p>
                        <p class="mb-0"><i class="bi bi-telephone text-primary me-2"></i>+01 4490201</p>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Top Products</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-body mb-2" href="store.php"><i class="bi bi-arrow-right text-primary me-2"></i>Toys</a>
                            <a class="text-body mb-2" href="store.php"><i class="bi bi-arrow-right text-primary me-2"></i>Foods and Treats</a>
                            <a class="text-body" href="store.php"><i class="bi bi-arrow-right text-primary me-2"></i>Collars and Leashes</a>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Top Services</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-body mb-2" href="service.php"><i class="bi bi-arrow-right text-primary me-2"></i>Training</a>
                            <a class="text-body mb-2" href="service.php"><i class="bi bi-arrow-right text-primary me-2"></i>Vaccination</a>
                            <a class="text-body mb-2" href="service.php"><i class="bi bi-arrow-right text-primary me-2"></i>Treatment</a>
                            <a class="text-body" href="service.php"><i class="bi bi-arrow-right text-primary me-2"></i>Grooming</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Follow us</h5>
                        <div class="d-flex">
                            <a class="btn btn-outline-primary btn-square me-2" href="https://twitter.com/amiryonjantmg"><i class="bi bi-twitter"></i></a>
                            <a class="btn btn-outline-primary btn-square me-2" href="https://www.facebook.com/amir.yonjan.tamang.34"><i class="bi bi-facebook"></i></a>
                            <a class="btn btn-outline-primary btn-square" href="https://www.instagram.com/amir.yonjan.tamang/"><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>
                    <div class="col-12 text-center text-body">
                        <a class="text-body" href="">Terms & Conditions</a>
                        <span class="mx-1">|</span>
                        <a class="text-body" href="">Privacy Policy</a>
                        <span class="mx-1">|</span>
                        <a class="text-body" href="">Customer Support</a>
                        <span class="mx-1">|</span>
                        <a class="text-body" href="">Payments</a>
                        <span class="mx-1">|</span>
                        <a class="text-body" href="">Help</a>
                        <span class="mx-1">|</span>
                        <a class="text-body" href="">FAQs</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-dark text-white-50 py-4">
            <div class="container">
                <div class="row g-5">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-md-0"> &copy; <a class="text-white">Pet Store 2023. </a> All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

        <!-- Bootstrap JavaScript and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>