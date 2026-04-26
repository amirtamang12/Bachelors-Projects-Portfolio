<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

if (isset($_POST['update_user'])) {
    $userId = $_POST['user_id'];
    $userName = $_POST['user_name'];
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $userType = $_POST['user_type'];

    // Perform the update query
    $stmt = $pdo->prepare('UPDATE User
                           SET userName = :userName, 
                               fullName = :fullName, 
                               email = :email, 
                               userType = :userType 
                           WHERE userId = :userId');

    $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
    $stmt->bindParam(':fullName', $fullName, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':userType', $userType, PDO::PARAM_STR);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'User updated successfully.';
        header('Location: viewUser.php');
        exit();
    } else {
        $_SESSION['message'] = 'Error updating user.';
        header('Location: editUser.php?id=' . $userId);
        exit();
    }
} else {
    // Check if a user ID is provided
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];

        // Fetch the user information
        $stmt = $pdo->prepare('SELECT * FROM User WHERE userId = :userId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $_SESSION['message'] = 'User not found.';
            header('Location: users.php');
            exit();
        }
    } else {
        $_SESSION['message'] = 'User ID not provided.';
        header('Location: users.php');
        exit();
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item"><a href="users.php">Users</a></li>
                <li class="breadcrumb-item active">Edit User</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <?php if (isset($_SESSION['message'])) {
                    echo ' <h5 class="alert alert-success">' . $_SESSION['message'] . '</h5>';
                    unset($_SESSION['message']); // Clear the session message
                } ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit User</h5>
                        <form action="editUser.php" method="post">
                            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                            <div class="mb-3">
                                <label for="user_name" class="form-label">Username</label>
                                <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $user['userName']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $user['fullName']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="user_type" class="form-label">User Type</label>
                                <select class="form-select" id="user_type" name="user_type">
                                    <option value="seller" <?php if ($user['userType'] === 'seller') echo 'selected'; ?>>Seller</option>
                                    <option value="buyer" <?php if ($user['userType'] === 'buyer') echo 'selected'; ?>>Buyer</option>
                                    <option value="admin" <?php if ($user['userType'] === 'admin') echo 'selected'; ?>>Admin</option>
                                    <option value="buyer_seller" <?php if ($user['userType'] === 'buyer_seller') echo 'selected'; ?>>Buyer & Seller</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="update_user">Update User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include('layouts/footer.php'); ?>
<script>
    // Automatically hide the alert message after 3 seconds
    setTimeout(function() {
        document.querySelector('.alert').style.display = 'none';
    }, 3000);
</script>