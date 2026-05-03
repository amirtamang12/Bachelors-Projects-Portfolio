<?php
session_start();
$hostname = 'db';
$username = 'admin1';
$password = 'password';
$dbname = 'pets';
$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

// check if the user is signed in********************************************************
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // redirect the user to the registration page
    header("Location: register.php");
    exit();
}

// for calculating items in the cart********************************************************
$total_price = 0; // variable for total price
$total_items = 0; //variable for total items

if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    //check is the cart session is set and is an array
    foreach ($_SESSION['cart'] as $cart_item) {
        $pet_price = $cart_item['item_price']; //get the item price
        $quantity = $cart_item['quantity'];
        $subtotal = intval($pet_price) * intval($quantity); //calculate the subtotal for the item
        $total_items += $quantity; // update the total number of items
        $total_price += $subtotal; //update the total price
    }
} else {
    //if the cart is empty or not set, display message
    echo "Your cart is empty. Please add items to your cart.";
}
$total_amount = $total_price; // assign total price to total amount variable 
$number_of_items = $total_items; // assign the total items to number of items

//inserting data to order table**************************************************************
$userID = $_SESSION['user_id']; //get the user id from the session

if (isset($_POST['place_order'])) { //check if the form was submitted
    try {

        //function to generate a random reference number 
        function generateReferenceNumber()
        {
            $timestamp = time();
            $reference_no = 'REF' . $timestamp . rand(1000, 9999);
            return $reference_no;
        }

        $reference_no = generateReferenceNumber(); //generate a unique reference number
        $order_date = date('Y-m-d'); //get the current date
        $expected_delivery_date = date('Y-m-d', strtotime($order_date . ' + 3 days')); // calculate the expected delivery date
        $order_status = 'Processing'; // set the initial order status to 'processing'.

        // Prepare the SQL INSERT statement for adding 
        $stmt = $pdo->prepare('INSERT INTO tbl_order (reference_no, order_date, order_status, expected_delivery_date, total_amount, number_of_items, billing_username, billing_address, user_id)
                               VALUES (:reference_no, :order_date, :order_status, :expected_delivery_date, :total_amount, :number_of_items, :billing_username, :billing_address, :user_id)');

        // Bind parameters
        $stmt->bindParam(':reference_no', $reference_no);
        $stmt->bindParam(':order_date', $order_date);
        $stmt->bindParam(':order_status', $order_status);
        $stmt->bindParam(':expected_delivery_date', $expected_delivery_date);
        $stmt->bindParam(':total_amount', $total_amount);
        $stmt->bindParam(':number_of_items', $number_of_items);
        $stmt->bindParam(':billing_username', $_POST['billing_username']);
        $stmt->bindParam(':billing_address', $_POST['billing_address']);
        $stmt->bindParam(':user_id', $userID);

        // Execute the prepared statement
        $stmt->execute();

        // adding data to order details**********************************************************
        $order_id = $pdo->lastInsertId(); // get the last inserted order id

        foreach ($_SESSION['cart'] as $cart_item) {
            $quantity = $cart_item['quantity'];
            $quantity_price = $cart_item['item_price'];
            $item_name = $cart_item['item_name'];
            $status = 'Processsing';

            $stmt = $pdo->prepare('INSERT INTO tbl_order_detail (order_id, quantity, quantity_price, status, remarks)
                                    VALUES (:order_id, :quantity, :quantity_price, :status, :remarks)');

            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':quantity_price', $quantity_price, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->bindParam(':remarks', $remarks, PDO::PARAM_STR);

            $stmt->execute();
        }

        header("Location: pay.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PET STORE - Checkout </title>
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


    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h1 class="text-primary text-uppercase">Checkout</h1>
            </div>
            <div class="row g-5">
                <div class="col-lg-7">
                    <!-- Cart Summary Table -->
                    <div class="container mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="2">Cart Summary</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Total Items</td>
                                    <td><?php echo $total_items; ?></td>
                                </tr>
                                <tr>
                                    <td>Total Price</td>
                                    <td>Rs.<?php echo $total_price; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row g-5">
                <div class="col-lg-7">

                    <!-- Payment Form -->
                    <form action="checkout.php" method="POST">
                        <div class="row g-3">
                            <h2 class="text-primary text-uppercase">Billing Information</h2>
                            <div class="col-12">
                                <label for="billing_username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="billing_username" required>
                            </div>
                            <div class="col-12">
                                <label for="billing_address" class="form-label">Address</label>
                                <textarea class="form-control" name="billing_address" rows="4" required></textarea>
                            </div>

                            <!-- Proceed to Checkout Buttons -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" name="place_order" class="btn btn-primary me-2">Place your order</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Check out End -->


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