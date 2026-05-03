<?php
include 'header.php';
include 'admin/dbconnect.php';

// Alter the Items table to add the AuctionDate column
try {
  $stmt = $pdo->prepare('ALTER TABLE Items ADD COLUMN AuctionDate DATE');
  $stmt->execute();
} catch (PDOException $e) {
  // Handle any errors if the column already exists
}

// Check if the user is logged in as a seller or admin
if (isset($_SESSION['userType']) && ($_SESSION['userType'] == 'seller' || $_SESSION['userType'] == 'admin')) {
  // User is allowed to sell an item
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle the form submission to create a new item

    // Retrieve and sanitize the input data from the form
    $lotNumber = $_POST['LotNumber'];
    $estimatedPrice = $_POST['EstimatedPrice'];
    $yearProduced = $_POST['YearProduced'];
    $generalSubject = $_POST['GeneralSubject'];
    $auctionDate = $_POST['AuctionDate'];
    $location = $_POST['Location'];
    $description = $_POST['Description'];
    $artistName = $_POST['ArtistName']; // Added field for artist name

    // Handle image upload
    $imageUploadDirectory = 'admin/assets/img/items/'; // Specify the directory where you want to save the uploaded images
    $imageName = $_FILES['ItemImage']['name'];
    $imageTempName = $_FILES['ItemImage']['tmp_name'];
    $imagePath = $imageUploadDirectory . $imageName;
    move_uploaded_file($imageTempName, $imagePath);

    // Perform the database insert to add a new item with AuctionDate
    try {
      $stmt = $pdo->prepare('INSERT INTO Items (LotNumber, EstimatedPrice, YearProduced, GeneralSubject, AuctionDate, Location, Description, ArtistName, ImagePath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
      $stmt->execute([$lotNumber, $estimatedPrice, $yearProduced, $generalSubject, $auctionDate, $location, $description, $artistName, $imageName]);

      // Item added successfully
      echo '<div class="container">';
      echo '<div class="alert alert-success">Item added successfully.</div>';
      echo '</div>';
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }


    // Retrieve auction dates from the 'Auctions' table
    try {
      $stmt = $pdo->prepare('SELECT DISTINCT AuctionDate FROM Auctions');
      $stmt->execute();
      $auctionDates = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
?>

    <!-- Your HTML form for sellers to list an item -->
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
          <form method="post" action="sell.php" enctype="multipart/form-data">
            <div class="form-group">
              <label for="LotNumber">Lot Number</label>
              <input type="text" class="form-control" id="LotNumber" name="LotNumber" required>
            </div>
            <div class="form-group">
              <label for="EstimatedPrice">Estimated Price</label>
              <input type="number" class="form-control" id="EstimatedPrice" name="EstimatedPrice" required>
            </div>
            <div class="form-group">
              <label for="YearProduced">Year Produced</label>
              <input type="text" class="form-control" id="YearProduced" name="YearProduced" required>
            </div>
            <div class="form-group">
              <label for="GeneralSubject">General Subject</label>
              <select class="form-control" id="GeneralSubject" name="GeneralSubject" required>
                <option value="">Select General Subject</option>
                <option value="Carvings">Carvings</option>
                <option value="Painting">Painting</option>
                <option value="Photographic Images">Photographic Images</option>
                <option value="Sculptures">Sculptures</option>
                <option value="Drawings">Drawings</option>
              </select>
            </div>
            <div class="form-group">
              <label for="AuctionDate">Auction Date</label>
              <select class="form-control" id="AuctionDate" name="AuctionDate" required>
                <option value="">Select Auction Date</option>
                <?php
                foreach ($auctionDates as $date) {
                  echo '<option value="' . $date . '">' . $date . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="Location">Location</label>
              <select class="form-control" id="Location" name="Location" required>
                <option value="">Select Location</option>
                <option value="London">London</option>
                <option value="Paris">Paris</option>
              </select>
            </div>
            <div class="form-group">
              <label for="ArtistName">Artist Name</label> <!-- Added field for artist name -->
              <input type="text" class="form-control" id="ArtistName" name="ArtistName" required>
            </div>
            <div class="form-group">
              <label for="ItemImage">Upload Image</label> <!-- Added field for image upload -->
              <input type="file" class="form-control" id="ItemImage" name="ItemImage" accept="image/*" required>
            </div>
            <div class="form-group">
              <label for="Description">Description</label>
              <textarea class="form-control" id="Description" name="Description" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">List Item</button>
          </form>
        </div>
      </div>
    </div>
<?php
  } else {
    // User is not logged in or not authorized to sell
    echo 'You must be logged in as a seller or admin to list an item.';
  }

  include 'footer.php';
}
?>