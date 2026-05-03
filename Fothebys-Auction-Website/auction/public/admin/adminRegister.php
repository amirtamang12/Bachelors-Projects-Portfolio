<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

if (isset($_POST['save_user_btn'])) {
    // Hash the password
    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert query
    $stmt = $pdo->prepare('INSERT INTO users (username, fullname, email, password, profileImg)
    VALUES (:username, :fullname, :email, :password, :profileImg)');

    $criteria = [
        ':username' => $_POST['username'],
        ':fullname' => $_POST['fullname'],
        ':email' => $_POST['email'],
        ':password' => $hashedPassword, // Use the hashed password
        ':profileImg' => $_FILES['profileImg']['name'],
    ];

    $queryResult = $stmt->execute($criteria);

    if ($queryResult) {
        $_SESSION['message'] = 'Register Successfully Added!';
        // Redirect to users.php using JavaScript
        echo '<script>window.location.href = "users.php";</script>';
    } else {
        $_SESSION['message'] = 'Error Adding User!';
    }

    if ($_FILES['profileImg']['error'] == 0) {
        // Creating the image file name
        $fileName = $pdo->lastInsertId() . '.jpg';
        // Moving the uploaded image to the specified directory
        move_uploaded_file($_FILES['profileImg']['tmp_name'], '../assets/img/' . $fileName);
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
        <h1>Register Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="blogs.php">Users</a></li>
                <li class="breadcrumb-item active"><a href="blogs.php">Add User</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Register Admin</h5>
                        <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to convert to a datatable</p>

                        <!-- Table with stripped rows -->
                        <form action="adminRegister.php" method="POST" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Full Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="fullname" class="form-control" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" name="username" class="form-control" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" class="form-control" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputNumber" class="col-sm-2 col-form-label">Upload Photo</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="profileImg" type="file" id="formFile" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary" name="save_user_btn">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
include('layouts/footer.php');
?>