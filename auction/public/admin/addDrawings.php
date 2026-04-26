<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

// Fetch items that have not been assigned as drawings
$itemsNotDrawings = $pdo->query('SELECT LotNumber, ArtistName, ItemID FROM Items WHERE ItemID NOT IN (SELECT ItemID FROM Drawings)');

if (isset($_POST['save_drawing_btn'])) {
    $ItemID = $_POST['ItemID'];
    $DrawingMedium = $_POST['DrawingMedium'];
    $IsFramed = isset($_POST['IsFramed']) ? 1 : 0;
    $HeightInCm = $_POST['HeightInCm'];
    $LengthInCm = $_POST['LengthInCm'];

    // Insert query
    $stmt = $pdo->prepare('INSERT INTO Drawings (ItemID, DrawingMedium, IsFramed, HeightInCm, LengthInCm)
VALUES (:ItemID, :DrawingMedium, :IsFramed, :HeightInCm, :LengthInCm)');

    // Bind parameters
    $stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_INT); // Specify that ItemID is an integer
    $stmt->bindParam(':DrawingMedium', $DrawingMedium);
    $stmt->bindParam(':IsFramed', $IsFramed, PDO::PARAM_INT);
    $stmt->bindParam(':HeightInCm', $HeightInCm);
    $stmt->bindParam(':LengthInCm', $LengthInCm);

    // Execute the insert query
    $queryResult = $stmt->execute();

    if ($queryResult) {
        $_SESSION['message'] = 'Drawing Successfully Added!';
        // Redirect to drawings.php or another appropriate location
        echo '<script>window.location.href = "Drawings.php";</script>';
    } else {
        $_SESSION['message'] = 'Error Adding Drawing!';
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
        <h1>Add Drawing</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="drawings.php">Drawings</a></li>
                <li class="breadcrumb-item active"><a href="addDrawings.php">Add Drawing</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Drawing</h5>
                        <p>Add a new drawing with the form below.</p>

                        <!-- Drawing Form -->
                        <form action="addDrawings.php" method="POST">
                            <div class="mb-3">
                                <label for="ItemID" class="form-label">Select Item</label>
                                <select name="ItemID" class="form-control">
                                    <option value="" disabled selected>Select an Item</option>
                                    <?php
                                    foreach ($itemsNotDrawings as $item) {
                                        echo '<option value="' . $item['ItemID'] . '">' . $item['LotNumber'] . ' - ' . $item['ArtistName'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="DrawingMedium" class="form-label">Select Drawing Medium</label>
                                <select name="DrawingMedium" class="form-control">
                                    <option value="" disabled selected>Select Medium</option>
                                    <option value="Acrylic paint">Acrylic paint</option>
                                    <option value="Charcoal">Charcoal</option>
                                    <option value="Colored pencil">Colored pencil</option>
                                    <option value="Chalk">Chalk</option>
                                    <option value="Marker pen">Marker pen</option>
                                    <option value="Crayon">Crayon</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="IsFramed" class="form-check-label">Framed</label>
                                <input type="checkbox" name="IsFramed" class="form-check-input">
                            </div>
                            <div class="mb-3">
                                <label for="HeightInCm" class="form-label">Height (in cm)</label>
                                <input type="text" name="HeightInCm" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="LengthInCm" class="form-label">Length (in cm)</label>
                                <input type="text" name="LengthInCm" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary" name="save_drawing_btn">Save Drawing</button>
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