<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

if (isset($_POST['save_user_btn'])) {
    $userName = $_POST['userName'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $confirmPassword = password_hash($_POST['confirmPassword'], PASSWORD_DEFAULT);
    $userType = $_POST['userType'];

    // Insert query
    $stmt = $pdo->prepare('INSERT INTO User (userName, fullName, email, password, confirmPassword, userType)
    VALUES (:userName, :fullName, :email, :password, :confirmPassword, :userType)');

    // Bind parameters
    $stmt->bindParam(':userName', $userName);
    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':confirmPassword', $confirmPassword);
    $stmt->bindParam(':userType', $userType);

    // Execute the insert query
    $queryResult = $stmt->execute();

    if ($queryResult) {
        $_SESSION['message'] = 'User Successfully Added!';
        // Redirect to the appropriate location
        echo '<script>window.location.href = "viewUser.php";</script>';
    } else {
        $_SESSION['message'] = 'Error Adding User!';
    }
}
?>

<!-- The rest of your HTML content goes here -->

<main id="main" class="main">
    <?php echo $alertMessage; ?>
    <!-- JavaScript to automatically close the alert after a delay -->
    <script>
        // Function to close the alert after a delay
        function closeAlert() {
            var alert = document.querySelector('.alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }

        // Automatically close the alert after 3 seconds
        setTimeout(closeAlert, 3000);
    </script>
    <div class="pagetitle">
        <h1>Add User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="Users.php">Users</a></li>
                <li class="breadcrumb-item active"><a href="addUser.php">Add User</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add User</h5>
                        <p>Add a new user with the form below.</p>

                        <!-- User Form -->
                        <form action="addUser.php" method="POST">
                            <div class="mb-3">
                                <label for="userName" class="form-label">Username</label>
                                <input type="text" name="userName" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" name="fullName" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" name="confirmPassword" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="userType" class="form-label">User Type</label>
                                <select name="userType" class="form-control">
                                    <option value="" disabled selected>Select User Type</option>
                                    <option value="seller">Seller</option>
                                    <option value="buyer">Buyer</option>
                                    <option value="admin">Admin</option>
                                    <option value="buyer_and_seller">Buyer & Seller</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="save_user_btn">Save User</button>
                        </form>
                        <!-- End User Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
include('layouts/footer.php')
?>