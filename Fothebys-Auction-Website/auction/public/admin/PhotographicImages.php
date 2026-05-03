<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

try {
    $stmt = $pdo->prepare('SELECT p.*, i.LotNumber FROM PhotographicImages p
                           LEFT JOIN Items i ON p.ItemID = i.ItemID');
    $stmt->execute();
    $photographicImages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Photographic Images Table</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Photographic Images</li>
                <li class="breadcrumb-item active">Photographic Images Table</li>
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
                        <h5 class="card-title">Photographic Images Table</h5>
                        <p>Add, edit, delete photographic images</p>
                        <a href="addPhotographicImages.php"><button type="button" class="btn btn-success">Add</button></a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Lot Number</th>
                                    <th scope="col">Image Type</th>
                                    <th scope="col">Height (cm)</th>
                                    <th scope="col">Length (cm)</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($photographicImages as $image) {
                                    echo '<tr>';
                                    echo '<td>' . $image['LotNumber'] . '</td>';
                                    echo '<td>' . $image['ImageType'] . '</td>';
                                    echo '<td>' . $image['HeightInCm'] . '</td>';
                                    echo '<td>' . $image['LengthInCm'] . '</td>';
                                    echo '<td>';
                                    echo '<a href="editPhotographicImages.php?id=' . $image['PhotoID'] . '" class="btn btn-primary">Edit</a>';
                                    echo '<form method="post" action="deletePhotographicImages.php" style="display: inline;">
                                        <input type="hidden" name="id" value="' . $image['PhotoID'] . '" />
                                        <button type="submit" name="delete_photo" class="btn btn-danger">Delete</button>
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
include('layouts/footer.php');
?>
<script>
    // Automatically hide the alert message after 3 seconds
    setTimeout(function() {
        document.querySelector('.alert').style.display = 'none';
    }, 3000);
</script>