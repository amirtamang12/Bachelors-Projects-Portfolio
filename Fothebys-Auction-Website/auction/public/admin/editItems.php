<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

if (isset($_POST['update_item_btn'])) {
    $ItemID = $_POST['ItemID'];
    $LotNumber = $_POST['LotNumber'];
    $ArtistName = $_POST['ArtistName'];
    $YearProduced = $_POST['YearProduced'];
    $GeneralSubject = $_POST['GeneralSubject'];
    $Description = $_POST['Description'];
    $AuctionID = $_POST['AuctionID'];
    $EstimatedPrice = $_POST['EstimatedPrice'];
    $ImagePath = $_POST['ImagePath'];

    // Check if the selected Lot Number already exists
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM Items WHERE LotNumber = :LotNumber');
    $stmt->bindParam(':LotNumber', $LotNumber);
    $stmt->execute();
    $lotNumberExists = $stmt->fetchColumn();

    if ($lotNumberExists) {
        // Lot Number exists, update the item
        $stmt = $pdo->prepare('UPDATE Items 
                               SET ArtistName = :ArtistName, 
                                   YearProduced = :YearProduced, 
                                   GeneralSubject = :GeneralSubject, 
                                   Description = :Description, 
                                   AuctionID = :AuctionID, 
                                   EstimatedPrice = :EstimatedPrice, 
                                   ImagePath = :ImagePath 
                               WHERE LotNumber = :LotNumber');
        $stmt->bindParam(':ArtistName', $ArtistName);
        $stmt->bindParam(':YearProduced', $YearProduced);
        $stmt->bindParam(':GeneralSubject', $GeneralSubject);
        $stmt->bindParam(':Description', $Description);
        $stmt->bindParam(':AuctionID', $AuctionID);
        $stmt->bindParam(':EstimatedPrice', $EstimatedPrice);
        $stmt->bindParam(':ImagePath', $ImagePath);
        $stmt->bindParam(':LotNumber', $LotNumber);

        $queryResult = $stmt->execute();
    } else {
        // Lot Number doesn't exist, insert a new item
        $stmt = $pdo->prepare('INSERT INTO Items (LotNumber, ArtistName, YearProduced, GeneralSubject, Description, AuctionID, EstimatedPrice, ImagePath)
                               VALUES (:LotNumber, :ArtistName, :YearProduced, :GeneralSubject, :Description, :AuctionID, :EstimatedPrice, :ImagePath)');
        $stmt->bindParam(':LotNumber', $LotNumber);
        $stmt->bindParam(':ArtistName', $ArtistName);
        $stmt->bindParam(':YearProduced', $YearProduced);
        $stmt->bindParam(':GeneralSubject', $GeneralSubject);
        $stmt->bindParam(':Description', $Description);
        $stmt->bindParam(':AuctionID', $AuctionID);
        $stmt->bindParam(':EstimatedPrice', $EstimatedPrice);
        $stmt->bindParam(':ImagePath', $ImagePath);

        $queryResult = $stmt->execute();
    }

    if ($queryResult) {
        $_SESSION['message'] = 'Item Successfully Edited!';
        // Redirect to items page or another appropriate location
        echo '<script>window.location.href = "Items.php";</script>';
    } else {
        $_SESSION['message'] = 'Error Editing Item!';
    }
}

// Fetch existing auctions for Auction ID selection
try {
    $stmt = $pdo->prepare('SELECT AuctionID, AuctionDate FROM Auctions');
    $stmt->execute();
    $auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Define options for the "General Subject" dropdown
$generalSubjectOptions = ['Carvings', 'Painting', 'Photographic Images', 'Sculptures', 'Drawings'];
?>

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
    <!-- Your HTML content for the edit item form -->
    <div class="pagetitle">
        <h1>Edit Item</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="items.php">Items</a></li>
                <li class="breadcrumb-item active"><a href="editItem.php">Edit Item</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        if (isset($_GET['id'])) {
                            $ItemID = $_GET['id'];

                            $query = "SELECT * FROM Items WHERE ItemID=:ItemID LIMIT 1";
                            $stmt = $pdo->prepare($query);
                            $data = [
                                ':ItemID' => $ItemID
                            ];
                            $stmt->execute($data);

                            // Fetch the item data
                            $result = $stmt->fetch(PDO::FETCH_OBJ);
                        }
                        ?>
                        <h5 class="card-title">Edit Item</h5>
                        <p>Edit an existing item with the form below.</p>

                        <form action="editItems.php" method="POST">
                            <input type="hidden" name="ItemID" value="<?= $result->ItemID ?>" />
                            <div class="mb-3">
                                <label for="LotNumber" class="form-label">Lot Number</label>
                                <input type="text" name="LotNumber" class="form-control" value="<?= $result->LotNumber; ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="ArtistName" class="form-label">Artist Name</label>
                                <input type="text" name="ArtistName" class="form-control" value="<?= $result->ArtistName; ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="YearProduced" class="form-label">Year Produced</label>
                                <input type="text" name="YearProduced" class="form-control" value="<?= $result->YearProduced; ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="GeneralSubject" class="form-label">General Subject</label>
                                <select name="GeneralSubject" class="form-control">
                                    <?php foreach ($generalSubjectOptions as $option) { ?>
                                        <option value="<?= $option; ?>" <?php if ($result->GeneralSubject === $option) echo 'selected'; ?>><?= $option; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <section class="section">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Description</h5>
                                        <!-- TinyMCE Editor -->
                                        <textarea class="tinymce-editor" name="Description" id="Description" rows="5" class="form-control"><?= $result->Description; ?></textarea>
                                        <!-- End TinyMCE Editor -->
                                    </div>
                                </div>
                            </section>

                            <div class="mb-3">
                                <label for="AuctionID" class="form-label">Auction ID</label>
                                <select name="AuctionID" class="form-control">
                                    <option value="">Select Auction</option>
                                    <?php foreach ($auctions as $auction) { ?>
                                        <option value="<?= $auction['AuctionID']; ?>" <?php if ($result->AuctionID === $auction['AuctionID']) echo 'selected'; ?>><?= $auction['AuctionDate']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="EstimatedPrice" class="form-label">Estimated Price</label>
                                <input type="text" name="EstimatedPrice" class="form-control" value="<?= $result->EstimatedPrice; ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="ImagePath" class="form-label">Image Path</label>
                                <input type="text" name="ImagePath" class="form-control" value="<?= $result->ImagePath; ?>" />
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="update_item_btn">Update Item</button>
                                </div>
                            </div>
                        </form>
                        <script>
                            tinymce.init({
                                selector: "textarea#Description",
                                plugins: [
                                    "advlist autolink lists link image charmap print preview anchor",
                                    "searchreplace visualblocks code fullscreen",
                                    "insertdatetime media table paste",
                                ],
                                toolbar: "bold italic | fontsizeselect fontselect",
                                fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
                                font_formats: "Arial=arial,helvetica,sans-serif;Comic Sans MS=comic sans ms,sans-serif;Times New Roman=times new roman,times,serif",
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
include('layouts/footer.php');
?>