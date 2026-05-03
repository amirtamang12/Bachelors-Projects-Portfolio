<?php
session_start();
$hostname = 'db';
$username = 'admin1';
$password = 'password';
$dbname = 'pets';
$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

// adding pet to cart*******************************************************
if (isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    $item_type = $_POST['item_type'];

    // initialize the cart session array if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // check if the item is already in the cart
    $item_exists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['item_id'] === $item_id && $item['item_type'] === $item_type) {
            // Item already in cart, increase quantity
            $item['quantity'] += 1;
            $item_exists = true;
            break;
        }
    }

    if (!$item_exists) {
        // item not in cart, add it as a new item
        $cart_item = array(
            'item_id' => $item_id,
            'item_name' => $item_name,
            'item_price' => $item_price,
            'item_type' => $item_type, // identify whether it's a pet or product
            'quantity' => 1, // initial quantity is 1
        );
        $_SESSION['cart'][] = $cart_item;
    }

    // redirect back to store.php
    header("Location: store.php");
    exit();
}

// displaying pets***************************************************************************************
try {
    $stmt = $pdo->prepare('SELECT * FROM tbl_pet');
    $stmt->execute();
    $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// for search*********************************************************************************************
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];

    // Filter the pets based on the search query
    $filteredPets = array_filter($pets, function ($pet) use ($searchQuery) {
        return stristr($pet['pet_name'], $searchQuery) !== false;
    });
    if (empty($filteredPets)) {
        $noResultsMessage = "No results found.";
    }
} else {
    // Display all pets by default
    $filteredPets = $pets;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PET STORE - Store</title>
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
                <a href="store.php" class="nav-item nav-link active">Store</a>
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

    <!-- Search Start -->
    <div class="container py-5">
        <form method="POST" action="">
            <input class="form-control" id="myInput" type="text" name="search" placeholder="Search..">
            <button type="submit" class="btn btn-primary py-2 px-3">Search</button>
            <!-- <button class="btn">Advanced Search</button> -->
        </form>
    </div>
    <!-- Output even there are small or capital letters, when searching -->
    <script>
        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myDIV *").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    <!-- Search End -->

    <!-- Category -->
    <div class="container-fluid py-5">
        <div class="container">
            <a>BUY</a>
            <li><a href="store.php">Pet</a></li>
            <li><a href="buy_product.php">Product for pet</a></li>
        </div>
    </div>

    <!-- Pets Start -->
    <div class="container-fluid py-5">
        <!-- Displaying Pet Images -->
        <div class="container">

            <div class="row">
                <?php if (isset($noResultsMessage)) : ?>
                    <div class="col-12">
                        <p><?php echo $noResultsMessage; ?></p>
                    </div>
                <?php else : ?>
                    <?php foreach ($filteredPets as $pet) : ?>
                        <!-- Your existing code to display each pet -->
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="product-item position-relative bg-light d-flex flex-column text-center">
                                <div>
                                    <img src="<?= $pet['pet_images']; ?>" alt="<?= $pet['pet_name']; ?>" class="img-fluid" style="max-height: 120px">
                                </div>
                                <h6 class="text-uppercase"><?= $pet['pet_name']; ?></h6>
                                <h5 class="text-primary mb-0">Rs.<?= $pet['pet_price']; ?></h5>
                                <div class="btn-action d-flex justify-content-center">
                                    <form action="store.php" method="post">
                                        <input type="hidden" name="item_id" value="<?= $pet['pet_id']; ?>">
                                        <input type="hidden" name="item_name" value="<?= $pet['pet_name']; ?>">
                                        <input type="hidden" name="item_price" value="<?= $pet['pet_price']; ?>">
                                        <input type="hidden" name="item_type" value="Pet">
                                        <button type="submit" class="btn btn-primary py-2 px-3" name="add_to_cart">
                                            <i class="bi bi-cart"></i> Add to Cart
                                        </button>
                                    </form>
                                    <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>



            </div>


        </div>
    </div>
    <!-- Pets End -->



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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>