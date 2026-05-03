<?php
session_start(); // session start
//database connection start
$hostname = 'db';
$username = 'admin1';
$password = 'password';
$dbname = 'pets';
$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password); //pdo info to connect to the database
//database connection end
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- title of the page -->
    <title>PET STORE - Home Page</title>
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
        <!-- logo -->
        <a href="index.php" class="navbar-brand ms-lg-5">
            <h1 class="m-0 text-uppercase text-dark"><i class="bi bi-shop fs-1 text-primary me-3"></i>Pet Store</h1>
        </a>
        <!-- hamburger icon -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="index.php" class="nav-item nav-link active">Home</a>
                <a href="store.php" class="nav-item nav-link">Store</a>
                <a href="service.php" class="nav-item nav-link">Services</a>
                <a href="about.php" class="nav-item nav-link">About</a>
                <a href="contact.php" class="nav-item nav-link">Contact</a>
                <?php

                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    // if the user is logged in, display the "My Account" link leading to the profile page
                    echo '<a href="profile.php" class="nav-item nav-link"><i class="bi bi-person"></i> My Account</a>';
                } else {
                    //if the user is not logged in, display the "My Account" link leading to the login page
                    echo '<a href="login.php" class="nav-item nav-link"><i class="bi bi-person"></i> My Account</a>';
                }
                ?>
                <a href="cart.php" class="nav-item nav-link nav-contact bg-primary text-white px-5 ms-lg-5"> <i class="bi bi-cart"></i> My Cart</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Intro Start -->
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-start">
                <div class="col-lg-8 text-center text-lg-start">
                    <h1 class="display-1 text-uppercase text-dark mb-lg-4">Pet Store</h1>
                    <h1>"Bringing Pets and People Closer, Pawsitively!"</h1>
                    <p>Simplifies pet companion search, adoption, and connections.</p>
                    <p>Advice on Pet Feeding, Grooming, and Exercise are given.</p>
                    <a>Aims to a harmonious future for pet owners and their beloved pets.</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Intro End -->

    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded" src="img/about.jpg" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="border-start border-5 border-primary ps-5 mb-5">
                        <h6 class="text-primary text-uppercase">About Us</h6>
                        <h1 class="display-5 text-uppercase mb-0">We always maintain your pets' happiness.</h1>
                    </div>
                    <h4 class="text-body mb-4">Making lives of pets and their owners by offering top-quality products, expert advice, and a compassionate approach to pet care.</h4>
                    <div class="bg-light p-4">
                        <ul class="nav nav-pills justify-content-between mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item w-50" role="presentation">
                                <button class="nav-link text-uppercase w-100 active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">Our Mission</button>
                            </li>
                            <li class="nav-item w-50" role="presentation">
                                <button class="nav-link text-uppercase w-100" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false">Our Vission</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                                <p class="mb-0">The PET STORE offers top-tier pet products, expert guidance on care, and support for
                                    animal welfare. Catering to pet owners and enthusiasts, it ensures pet happiness through quality
                                    supplies, advice, and partnerships with shelters.
                                </p>
                            </div>
                            <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                                <p class="mb-0">Pet Store is to create a caring haven where animals can find devoted owners and owners can
                                    connect with other pet owners. More than just a store, we promote ethical pet ownership by serving as
                                    a center of information, inspiration, and joy. In our ideal world, every pet's wellbeing is valued,
                                    fostering enduring human-animal relationships.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Services Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Services</h6>
                <h1 class="display-5 text-uppercase mb-0">Our Excellent Pet Care Services</h1>
            </div>
            <div class="row g-5">
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-house display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Vaccination</h5>
                            <p>Pet vaccination is a vital preventive measure to protect pets from contagious diseases. It involves administering safe, weakened pathogens to stimulate the immune system and provide immunity against specific illnesses.</p>
                            <a class="text-primary text-uppercase" href="contact.php">Contact Us<i class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-food display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Pet Training</h5>
                            <p>Pet training is a process of teaching animals behaviors, commands, and social skills. It enhances communication between pets and owners, fostering a positive and harmonious relationship while ensuring safety and obedience.</p>
                            <a class="text-primary text-uppercase" href="contact.php">Contact Us<i class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-vaccine display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Pet Treatment</h5>
                            <p>Pet treatment involves addressing health issues, injuries, or illnesses in animals. It encompasses medical care, therapies, and medications to improve their well-being and quality of life.</p>
                            <a class="text-primary text-uppercase" href="contact.php">Contact us<i class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-grooming display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Grooming</h5>
                            <p>Pet grooming enhances pets' well-being through services like bathing, brushing, nail trimming, and fur styling. It promotes cleanliness, health, and a happy appearance, fostering a stronger pet-human bond.</p>
                            <a class="text-primary text-uppercase" href="contact.php">Contact us<i class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!-- Services End -->


        <!-- Offer Start -->
        <div class="container-fluid bg-offer my-5 py-5">
            <div class="container py-5">
                <div class="row gx-5 justify-content-start">
                    <div class="col-lg-7">
                        <div class="border-start border-5 border-dark ps-5 mb-5">
                            <h6 class="text-dark text-uppercase">Special Offer</h6>
                            <h1 class="display-5 text-uppercase text-white mb-0">Save 50% on all items your first order</h1>
                        </div>
                        <p class="text-white mb-4">Explore a world of pet care excellence at the PET STORE! Discover premium products, from
                            nourishing food to engaging toys. Our expert advice ensures your pet's well-being. Join us in supporting animal
                            welfare - a portion of every purchase contributes to shelters and rescue groups. Elevate your pet's life today!</p>
                        <a href="store.php" class="btn btn-light py-md-3 px-md-5 me-3">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Offer End -->

        <!-- Footer Start -->
        <div class="container-fluid bg-light mt-5 py-5">
            <div class="container pt-5">
                <div class="row g-5">
                    <!-- contacts -->
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Get In Touch</h5>
                        <p class="mb-4">We do our best in providing best service for you.</p>
                        <p class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i>Kathmandu, Nepal</p>
                        <p class="mb-2"><i class="bi bi-envelope-open text-primary me-2"></i>petstore@gmail.com</p>
                        <p class="mb-0"><i class="bi bi-telephone text-primary me-2"></i>+01 4490201</p>
                    </div>
                    <!-- top products -->
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Top Products</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-body mb-2" href="store.php"><i class="bi bi-arrow-right text-primary me-2"></i>Toys</a>
                            <a class="text-body mb-2" href="store.php"><i class="bi bi-arrow-right text-primary me-2"></i>Foods and Treats</a>
                            <a class="text-body mb-2" href="store.php"><i class="bi bi-arrow-right text-primary me-2"></i>Collars and Leashes</a>
                        </div>
                    </div>
                    <!-- top services -->
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Top Services</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-body mb-2" href="service.php"><i class="bi bi-arrow-right text-primary me-2"></i>Training</a>
                            <a class="text-body mb-2" href="service.php"><i class="bi bi-arrow-right text-primary me-2"></i>Vaccination</a>
                            <a class="text-body mb-2" href="service.php"><i class="bi bi-arrow-right text-primary me-2"></i>Treatment</a>
                            <a class="text-body" href="service.php"><i class="bi bi-arrow-right text-primary me-2"></i>Grooming</a>
                        </div>
                    </div>
                    <!-- social media links -->
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
                        <a class="text-body" href="privacy_policy.php">Privacy Policy</a>
                        <span class="mx-1">|</span>
                        <a class="text-body" href="contact.php">Customer Support</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="container-fluid bg-dark text-white-50 py-4">
            <div class="container">
                <div class="row g-5">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-md-0"> &copy; <a class="text-white" href="index.php">Pet Store 2023. </a> All Rights Reserved</p>
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