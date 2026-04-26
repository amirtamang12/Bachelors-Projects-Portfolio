<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

if (isset($_POST['update_drawing_btn'])) {
    $DrawingID = $_POST['DrawingID'];
    $DrawingMedium = $_POST['DrawingMedium'];
    $IsFramed = isset($_POST['IsFramed']) ? 1 : 0;
    $HeightInCm = $_POST['HeightInCm'];
    $LengthInCm = $_POST['LengthInCm'];

    // Update query
    $stmt = $pdo->prepare('UPDATE Drawings SET 
        DrawingMedium = :DrawingMedium, 
        IsFramed = :IsFramed, 
        HeightInCm = :HeightInCm, 
        LengthInCm = :LengthInCm 
        WHERE DrawingID = :DrawingID');

    // Bind parameters
    $stmt->bindParam(':DrawingID', $DrawingID, PDO::PARAM_INT);
    $stmt->bindParam(':DrawingMedium', $DrawingMedium);
    $stmt->bindParam(':IsFramed', $IsFramed, PDO::PARAM_INT);
    $stmt->bindParam(':HeightInCm', $HeightInCm);
    $stmt->bindParam(':LengthInCm', $LengthInCm);

    // Execute the update query
    $queryResult = $stmt->execute();

    if ($queryResult) {
        $_SESSION['message'] = 'Drawing Successfully Edited!';
        // Redirect to drawings.php or another appropriate location
        echo '<script>window.location.href = "Drawings.php";</script>';
        exit();
    } else {
        $_SESSION['message'] = 'Error Editing Drawing!';
    }
}

if (isset($_GET['id'])) {
    $DrawingID = $_GET['id'];

    // Fetch the drawing data to pre-populate the form
    $stmt = $pdo->prepare('SELECT d.DrawingID, d.DrawingMedium, d.IsFramed, d.HeightInCm, d.LengthInCm, i.LotNumber, i.ArtistName FROM Drawings d INNER JOIN Items i ON d.ItemID = i.ItemID WHERE d.DrawingID = :DrawingID');
    $stmt->bindParam(':DrawingID', $DrawingID, PDO::PARAM_INT);
    $stmt->execute();
    $drawing = $stmt->fetch(PDO::FETCH_ASSOC);
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
        <h1>Edit Drawing</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="drawings.php">Drawings</a></li>
                <li class="breadcrumb-item active"><a href="editDrawing.php">Edit Drawing</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Drawing</h5>
                        <p>Edit an existing drawing with the form below.</p>

                        <!-- Drawing Form -->
                        <form action="editDrawings.php" method="POST">
                            <input type="hidden" name="DrawingID" value="<?= $drawing['DrawingID'] ?>" />
                            <div class="mb-3">
                                <label for="ItemID" class="form-label">Select Item</label>
                                <input type="text" class="form-control" value="<?= $drawing['LotNumber'] ?> - <?= $drawing['ArtistName'] ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="DrawingMedium" class="form-label">Drawing Medium</label>
                                <select name="DrawingMedium" class="form-control">
                                    <option value="Acrylic paint" <?= $drawing['DrawingMedium'] === 'Acrylic paint' ? 'selected' : '' ?>>Acrylic paint</option>
                                    <option value="Charcoal" <?= $drawing['DrawingMedium'] === 'Charcoal' ? 'selected' : '' ?>>Charcoal</option>
                                    <option value="Colored pencil" <?= $drawing['DrawingMedium'] === 'Colored pencil' ? 'selected' : '' ?>>Colored pencil</option>
                                    <option value="Chalk" <?= $drawing['DrawingMedium'] === 'Chalk' ? 'selected' : '' ?>>Chalk</option>
                                    <option value="Marker pen" <?= $drawing['DrawingMedium'] === 'Marker pen' ? 'selected' : '' ?>>Marker pen</option>
                                    <option value="Crayon" <?= $drawing['DrawingMedium'] === 'Crayon' ? 'selected' : '' ?>>Crayon</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="IsFramed" class="form-check-label">Framed</label>
                                <input type="checkbox" name="IsFramed" class="form-check-input" <?= $drawing['IsFramed'] ? 'checked' : '' ?>>
                            </div>
                            <div class="mb-3">
                                <label for="HeightInCm" class="form-label">Height (in cm)</label>
                                <input type="text" name="HeightInCm" class="form-control" value="<?= $drawing['HeightInCm'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="LengthInCm" class="form-label">Length (in cm)</label>
                                <input type="text" name="LengthInCm" class="form-control" value="<?= $drawing['LengthInCm'] ?>">
                            </div>
                            <button type="submit" class="btn btn-primary" name="update_drawing_btn">Update Drawing</button>
                        </form>
                        <!-- End Drawing Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
include('layouts/footer.php')
?>