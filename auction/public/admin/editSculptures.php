<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

if (isset($_POST['update_sculpture_btn'])) {
    $SculptureID = $_POST['SculptureID'];
    $MaterialUsed = $_POST['MaterialUsed'];
    $HeightInCm = $_POST['HeightInCm'];
    $LengthInCm = $_POST['LengthInCm'];
    $WidthInCm = $_POST['WidthInCm'];
    $ApproxWeightInKg = $_POST['ApproxWeightInKg'];

    // Update query
    $stmt = $pdo->prepare('UPDATE Sculptures SET 
        MaterialUsed = :MaterialUsed, 
        HeightInCm = :HeightInCm, 
        LengthInCm = :LengthInCm, 
        WidthInCm = :WidthInCm, 
        ApproxWeightInKg = :ApproxWeightInKg 
        WHERE SculptureID = :SculptureID');

    // Bind parameters
    $stmt->bindParam(':SculptureID', $SculptureID, PDO::PARAM_INT);
    $stmt->bindParam(':MaterialUsed', $MaterialUsed);
    $stmt->bindParam(':HeightInCm', $HeightInCm);
    $stmt->bindParam(':LengthInCm', $LengthInCm);
    $stmt->bindParam(':WidthInCm', $WidthInCm);
    $stmt->bindParam(':ApproxWeightInKg', $ApproxWeightInKg);

    // Execute the update query
    $queryResult = $stmt->execute();

    if ($queryResult) {
        $_SESSION['message'] = 'Sculpture Successfully Edited!';
        // Redirect to Sculptures.php or another appropriate location
        echo '<script>window.location.href = "Sculptures.php";</script>';
        exit();
    } else {
        $_SESSION['message'] = 'Error Editing Sculpture!';
    }
}

if (isset($_GET['id'])) {
    $SculptureID = $_GET['id'];

    // Fetch the sculpture data to pre-populate the form
    $stmt = $pdo->prepare('SELECT s.SculptureID, s.MaterialUsed, s.HeightInCm, s.LengthInCm, s.WidthInCm, s.ApproxWeightInKg, i.LotNumber, i.ArtistName FROM Sculptures s INNER JOIN Items i ON s.ItemID = i.ItemID WHERE s.SculptureID = :SculptureID');
    $stmt->bindParam(':SculptureID', $SculptureID, PDO::PARAM_INT);
    $stmt->execute();
    $sculpture = $stmt->fetch(PDO::FETCH_ASSOC);
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
        <h1>Edit Sculpture</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="Sculptures.php">Sculptures</a></li>
                <li class="breadcrumb-item active"><a href="editSculptures.php">Edit Sculpture</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Sculpture</h5>
                        <p>Edit an existing sculpture with the form below.</p>

                        <!-- Sculpture Form -->
                        <form action="editSculptures.php" method="POST">
                            <input type="hidden" name="SculptureID" value="<?= $sculpture['SculptureID'] ?>" />
                            <div class="mb-3">
                                <label for="ItemID" class="form-label">Select Item</label>
                                <input type="text" class="form-control" value="<?= $sculpture['LotNumber'] ?> - <?= $sculpture['ArtistName'] ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="MaterialUsed" class="form-label">Material Used</label>
                                <select name="MaterialUsed" class="form-control">
                                    <option value="Bronze" <?= $sculpture['MaterialUsed'] === 'Bronze' ? 'selected' : '' ?>>Bronze</option>
                                    <option value="Stone sculpture" <?= $sculpture['MaterialUsed'] === 'Stone sculpture' ? 'selected' : '' ?>>Stone sculpture</option>
                                    <option value="Marble" <?= $sculpture['MaterialUsed'] === 'Marble' ? 'selected' : '' ?>>Marble</option>
                                    <option value="Terracotta" <?= $sculpture['MaterialUsed'] === 'Terracotta' ? 'selected' : '' ?>>Terracotta</option>
                                    <option value="Granite" <?= $sculpture['MaterialUsed'] === 'Granite' ? 'selected' : '' ?>>Granite</option>
                                    <option value="Resin" <?= $sculpture['MaterialUsed'] === 'Resin' ? 'selected' : '' ?>>Resin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="HeightInCm" class="form-label">Height (in cm)</label>
                                <input type="text" name="HeightInCm" class="form-control" value="<?= $sculpture['HeightInCm'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="LengthInCm" class="form-label">Length (in cm)</label>
                                <input type="text" name="LengthInCm" class="form-control" value="<?= $sculpture['LengthInCm'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="WidthInCm" class="form-label">Width (in cm)</label>
                                <input type="text" name="WidthInCm" class="form-control" value="<?= $sculpture['WidthInCm'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="ApproxWeightInKg" class="form-label">Approximate Weight (in kg)</label>
                                <input type="text" name="ApproxWeightInKg" class="form-control" value="<?= $sculpture['ApproxWeightInKg'] ?>">
                            </div>
                            <button type="submit" class="btn btn-primary" name="update_sculpture_btn">Update Sculpture</button>
                        </form>
                        <!-- End Sculpture Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
include('layouts/footer.php')
?>