<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

// Fetch items that have not been assigned as paintings
$itemsNotPaintings = $pdo->query('SELECT LotNumber, ArtistName, ItemID FROM Items WHERE ItemID NOT IN (SELECT ItemID FROM Paintings)');

if (isset($_POST['save_painting_btn'])) {
  $ItemID = $_POST['ItemID'];
  $PaintingMedium = $_POST['PaintingMedium'];
  $IsFramed = isset($_POST['IsFramed']) ? 1 : 0;
  $HeightInCm = $_POST['HeightInCm'];
  $LengthInCm = $_POST['LengthInCm'];

  // Insert query
  $stmt = $pdo->prepare('INSERT INTO Paintings (ItemID, PaintingMedium, IsFramed, HeightInCm, LengthInCm)
VALUES (:ItemID, :PaintingMedium, :IsFramed, :HeightInCm, :LengthInCm)');

  // Bind parameters
  $stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_INT); // Specify that ItemID is an integer
  $stmt->bindParam(':PaintingMedium', $PaintingMedium);
  $stmt->bindParam(':IsFramed', $IsFramed, PDO::PARAM_INT);
  $stmt->bindParam(':HeightInCm', $HeightInCm);
  $stmt->bindParam(':LengthInCm', $LengthInCm);

  // Execute the insert query
  $queryResult = $stmt->execute();

  if ($queryResult) {
    $_SESSION['message'] = 'Painting Successfully Added!';
    // Redirect to paintings.php or another appropriate location
    echo '<script>window.location.href = "Paintings.php";</script>';
  } else {
    $_SESSION['message'] = 'Error Adding Painting!';
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
    <h1>Add Painting</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="paintings.php">Paintings</a></li>
        <li class="breadcrumb-item active"><a href="addPaintings.php">Add Painting</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Add Painting</h5>
            <p>Add a new painting with the form below.</p>

            <!-- Painting Form -->
            <form action="addPaintings.php" method="POST">
              <div class="mb-3">
                <label for="ItemID" class="form-label">Select Item</label>
                <select name="ItemID" class="form-control">
                  <option value="" disabled selected>Select an Item</option>
                  <?php
                  foreach ($itemsNotPaintings as $item) {
                    echo '<option value="' . $item['ItemID'] . '">' . $item['LotNumber'] . ' - ' . $item['ArtistName'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="PaintingMedium" class="form-label">Select Painting Medium</label>
                <select name="PaintingMedium" class="form-control">
                  <option value="" disabled selected>Select Medium</option>
                  <option value="Oil painting">Oil painting</option>
                  <option value="Acrylic paint">Acrylic paint</option>
                  <option value="Oil pastel">Oil pastel</option>
                  <option value="Pen">Pen</option>
                  <option value="Pastel">Pastel</option>
                  <option value="Watercolour">Watercolour</option>
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
              <button type="submit" class="btn btn-primary" name="save_painting_btn">Save Painting</button>
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