<?php
include 'header.php';
include 'admin/dbconnect.php';
// Check if the user is already logged in
if (isset($_SESSION['userId'])) {
  $logged_in = true;
} else {
  $logged_in = false;
}

// Handle logout if requested
if (isset($_GET['logout'])) {
  // Destroy the session and redirect to the home page or login page
  session_destroy();
  echo '<script>window.location.href = "index.php";</script>'; // Replace 'index.php' with your home page or login page URL
  exit();
}

// Create an array of Lot Numbers from 20 to 255
$featuredLotNumbers = range(20, 255);
// Retrieve featured items with associated auction data
try {
  $placeholders = implode(',', array_fill(0, count($featuredLotNumbers), '?'));
  $stmt = $pdo->prepare("SELECT i.*, a.AuctionDate, a.Location FROM Items i JOIN Auctions a ON i.AuctionID = a.AuctionID WHERE i.LotNumber IN ($placeholders)");
  $stmt->execute($featuredLotNumbers);
  $featuredItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}
?>


<div class="banner-search">
  <div class="container">
    <!-- banner -->
    <h3>Buy & Sale</h3>
    <div class="searchbar">
      <div class="row">
        <div class="col-lg-6 col-sm-6">
          <input type="text" class="form-control" placeholder="Search">
          <div class="row">
            <div class="col-lg-3 col-sm-4">
              <select class="form-control">
                <option>Painting</option>
                <option>Drawing</option>
                <option>Scluptor</option>
                <option>Carving</option>
                <option>Photographic Image</option>
              </select>
            </div>
            <div class="col-lg-3 col-sm-4">
              <button class="btn btn-success" onclick="window.location.href='buysalerent.php'">Find Now</button>
            </div>
          </div>


        </div>
        <div class="col-lg-5 col-lg-offset-1 col-sm-3 recommended">
          <?php
          if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            echo '<h3> Welcome, ' . $_SESSION['userName'] . ' (' . $_SESSION['userType'] . ')</h3>';
          }
          ?>
          <?php if ($logged_in) : ?>
            <a href="?logout" class="btn btn-info">Logout</a>
          <?php else : ?>
            <a href="login.php" class="btn btn-info">Login</a> <!-- Updated login button link -->
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</div>
</div>

<div class="container">
  <div class="properties-listing spacer"> <a href="buysalerent.php" class="pull-right viewall">View All Listing</a>
    <h2>Featured Products</h2>
    <div id="owl-example" class="owl-carousel">
      <?php foreach ($featuredItems as $item) : ?>
        <div class="properties">
          <?php echo '<img class="card-img-top" src="admin/assets/img/items/' . $item['ImagePath'] . '" alt="Product image">'; ?>
          <h4><a href="property-detail.php">Lot Number: <?php echo $item['LotNumber']; ?></a></h4>
          <p class="price">Estimated Price: $<?php echo number_format($item['EstimatedPrice'], 2); ?></p>
          <p>Year Produced: <?php echo $item['YearProduced']; ?></p>
          <p>General Subject: <?php echo $item['GeneralSubject']; ?></p>
          <p>Auction Date: <?php echo $item['AuctionDate']; ?></p>
          <p>Auction Location: <?php echo $item['Location']; ?></p>
          <a class="btn btn-primary" href="productDetail.php?id=<?php echo $item['ItemID']; ?>">View Details</a>

        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php
include 'footer.php';
?>