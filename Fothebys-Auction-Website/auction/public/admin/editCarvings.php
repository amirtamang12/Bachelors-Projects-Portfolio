<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

if (isset($_POST['update_carving_btn'])) {
    $ItemID = $_POST['ItemID'];
    $MaterialUsed = $_POST['MaterialUsed'];
    $HeightInCm = $_POST['HeightInCm'];
    $LengthInCm = $_POST['LengthInCm'];
    $WidthInCm = $_POST['WidthInCm'];
    $ApproxWeightInKg = $_POST['ApproxWeightInKg'];

    // Update query
    $stmt = $pdo->prepare('UPDATE Carvings SET 
        MaterialUsed = :MaterialUsed, 
        HeightInCm = :HeightInCm, 
        LengthInCm = :LengthInCm, 
        WidthInCm = :WidthInCm, 
        ApproxWeightInKg = :ApproxWeightInKg 
        WHERE ItemID = :ItemID');

    // Bind parameters
    $stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_INT);
    $stmt->bindParam(':MaterialUsed', $MaterialUsed);
    $stmt->bindParam(':HeightInCm', $HeightInCm);
    $stmt->bindParam(':LengthInCm', $LengthInCm);
    $stmt->bindParam(':WidthInCm', $WidthInCm);
    $stmt->bindParam(':ApproxWeightInKg', $ApproxWeightInKg);

    // Execute the update query
    $queryResult = $stmt->execute();

    if ($queryResult) {
        $_SESSION['message'] = 'Carving Successfully Edited!';
        // Redirect to carvings.php or another appropriate location
        echo '<script>window.location.href = "Carvings.php";</script>';
        exit();
    } else {
        $_SESSION['message'] = 'Error Editing Carving!';
    }
}

if (isset($_GET['id'])) {
    $ItemID = $_GET['id'];

    // Fetch the carving data to pre-populate the form
    $stmt = $pdo->prepare('SELECT c.ItemID, c.MaterialUsed, c.HeightInCm, c.LengthInCm, c.WidthInCm, c.ApproxWeightInKg, i.LotNumber, i.ArtistName FROM Carvings c INNER JOIN Items i ON c.ItemID = i.ItemID WHERE c.ItemID = :ItemID');
    $stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_INT);
    $stmt->execute();
    $carving = $stmt->fetch(PDO::FETCH_ASSOC);
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
        <h1>Edit Carving</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="carvings.php">Carvings</a></li>
                <li class="breadcrumb-item active"><a href="editCarvings.php">Edit Carving</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Carving</h5>
                        <p>Edit an existing carving with the form below.</p>

                        <!-- Carving Form -->
                        <form action="editCarvings.php" method="POST">
                            <div class="mb-3">
                                <label for="ItemID" class="form-label">Select Item</label>
                                <select name="ItemID" class="form-control" disabled>
                                    <option value="<?= $carving['ItemID'] ?>"><?= $carving['LotNumber'] ?> - <?= $carving['ArtistName'] ?></option>
                                </select>
                                <input type="hidden" name="ItemID" value="<?= $carving['ItemID'] ?>" />
                            </div>
                            <div class="mb-3">
                                <label for="MaterialUsed" class="form-label">Carving Material</label>
                                <select name="MaterialUsed" class="form-control">
                                    <option value="Concrete" <?= $carving['MaterialUsed'] === 'Concrete' ? 'selected' : '' ?>>Concrete</option>
                                    <option value="Marble" <?= $carving['MaterialUsed'] === 'Marble' ? 'selected' : '' ?>>Marble</option>
                                    <option value="Wood" <?= $carving['MaterialUsed'] === 'Wood' ? 'selected' : '' ?>>Wood</option>
                                    <option value="Stone" <?= $carving['MaterialUsed'] === 'Stone' ? 'selected' : '' ?>>Stone</option>
                                    <option value="Granite" <?= $carving['MaterialUsed'] === 'Granite' ? 'selected' : '' ?>>Granite</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="HeightInCm" class="form-label">Height (in cm)</label>
                                <input type="text" name="HeightInCm" class="form-control" value="<?= $carving['HeightInCm'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="LengthInCm" class="form-label">Length (in cm)</label>
                                <input type="text" name="LengthInCm" class="form-control" value="<?= $carving['LengthInCm'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="WidthInCm" class="form-label">Width (in cm)</label>
                                <input type="text" name="WidthInCm" class="form-control" value="<?= $carving['WidthInCm'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="ApproxWeightInKg" class="form-label">Approx. Weight (in kg)</label>
                                <input type="text" name="ApproxWeightInKg" class="form-control" value="<?= $carving['ApproxWeightInKg'] ?>">
                            </div>
                            <button type="submit" class="btn btn-primary" name="update_carving_btn">Update Carving</button>
                        </form>
                        <!-- End Carving Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
include('layouts/footer.php')
?>