<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');
$users = $pdo->query('SELECT * FROM admin ');
$userData = $users->fetchAll(PDO::FETCH_ASSOC);

?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>User Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="users.php">User</a></li>
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
                        <h5 class="card-title">User Table</h5>
                        <p>Add users</p>
                        <a href="adminRegister.php"><button type="button" class="btn btn-success">Add User</button></a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">User Image</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($userData as $user) {

                                    echo '<tr>';
                                    echo '<td><img src="assets/img/user/' . $user['profileImg'] . '" /></a></td>';
                                    echo '<td>' . $user['username'] . '</td>';
                                    echo '<td>' . $user['email'] . '</td>';
                                    echo '<td>';
                                    echo '<a href="editUser.php?id=' . $user['userId'] . '" class="btn btn-primary">Edit User</a>';
                                    echo '<form method="post" action="deleteUser.php" style="display: inline;">
                                        <input type="hidden" name="id" value="' . $user['userId'] . '" />
                                        <button type="submit" name="delete_user" value="' . $user['userId'] . '" class="btn btn-danger">Delete</button>
                                    </form>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
include('layouts/footer.php')
?>
<script>
    // Automatically hide the alert message after 3 seconds
    setTimeout(function() {
        document.querySelector('.alert').style.display = 'none';
    }, 3000);
</script>