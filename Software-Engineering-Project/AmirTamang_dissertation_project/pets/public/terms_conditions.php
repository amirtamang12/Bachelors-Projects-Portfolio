<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PET STORE - Terms and Conditions </title>
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


    <!-- Log in Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h1 class="text-primary text-uppercase">Pet Store - Terms and Conditions</h1>
            </div>
            <div class="row g-5">
                <div class="col-lg-7">
                    <a>
                        Last Updated: [September 24, 2023]<br><br>

                        These Terms and Conditions govern your use of the products, services, and website provided by us. By accessing, browsing, or using our website or purchasing products from us, you agree to comply with and be bound by these Terms. If you do not agree with these Terms, please do not use our services or website.<br><br>

                        1. <u>Product Availability and Description</u><br><br>
                        - We make every effort to ensure the accuracy of product descriptions and availability on our website. However, product availability may vary, and descriptions are provided for informational purposes only.<br><br>


                        2. <u>Ordering and Payment</u><br><br>
                        - Orders are subject to acceptance by us, and we reserve the right to cancel or refuse any order at our discretion.<br>
                        - You agree to provide accurate and up-to-date payment information. You are responsible for any charges incurred through your use of our website and services.<br><br>


                        3. <u>Pricing</u><br><br>
                        - Prices for products are listed in your local currency and are subject to change without notice.<br>
                        - We make every effort to display accurate pricing, but errors may occur. In the event of an error, we reserve the right to correct the price and will notify you before processing your order.<br><br>

                        4. <u>Shipping and Delivery</u><br><br>
                        - Shipping and delivery options, times, and costs are outlined in our Shipping Policy. By placing an order, you agree to the terms of our Shipping Policy.<br><br>


                        5. <u>Returns and Refunds</u><br>
                        - Our Returns and Refunds Policy outlines the procedures for returns and refunds. By making a purchase, you agree to adhere to these policies.<br><br>


                        6. <u>Privacy</u><br><br>
                        - We value your privacy and handle your personal information according to our Privacy Policy.<br><br>

                        7. <u>User Accounts</u><br><br>
                        - If you create an account on our website, you are responsible for maintaining the confidentiality of your account information and password. You agree to notify us immediately of any unauthorized access or use of your account.<br><br>

                        8. <u>Property</u><br><br>
                        - All content on our website, including text, images, logos, and trademarks, is our intellectual property and may not be used without our express consent.<br><br>

                        9. <u>Limitation of Liability</u><br><br>
                        - We are not liable for any direct, indirect, incidental, special, or consequential damages resulting from your use of our products or services.<br><br>

                        10. <u>Governing Law</u><br><br>
                        - These Terms are governed by and construed in accordance with the laws of Pet Store, without regard to conflicts of law principles.<br><br>

                        11. <u>Changes to Terms</u><br><br>
                        - We reserve the right to modify these Terms at any time. Updated Terms will be posted on our website, and your continued use of our services constitutes acceptance of the modified Terms.<br><br>

                        12. <u>Contact Information</u><br><br>
                        - For questions or concerns regarding these Terms and Conditions, please contact us at by clicking on our contact page or contact information is given at the end of the webpage.<br><br>

                        By using our website and services, you acknowledge that you have read, understood, and agreed to these Terms and Conditions. Thank you for choosing Pet Store.
                    </a>
                </div>
            </div>
        </div>
        <!-- Log in End -->


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