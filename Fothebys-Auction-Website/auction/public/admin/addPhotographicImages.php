<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

// Fetch items that have not been assigned as photographic images
$itemsNotPhotographicImages = $pdo->query('SELECT LotNumber, ArtistName, ItemID FROM Items WHERE ItemID NOT IN (SELECT ItemID FROM PhotographicImages)');

if (isset($_POST['save_photographic_image_btn'])) {
  $ItemID = $_POST['ItemID'];
  $ImageType = $_POST['ImageType'];
  $HeightInCm = $_POST['HeightInCm'];
  $LengthInCm = $_POST['LengthInCm'];

  // Insert query
  $stmt = $pdo->prepare('INSERT INTO PhotographicImages (ItemID, ImageType, HeightInCm, LengthInCm)
VALUES (:ItemID, :ImageType, :HeightInCm, :LengthInCm)');

  // Bind parameters
  $stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_INT); // Specify that ItemID is an integer
  $stmt->bindParam(':ImageType', $ImageType);
  $stmt->bindParam(':HeightInCm', $HeightInCm);
  $stmt->bindParam(':LengthInCm', $LengthInCm);

  // Execute the insert query
  $queryResult = $stmt->execute();

  if ($queryResult) {
    $_SESSION['message'] = 'Photographic Image Successfully Added!';
    // Redirect to the appropriate location
    echo '<script>window.location.href = "PhotographicImages.php";</script>';
  } else {
    $_SESSION['message'] = 'Error Adding Photographic Image!';
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
    <h1>Add Photographic Image</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="PhotographicImages.php">Photographic Images</a></li>
        <li class="breadcrumb-item active"><a href="addPhotographicImage.php">Add Photographic Image</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Add Photographic Image</h5>
            <p>Add a new photographic image with the form below.</p>

            <!-- Photographic Image Form -->
            <form action="addPhotographicImages.php" method="POST">
              <div class="mb-3">
                <label for="ItemID" class="form-label">Select Item</label>
                <select name="ItemID" class="form-control">
                  <option value="" disabled selected>Select an Item</option>
                  <?php
                  foreach ($itemsNotPhotographicImages as $item) {
                    echo '<option value="' . $item['ItemID'] . '">' . $item['LotNumber'] . ' - ' . $item['ArtistName'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="ImageType" class="form-label">Select Image Type</label>
                <select name="ImageType" class="form-control">
                  <option value="" disabled selected>Select Image Type</option>
                  <option value="Potrait">Potrait</option>
                  <option value="Landscape">Landscape</option>
                  <option value="Nature">Nature</option>
                  <option value="Culture">Culture</option>
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
              <button type="submit" class="btn btn-primary" name="save_photographic_image_btn">Save Photographic Image</button>
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