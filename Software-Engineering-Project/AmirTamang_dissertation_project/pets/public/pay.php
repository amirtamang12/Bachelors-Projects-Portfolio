<?php
session_start();
$hostname = 'db';
$username = 'admin1';
$password = 'password';
$dbname = 'pets';
$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

if (isset($_POST['pay_now'])) { //check for submission of pay now button

    // adding payment info to database
    $payment_status = "Completed"; //payment status variable
    $user_id = $_SESSION['user_id']; // Get the user's ID

    try {
        // prepare the SQL INSERT statement
        $stmt = $pdo->prepare('INSERT INTO tbl_payment (payment_for, amount_paid, remarks, payment_status, paid_by, user_id)
        VALUES (:payment_for, :amount_paid, :remarks, :payment_status, :paid_by, :user_id)');

        $stmt->bindParam(':payment_for', $_POST['payment_for']);
        $stmt->bindParam(':amount_paid', $_POST['amount_paid']);
        $stmt->bindParam(':remarks', $_POST['remarks']);
        $stmt->bindParam(':payment_status', $payment_status);
        $stmt->bindParam(':paid_by', $_POST['paid_by']);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();
        header('Location: billing.php');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PET STORE - Payment </title>
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
                    echo '<a href="profile.php" class="nav-item nav-link"><i class="bi bi-person"></i> My Account</a>';
                } else {
                    // If not logged in, display the "My Account" link leading to the login page
                    echo '<a href="login.php" class="nav-item nav-link"><i class="bi bi-person"></i> My Account</a>';
                }
                ?>
                <a href="cart.php" class="nav-item nav-link nav-contact bg-primary text-white px-5 ms-lg-5"><i class="bi bi-cart"></i> My Cart</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Payment Page Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h1 class="text-primary text-uppercase">Payment</h1>
            </div>

            <div class="row g-5">
                <div class="col-lg-7">

                    <!-- Payment Form -->
                    <form action="pay.php" method="POST">
                        <div class="row g-3">
                            <!-- *************************************************************** -->
                            <h2 class="text-primary mt-4">Payment Information</h2>
                            <div class="col-12">
                                <label for="payment_for" class="form-label">Payment For:</label>
                                <input type="text" class="form-control" name="payment_for" required>
                            </div>

                            <div class="col-12">
                                <label for="paid_by" class="form-label">Paid By:</label>
                                <input type="text" class="form-control" name="paid_by" required>
                            </div>

                            <div class="col-12">
                                <label for="amount_paid" class="form-label">Amount</label>
                                <input type="text" class="form-control" name="amount_paid" required>
                            </div>

                            <div class="col-12">
                                <label for="remarks" class="form-label">Remarks</label>
                                <input type="text" class="form-control" name="r" required>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="pay_now">Pay Now</button>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Cash on Delivery</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- QR Code Section -->

                <div class="col-lg-5">

                    <h2 class="text-primary mt-4">Pay by card</h2>
                    <div class="col-12">
                        <label for="card_number" class="form-label">Card Number</label>
                        <input type="text" class="form-control" id="card_number" name="card_number" required>
                    </div>

                    <div class="col-12">
                        <label for="expiration_date" class="form-label">Expiration Date</label>
                        <input type="text" class="form-control" id="expiration_date" name="expiration_date" placeholder="MM/YYYY" required>
                    </div>

                    <div class="col-12">
                        <label for="cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" required>
                    </div>

                    <div class="col-12">
                        <label for="postal_code" class="form-label">Postal Code</label>
                        <input type="text" class="form-control" name="postal_code" required>
                    </div>

                    <div class="d-flex align-items-center mb-2 mt-4">
                        <div class="text-start">
                            <h1 class="text-primary text-uppercase">OR</h1>
                            <h2 class="text-primary mt-4">Scan this to pay</h2>
                            <p>Make sure to put your Name and Contact number on remarks.</p>
                            <div> <img src="/img/qrCode.jpg" width="300px" ;></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Payment Page End -->



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
                    <a class="text-body" href="terms_conditions.php">Terms & Conditions</a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

</body>

</html>