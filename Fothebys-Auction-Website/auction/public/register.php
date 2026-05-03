<?php
include 'header.php';
include 'admin/dbconnect.php';

// Registration start
if (isset($_POST['Submit'])) {
  $fullName = $_POST['fullName'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];
  $userName = $_POST['userName'];
  $email = $_POST['email'];
  $userType = $_POST['userType']; // Updated to retrieve the selected user type

  // Check if passwords match
  if ($password !== $confirmPassword) {
    echo '<script>alert("Passwords do not match.")</script>';
  } else {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Update the SQL query to use the correct table name and database name
    $stmt = $pdo->prepare('INSERT INTO User (fullName, userName, password, confirmPassword, email, userType) 
VALUES (:fullName, :userName, :password, :confirmPassword, :email, :userType)');
    $criteria = [
      ':fullName' => $fullName,
      ':userName' => $userName,
      ':password' => $hashedPassword,
      ':confirmPassword' => $confirmPassword,
      ':email' => $email,
      ':userType' => $userType, // Use the selected user type
    ];

    if ($stmt->execute($criteria)) {
      echo '<script>alert("New account created.")</script>';
      // Redirect to the login page
      echo '<script>window.location.href = "login.php";</script>';
      exit();
    } else {
      echo '<script>alert("An error occurred")</script>';
    }
  }
}
?>
<!-- banner -->
<div class="inside-banner">
  <div class="container">
    <span class="pull-right"><a href="#">Home</a> / Register</span>
    <h2>Register</h2>
  </div>
</div>
<!-- banner -->

<div class="container">
  <div class="spacer">
    <div class="row register">
      <div class="col-lg-6 col-lg-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 ">
        <form method="post">
          <input type="text" class="form-control" placeholder="Full Name" name="fullName">
          <input type="text" class="form-control" placeholder="User Name" name="userName">
          <input type="text" class="form-control" placeholder="Enter Email" name="email">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <input type="password" class="form-control" placeholder="Confirm Password" name="confirmPassword">
          <!-- User Type Dropdown -->
          <select class="form-control" name="userType">
            <option value="Seller">Seller</option>
            <option value="Buyer">Buyer</option>
          </select>
          <!-- End User Type Dropdown -->
          <button type="submit" class="btn btn-success" name="Submit">Register</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>