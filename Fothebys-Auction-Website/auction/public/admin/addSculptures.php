<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

// Fetch items that have not been assigned as sculptures
$itemsNotSculptures = $pdo->query('SELECT LotNumber, ArtistName, ItemID FROM Items WHERE ItemID NOT IN (SELECT ItemID FROM Sculptures)');

if (isset($_POST['save_sculpture_btn'])) {
    $ItemID = $_POST['ItemID'];
    $MaterialUsed = $_POST['MaterialUsed'];
    $HeightInCm = $_POST['HeightInCm'];
    $LengthInCm = $_POST['LengthInCm'];
    $WidthInCm = $_POST['WidthInCm'];
    $ApproxWeightInKg = $_POST['ApproxWeightInKg'];

    // Insert query
    $stmt = $pdo->prepare('INSERT INTO Sculptures (ItemID, MaterialUsed, HeightInCm, LengthInCm, WidthInCm, ApproxWeightInKg)
    VALUES (:ItemID, :MaterialUsed, :HeightInCm, :LengthInCm, :WidthInCm, :ApproxWeightInKg)');

    // Bind parameters
    $stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_INT); // Specify that ItemID is an integer
    $stmt->bindParam(':MaterialUsed', $MaterialUsed);
    $stmt->bindParam(':HeightInCm', $HeightInCm);
    $stmt->bindParam(':LengthInCm', $LengthInCm);
    $stmt->bindParam(':WidthInCm', $WidthInCm);
    $stmt->bindParam(':ApproxWeightInKg', $ApproxWeightInKg);

    // Execute the insert query
    $queryResult = $stmt->execute();

    if ($queryResult) {
        $_SESSION['message'] = 'Sculpture Successfully Added!';
        // Redirect to the appropriate location
        echo '<script>window.location.href = "Sculptures.php";</script>';
    } else {
        $_SESSION['message'] = 'Error Adding Sculpture!';
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
        <h1>Add Sculpture</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="Sculptures.php">Sculptures</a></li>
                <li class="breadcrumb-item active"><a href="addSculpture.php">Add Sculpture</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Sculpture</h5>
                        <p>Add a new sculpture with the form below.</p>

                        <!-- Sculpture Form -->
                        <form action="addSculptures.php" method="POST">
                            <div class="mb-3">
                                <label for="ItemID" class="form-label">Select Item</label>
                                <select name="ItemID" class="form-control">
                                    <option value="" disabled selected>Select an Item</option>
                                    <?php
                                    foreach ($itemsNotSculptures as $item) {
                                        echo '<option value="' . $item['ItemID'] . '">' . $item['LotNumber'] . ' - ' . $item['ArtistName'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="MaterialUsed" class="form-label">Material Used</label>
                                <select name="MaterialUsed" class="form-control">
                                    <option value="" disabled selected>Select Material Used</option>
                                    <option value="Bronze">Bronze</option>
                                    <option value="Stone sculpture">Stone sculpture</option>
                                    <option value="Marble">Marble</option>
                                    <option value="Terracotta">Terracotta</option>
                                    <option value="Granite">Granite</option>
                                    <option value="Resin">Resin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="HeightInCm" class="form-label">Height (in cm)</label>
                                <input type="text" name="HeightInCm" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="LengthInCm" class="form-label">Length (in cm)</label>
                                <input type="text" name="LengthInCm" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="WidthInCm" class="form-label">Width (in cm)</label>
                                <input type="text" name="WidthInCm" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="ApproxWeightInKg" class="form-label">Approximate Weight (in kg)</label>
                                <input type="text" name="ApproxWeightInKg" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary" name="save_sculpture_btn">Save Sculpture</button>
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