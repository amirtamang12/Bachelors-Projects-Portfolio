<?php

include 'header.php';
include 'admin/dbconnect.php';

// Initialize the userType variable
$userType = '';

// for user login
if (isset($_POST['Submit'])) {
    // Get user input from the form
    $username = $_POST['userName'];
    $password = $_POST['password'];

    // Check if 'userType' is set in the $_POST array
    if (isset($_POST['userType'])) {
        $userType = $_POST['userType'];
    }

    // Prepare and execute a SQL query to fetch user data based on username and user type
    $stmt = $pdo->prepare('SELECT userId, userName, userType, password FROM User WHERE userName = :userName AND userType = :userType');

    // Bind the parameters
    $stmt->bindParam(':userName', $username);
    $stmt->bindParam(':userType', $userType);

    // Execute the query
    $stmt->execute();

    // Fetch the user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify the entered password against the hashed password in the database
        if (password_verify($password, $user['password'])) {
            // Password is correct
            $_SESSION['userId'] = $user['userId'];
            $_SESSION['userName'] = $user['userName'];
            $_SESSION['userType'] = $user['userType'];
            $_SESSION['loggedin'] = true;

            // Check if the userType is "Admin" and redirect accordingly
            if ($userType === 'Admin') {
                echo '<script>window.location.href = "admin/index.php";</script>';
                exit;
            } else {
                // Redirect to the dashboard or another page for other user types
                echo '<script>window.location.href = "index.php";</script>';
            }
        } else {
            // Password is incorrect
            $error_message = "Invalid username or password.";
        }
    } else {
        // User not found or userType does not match
        $error_message = "Invalid username or userType.";
    }
}

?>

<div class="container">
    <div class="spacer">
        <div class="row register">
            <div class="col-lg-6 col-lg-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 ">
                <form method="post">
                    <input type="text" class="form-control" placeholder="User Name" name="userName">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <!-- User Type Dropdown -->
                    <select class="form-control" name="userType">
                        <option value="Seller">Seller</option>
                        <option value="Buyer">Buyer</option>
                        <option value="Admin">Admin</option>
                    </select>
                    <!-- End User Type Dropdown -->
                    <button type="submit" class="btn btn-success" name="Submit">Log In</button>
                    <a href="register.php" class="btn btn-success" style="margin-top: 10px;">Register</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>