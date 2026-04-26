<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

// Fetch existing auctions for Lot Number and Auction ID selection
try {
    $stmt = $pdo->prepare('SELECT AuctionID, AuctionDate FROM Auctions');
    $stmt->execute();
    $auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if (isset($_POST['save_item_btn'])) {
    // Check if the required fields are present in the $_POST array
    if (
        isset($_POST['LotNumber']) &&
        isset($_POST['ArtistName']) &&
        isset($_POST['YearProduced']) &&
        isset($_POST['GeneralSubject']) &&
        isset($_POST['Description']) &&
        isset($_POST['AuctionID']) &&
        isset($_POST['EstimatedPrice']) &&
        isset($_FILES['ItemImage']) // Make sure you have enctype="multipart/form-data" in your form
    ) {
        // Extract input data
        $lotNumber = $_POST['LotNumber'];
        $artistName = $_POST['ArtistName'];
        $yearProduced = $_POST['YearProduced'];
        $generalSubject = $_POST['GeneralSubject'];
        $description = $_POST['Description'];
        $auctionID = $_POST['AuctionID'];
        $estimatedPrice = $_POST['EstimatedPrice'];

        // Handle file upload
        $imagePath = ''; // Initialize the image path variable

        if ($_FILES['ItemImage']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'assets/img/items/'; // Set your upload directory
            $imageExtension = pathinfo($_FILES['ItemImage']['name'], PATHINFO_EXTENSION);
            $imagePath = $uploadDir . uniqid('item_') . '.' . $imageExtension;

            if (move_uploaded_file($_FILES['ItemImage']['tmp_name'], $imagePath)) {
                // File upload successful
            } else {
                // File upload failed
                $_SESSION['message'] = 'Error uploading the item image.';
                header('Location: addItem.php');
                exit;
            }
        }

        // Insert query
        $stmt = $pdo->prepare('INSERT INTO Items (LotNumber, ArtistName, YearProduced, GeneralSubject, Description, AuctionID, EstimatedPrice, ImagePath)
        VALUES (:LotNumber, :ArtistName, :YearProduced, :GeneralSubject, :Description, :AuctionID, :EstimatedPrice, :ImagePath)');

        // Bind parameters
        $stmt->bindParam(':LotNumber', $lotNumber);
        $stmt->bindParam(':ArtistName', $artistName);
        $stmt->bindParam(':YearProduced', $yearProduced);
        $stmt->bindParam(':GeneralSubject', $generalSubject);
        $stmt->bindParam(':Description', $description);
        $stmt->bindParam(':AuctionID', $auctionID);
        $stmt->bindParam(':EstimatedPrice', $estimatedPrice);
        $stmt->bindParam(':ImagePath', $imagePath);

        // Execute the insert query
        $queryResult = $stmt->execute();

        if ($queryResult) {
            $_SESSION['message'] = 'Item Information Successfully Added!';
            // Redirect to items information page or another appropriate location
            echo '<script>window.location.href = "items.php";</script>';
        } else {
            $_SESSION['message'] = 'Error Adding Item Information!';
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
        <h1>Add Item Information</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="items.php">Items</a></li>
                <li class="breadcrumb-item active"><a href="addItem.php">Add Item</a></li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Item Information</h5>

                        <!-- Item Information Form -->
                        <form action="addItems.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="LotNumber" class="form-label">Lot Number</label>
                                <input type="text" class="form-control" name="LotNumber" required>
                            </div>
                            <div class="mb-3">
                                <label for="ArtistName" class="form-label">Artist Name</label>
                                <input type="text" class="form-control" name="ArtistName" required>
                            </div>
                            <div class="mb-3">
                                <label for="YearProduced" class="form-label">Year Produced</label>
                                <input type="text" class="form-control" name="YearProduced" required>
                            </div>
                            <div class="mb-3">
                                <label for="GeneralSubject" class="form-label">General Subject</label>
                                <select class="form-control" name="GeneralSubject" required>
                                    <option value="">Select General Subject</option>
                                    <option value="Carvings">Carvings</option>
                                    <option value="Painting">Painting</option>
                                    <option value="Photographic Images">Photographic Images</option>
                                    <option value="Sculptures">Sculptures</option>
                                    <option value="Drawings">Drawings</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Description" class="form-label">Description</label>
                                <textarea class="form-control" name="Description" rows="5" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="AuctionID" class="form-label">Auction ID</label>
                                <select class="form-control" name="AuctionID" required>
                                    <option value="">Select Auction</option>
                                    <?php foreach ($auctions as $auction) { ?>
                                        <option value="<?php echo $auction['AuctionID']; ?>"><?php echo $auction['AuctionDate']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="EstimatedPrice" class="form-label">Estimated Price</label>
                                <input type="text" class="form-control" name="EstimatedPrice" required>
                            </div>
                            <div class="mb-3">
                                <label for="ItemImage" class="form-label">Item Image</label>
                                <input type="file" class="form-control" name="ItemImage" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="save_item_btn">Save Item Information</button>
                        </form>
                        <!-- End Item Information Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>