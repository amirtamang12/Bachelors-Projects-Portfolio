<?php
session_start();
$hostname = 'db';
$username = 'admin1';
$password = 'password';
$dbname = 'pets';
$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

// remove item from cart*********************************************************************************
if (isset($_POST['remove_from_cart']) && isset($_POST['remove_item_id'])) {
    $remove_item_id = $_POST['remove_item_id']; //get the item id to remove

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { //check if cart is available and not empty
        foreach ($_SESSION['cart'] as $key => $cart_item) { //loop to check for an item
            if ($cart_item['item_id'] == $remove_item_id) { //if cart items matches the item selected to remove
                // remove the item from the cart
                unset($_SESSION['cart'][$key]);
                break; // exit the loop after removing the item
            }
        }
    }

    // redirect back to cart.php
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PET STORE - My Cart</title>
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

    <!-- pet Cart Start -->
    <div class="container">
        <h1 class="text-primary text-uppercase">Your Cart</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>

                <tr>
                    <?php
                    // check if the cart session exists
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

                        // loop through and display cart items
                        foreach ($_SESSION['cart'] as $cart_item) {
                            $item_id = $cart_item['item_id'];
                            $item_name = $cart_item['item_name'];
                            $item_price = $cart_item['item_price'];
                            $quantity = $cart_item['quantity'];
                            $total = $item_price * $quantity;

                            // identify whether it's a pet or product
                            $item_type = $cart_item['item_type'];

                            // display the item information in a table row
                            echo "<tr>";
                            echo "<td>{$item_name} ($item_type)</td>";
                            echo "<td>{$quantity}</td>";
                            echo "<td>{$item_price}</td>";
                            echo "<td>{$total}</td>";
                            echo "<td>
                    <form action='cart.php' method='post'>
                        <input type='hidden' name='remove_item_id' value='$item_id'>
                        <button type='submit' name='remove_from_cart' class='btn btn-link'>Remove</button>
                    </form>
                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<p>Your cart is empty.</p>";
                    }
                    ?>
                </tr>
            </thead>
        </table>
    </div>

    <div class="container mt-4">
        <!-- script to avoid empty cart proceeding -->
        <script>
            function validateAndProceed() {
                var totalItems = <?php echo $total_items; ?>;
                if (totalItems === 0) {
                    alert('Your cart is empty.');
                    return false;
                }
                return true;
            }
        </script>

        <a href="checkout.php" class="btn btn-primary me-2" onclick="return validateAndProceed()">Proceed to Checkout</a>

        <a href="store.php" class="btn btn-secondary">Continue Shopping</a>
    </div>

    </thead>
    <tbody>
    </tbody>
    </table>
    </div>
    <!-- Cart End -->


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