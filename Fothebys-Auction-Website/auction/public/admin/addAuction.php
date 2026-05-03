<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

if (isset($_POST['save_auction_btn'])) {
  // Check if the required fields are present in the $_POST array
  if (
    isset($_POST['AuctionDate']) &&
    isset($_POST['CatalogueNumber']) &&
    isset($_POST['Description']) &&
    isset($_POST['Location'])
  ) {
    // Extract input data
    $auctionDate = $_POST['AuctionDate'];
    $catalogueNumber = $_POST['CatalogueNumber'];
    $description = $_POST['Description'];
    $location = $_POST['Location'];

    // Check if a record with the same CatalogueNumber already exists
    $checkStmt = $pdo->prepare('SELECT COUNT(*) FROM Auctions WHERE CatalogueNumber = :CatalogueNumber');
    $checkStmt->bindParam(':CatalogueNumber', $catalogueNumber);
    $checkStmt->execute();
    $existingRecords = $checkStmt->fetchColumn();

    if ($existingRecords > 0) {
      // Record with the same CatalogueNumber already exists, handle accordingly (e.g., show an error message)
      $_SESSION['message'] = 'Auction with the same Catalogue Number already exists.';
    } else {
      // Insert query
      $stmt = $pdo->prepare('INSERT INTO Auctions (AuctionDate, CatalogueNumber, Description, Location)
            VALUES (:AuctionDate, :CatalogueNumber, :Description, :Location)');

      // Bind parameters
      $stmt->bindParam(':AuctionDate', $auctionDate);
      $stmt->bindParam(':CatalogueNumber', $catalogueNumber);
      $stmt->bindParam(':Description', $description);
      $stmt->bindParam(':Location', $location);

      // Execute the insert query
      $queryResult = $stmt->execute();

      if ($queryResult) {
        $_SESSION['message'] = 'Auction Information Successfully Added!';
        // Redirect to auction information page or another appropriate location
        echo '<script>window.location.href = "auctions.php";</script>';
      } else {
        $_SESSION['message'] = 'Error Adding Auction Information!';
      }
    }
  } else {
    $_SESSION['message'] = 'Please fill out all required fields.';
  }
}
?>

<main id="main" class="main">
  <?php echo $alertMessage; ?>
  <!-- Rest of your HTML content here -->

  <div class="pagetitle">
    <h1>Add Auction Information</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="auctions.php">Auctions</a></li>
        <li class="breadcrumb-item active"><a href="addAuction.php">Add Auction</a></li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Add Auction Information</h5>

            <!-- Auction Information Form -->
            <form action="addAuction.php" method="POST">
              <div class="mb-3">
                <label for="AuctionDate" class="form-label">Auction Date</label>
                <input type="date" class="form-control" name="AuctionDate" required>
              </div>
              <div class="mb-3">
                <label for="CatalogueNumber" class="form-label">Catalogue Number</label>
                <input type="text" class="form-control" name="CatalogueNumber" required>
              </div>
              <div class="mb-3">
                <label for="Description" class="form-label">Description</label>
                <textarea class="form-control" name="Description" rows="5" required></textarea>
              </div>
              <div class="mb-3">
                <label for="Location" class="form-label">Location</label>
                <input type="text" class="form-control" name="Location" required>
              </div>
              <button type="submit" class="btn btn-primary" name="save_auction_btn">Save Auction Information</button>
            </form>
            <!-- End Auction Information Form -->
          </div>
        </div>
      </div>
    </div>
  </section>
</main>