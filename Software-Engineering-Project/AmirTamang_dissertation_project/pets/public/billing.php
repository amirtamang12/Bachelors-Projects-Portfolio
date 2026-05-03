<?php
session_start();
$hostname = 'db';
$username = 'admin1';
$password = 'password';
$dbname = 'pets';
$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

// display invoice number *************************************************************
$date = date('Y-m-d'); // get the current date
$invoice = ''; // invoice variable

try {
    //query for selecting payment id and paid by in decending order limiting only 1 record.
    $stmt = $pdo->prepare('SELECT paid_by, payment_id FROM tbl_payment ORDER BY paid_by, payment_id DESC LIMIT 1');
    $stmt->execute(); //execute the query
    //variable assigned to fetch all the results
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage()); // handle exceptions and display error messeage if there is an error.
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PET STORE - Billing </title>
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
    <style>
        /* Table styles for screen */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }

        /* Table styles for print */
        @media print {
            table {
                border-collapse: collapse;
                width: 100%;
                page-break-inside: auto;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 8px;
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>

<body>

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

        <!-- billing start  -->
        <!-- billing end -->
        <div class="container-fluid pt-5">
            <div class="container">
                <div class="card">
                    <div class="card-body mx-4">
                        <div class="container">
                            <ul class="list-unstyled">
                                <li class="text-black mt-1">Date: <?= $date ?></li>
                                <li class="text-black">Name: <?= $payment['paid_by']; ?></li>
                                <li class="text-muted mt-1"><span class="text-black">Invoice: </span><?= $payment['payment_id']; ?></li>
                            </ul>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totalPrice = 0; // total price variable
                                    // loop and display cart items
                                    foreach ($_SESSION['cart'] as $cart_item) {
                                        $item_id = $cart_item['item_id']; //get the item ID form the cart item
                                        $item_name = $cart_item['item_name'];
                                        $item_price = $cart_item['item_price'];
                                        $quantity = $cart_item['quantity'];
                                        $total = $item_price * $quantity; //calculate the total price

                                        $totalPrice += $total; // add the item total price to final total price.

                                        // display the item information
                                        echo "<tr>";//start table
                                        echo "<td>{$item_name}</td>"; // get the item id from the cart item
                                        echo "<td>{$quantity}</td>";
                                        echo "<td>{$item_price}</td>";
                                        echo "</tr>"; // end table
                                    }
                                    ?>
                                    <!-- Display the total row -->
                                    <tr>
                                        <th>Total</th>
                                        <td></td>
                                        <td><?= $totalPrice ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="text-center my-5 mx-5" style="font-size: 30px;">Thank for your purchase!</p>

                            <div class="text-center mt-4">
                                <button class="btn btn-primary" onclick="printBill()">Save/Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>

        <script>
            // Function to print the bill
            function printBill() {
                const printWindow = window.open('', '', 'width=800,height=600');

                printWindow.document.write('<html><head><title>Payment Details</title></head><body>');
                printWindow.document.write('<h2>Payment Details</h2>');

                // Print only the payment details table
                const tableContent = document.querySelector('table').outerHTML;
                printWindow.document.write(tableContent);

                printWindow.document.write('</body></html>');
                printWindow.document.close();

                // Delay the print action by a few milliseconds
                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                }, 100); // You can adjust the delay as needed
            }
        </script>

    </body>

</html>