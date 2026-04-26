<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

if (isset($_POST['update_auction_btn'])) {
    $AuctionID = $_POST['AuctionID'];
    $AuctionDate = $_POST['AuctionDate'];
    $CatalogueNumber = $_POST['CatalogueNumber'];
    $Description = $_POST['Description'];
    $Location = $_POST['Location'];

    // Prepare the update statement
    $stmt = $pdo->prepare('UPDATE Auctions 
                           SET AuctionDate = :AuctionDate, 
                               CatalogueNumber = :CatalogueNumber, 
                               Description = :Description, 
                               Location = :Location 
                           WHERE AuctionID = :AuctionID');

    // Bind parameters
    $stmt->bindParam(':AuctionID', $AuctionID);
    $stmt->bindParam(':AuctionDate', $AuctionDate);
    $stmt->bindParam(':CatalogueNumber', $CatalogueNumber);
    $stmt->bindParam(':Description', $Description);
    $stmt->bindParam(':Location', $Location);

    // Execute the update query
    $queryResult = $stmt->execute();

    if ($queryResult) {
        $_SESSION['message'] = 'Auction Successfully Edited!';
        // Redirect to auctions page or another appropriate location
        echo '<script>window.location.href = "auctions.php";</script>';
    } else {
        $_SESSION['message'] = 'Error Editing Auction!';
    }
}

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
    <!-- Your HTML content for the edit auction form -->
    <div class="pagetitle">
        <h1>Edit Auction</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="auctions.php">Auctions</a></li>
                <li class="breadcrumb-item active"><a href="editAuction.php">Edit Auction</a></li>
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
                            $AuctionID = $_GET['id'];

                            $query = "SELECT * FROM Auctions WHERE AuctionID=:AuctionID LIMIT 1";
                            $stmt = $pdo->prepare($query);
                            $data = [
                                ':AuctionID' => $AuctionID
                            ];
                            $stmt->execute($data);

                            // Fetch the auction data
                            $result = $stmt->fetch(PDO::FETCH_OBJ);
                        }
                        ?>
                        <h5 class="card-title">Edit Auction</h5>
                        <p>Edit an existing auction with the form below.</p>

                        <form action="editAuction.php" method="POST">
                            <input type="hidden" name="AuctionID" value="<?= $result->AuctionID ?>" />
                            <div class="mb-3">
                                <label for="AuctionDate" class="form-label">Auction Date</label>
                                <input type="date" name="AuctionDate" class="form-control" value="<?= $result->AuctionDate; ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="CatalogueNumber" class="form-label">Catalogue Number</label>
                                <input type="text" name="CatalogueNumber" class="form-control" value="<?= $result->CatalogueNumber; ?>" />
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
                                <label for="Location" class="form-label">Location</label>
                                <input type="text" name="Location" class="form-control" value="<?= $result->Location; ?>" />
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="update_auction_btn">Update Auction</button>
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