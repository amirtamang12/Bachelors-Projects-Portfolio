<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

if (isset($_POST['update_painting_btn'])) {
    $ItemID = $_POST['ItemID'];
    $PaintingMedium = $_POST['PaintingMedium'];
    $IsFramed = isset($_POST['IsFramed']) ? 1 : 0;
    $HeightInCm = $_POST['HeightInCm'];
    $LengthInCm = $_POST['LengthInCm'];

    // Update query
    $stmt = $pdo->prepare('UPDATE Paintings SET 
        PaintingMedium = :PaintingMedium, 
        IsFramed = :IsFramed, 
        HeightInCm = :HeightInCm, 
        LengthInCm = :LengthInCm 
        WHERE ItemID = :ItemID');

    // Bind parameters
    $stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_INT);
    $stmt->bindParam(':PaintingMedium', $PaintingMedium);
    $stmt->bindParam(':IsFramed', $IsFramed, PDO::PARAM_INT);
    $stmt->bindParam(':HeightInCm', $HeightInCm);
    $stmt->bindParam(':LengthInCm', $LengthInCm);

    // Execute the update query
    $queryResult = $stmt->execute();

    if ($queryResult) {
        $_SESSION['message'] = 'Painting Successfully Edited!';
        // Redirect to paintings.php or another appropriate location
        echo '<script>window.location.href = "Paintings.php";</script>';
        exit();
    } else {
        $_SESSION['message'] = 'Error Editing Painting!';
    }
}

if (isset($_GET['id'])) {
    $ItemID = $_GET['id'];

    // Fetch the painting data to pre-populate the form
    $stmt = $pdo->prepare('SELECT p.ItemID, p.PaintingMedium, p.IsFramed, p.HeightInCm, p.LengthInCm, i.LotNumber, i.ArtistName FROM Paintings p INNER JOIN Items i ON p.ItemID = i.ItemID WHERE p.ItemID = :ItemID');
    $stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_INT);
    $stmt->execute();
    $painting = $stmt->fetch(PDO::FETCH_ASSOC);
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
        <h1>Edit Painting</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="paintings.php">Paintings</a></li>
                <li class="breadcrumb-item active"><a href="editPainting.php">Edit Painting</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Painting</h5>
                        <p>Edit an existing painting with the form below.</p>

                        <!-- Painting Form -->
                        <form action="editPainting.php" method="POST">
                            <div class="mb-3">
                                <label for="ItemID" class="form-label">Select Item</label>
                                <select name="ItemID" class="form-control" disabled>
                                    <option value="<?= $painting['ItemID'] ?>"><?= $painting['LotNumber'] ?> - <?= $painting['ArtistName'] ?></option>
                                </select>
                                <input type="hidden" name="ItemID" value="<?= $painting['ItemID'] ?>" />
                            </div>
                            <div class="mb-3">
                                <label for="PaintingMedium" class="form-label">Painting Medium</label>
                                <select name="PaintingMedium" class="form-control">
                                    <option value="Oil painting" <?= $painting['PaintingMedium'] === 'Oil painting' ? 'selected' : '' ?>>Oil painting</option>
                                    <option value="Acrylic paint" <?= $painting['PaintingMedium'] === 'Acrylic paint' ? 'selected' : '' ?>>Acrylic paint</option>
                                    <option value="Oil pastel" <?= $painting['PaintingMedium'] === 'Oil pastel' ? 'selected' : '' ?>>Oil pastel</option>
                                    <option value="Pen" <?= $painting['PaintingMedium'] === 'Pen' ? 'selected' : '' ?>>Pen</option>
                                    <option value="Pastel" <?= $painting['PaintingMedium'] === 'Pastel' ? 'selected' : '' ?>>Pastel</option>
                                    <option value="Watercolour" <?= $painting['PaintingMedium'] === 'Watercolour' ? 'selected' : '' ?>>Watercolour</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="IsFramed" class="form-check-label">Framed</label>
                                <input type="checkbox" name="IsFramed" class="form-check-input" <?= $painting['IsFramed'] ? 'checked' : '' ?>>
                            </div>
                            <div class="mb-3">
                                <label for="HeightInCm" class="form-label">Height (in cm)</label>
                                <input type="text" name="HeightInCm" class="form-control" value="<?= $painting['HeightInCm'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="LengthInCm" class="form-label">Length (in cm)</label>
                                <input type="text" name="LengthInCm" class="form-control" value="<?= $painting['LengthInCm'] ?>">
                            </div>
                            <button type="submit" class="btn btn-primary" name="update_painting_btn">Update Painting</button>
                        </form>
                        <!-- End Painting Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
include('layouts/footer.php')
?>