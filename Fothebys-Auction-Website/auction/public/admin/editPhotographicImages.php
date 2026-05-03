<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

if (isset($_POST['update_photographic_image_btn'])) {
    $PhotoID = $_POST['PhotoID'];
    $ImageType = $_POST['ImageType'];
    $HeightInCm = $_POST['HeightInCm'];
    $LengthInCm = $_POST['LengthInCm'];

    // Update query
    $stmt = $pdo->prepare('UPDATE PhotographicImages SET 
        ImageType = :ImageType, 
        HeightInCm = :HeightInCm, 
        LengthInCm = :LengthInCm 
        WHERE PhotoID = :PhotoID');

    // Bind parameters
    $stmt->bindParam(':PhotoID', $PhotoID, PDO::PARAM_INT);
    $stmt->bindParam(':ImageType', $ImageType);
    $stmt->bindParam(':HeightInCm', $HeightInCm);
    $stmt->bindParam(':LengthInCm', $LengthInCm);

    // Execute the update query
    $queryResult = $stmt->execute();

    if ($queryResult) {
        $_SESSION['message'] = 'Photographic Image Successfully Edited!';
        // Redirect to PhotographicImages.php or another appropriate location
        echo '<script>window.location.href = "PhotographicImages.php";</script>';
        exit();
    } else {
        $_SESSION['message'] = 'Error Editing Photographic Image!';
    }
}

if (isset($_GET['id'])) {
    $PhotoID = $_GET['id'];

    // Fetch the photographic image data to pre-populate the form
    $stmt = $pdo->prepare('SELECT p.PhotoID, p.ImageType, p.HeightInCm, p.LengthInCm, i.LotNumber, i.ArtistName FROM PhotographicImages p INNER JOIN Items i ON p.ItemID = i.ItemID WHERE p.PhotoID = :PhotoID');
    $stmt->bindParam(':PhotoID', $PhotoID, PDO::PARAM_INT);
    $stmt->execute();
    $photographicImage = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!-- The rest of your HTML content here -->

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
        <h1>Edit Photographic Image</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="PhotographicImages.php">Photographic Images</a></li>
                <li class="breadcrumb-item active"><a href="editPhotographicImage.php">Edit Photographic Image</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Photographic Image</h5>
                        <p>Edit an existing photographic image with the form below.</p>

                        <!-- Photographic Image Form -->
                        <form action="editPhotographicImages.php" method="POST">
                            <input type="hidden" name="PhotoID" value="<?= $photographicImage['PhotoID'] ?>" />
                            <div class="mb-3">
                                <label for="ItemID" class="form-label">Select Item</label>
                                <input type="text" class="form-control" value="<?= $photographicImage['LotNumber'] ?> - <?= $photographicImage['ArtistName'] ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="ImageType" class="form-label">Image Type</label>
                                <select name="ImageType" class="form-control">
                                    <option value="Potrait" <?= $photographicImage['ImageType'] === 'Potrait' ? 'selected' : '' ?>>Potrait</option>
                                    <option value="Landscape" <?= $photographicImage['ImageType'] === 'Landscape' ? 'selected' : '' ?>>Landscape</option>
                                    <option value="Nature" <?= $photographicImage['ImageType'] === 'Nature' ? 'selected' : '' ?>>Nature</option>
                                    <option value="Culture" <?= $photographicImage['ImageType'] === 'Culture' ? 'selected' : '' ?>>Culture</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="HeightInCm" class="form-label">Height (in cm)</label>
                                <input type="text" name="HeightInCm" class="form-control" value="<?= $photographicImage['HeightInCm'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="LengthInCm" class="form-label">Length (in cm)</label>
                                <input type="text" name="LengthInCm" class="form-control" value="<?= $photographicImage['LengthInCm'] ?>">
                            </div>
                            <button type="submit" class="btn btn-primary" name="update_photographic_image_btn">Update Photographic Image</button>
                        </form>
                        <!-- End Photographic Image Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
include('layouts/footer.php')
?>