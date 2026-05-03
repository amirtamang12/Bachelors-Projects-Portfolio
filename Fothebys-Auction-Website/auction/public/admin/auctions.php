<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

try {
    $stmt = $pdo->prepare('SELECT * FROM Auctions');
    $stmt->execute();
    $auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Auctions Table</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Auctions</li>
                <li class="breadcrumb-item active">Items</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <?php if (isset($_SESSION['message'])) {
                    echo ' <h5 class="alert alert-success">' . $_SESSION['message'] . '</h5>';
                    unset($_SESSION['message']); // Clear the session message
                } ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Auctions</h5>
                        <p>List of auctions. Click "Add" to add a new auction.</p>
                        <a href="addAuction.php"><button type="button" class="btn btn-success">Add</button></a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Auction ID</th>
                                    <th scope="col">Auction Date</th>
                                    <th scope="col">Catalogue Number</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($auctions as $auction) { ?>
                                    <tr>
                                        <td><?php echo $auction['AuctionID']; ?></td>
                                        <td><?php echo $auction['AuctionDate']; ?></td>
                                        <td><?php echo $auction['CatalogueNumber']; ?></td>
                                        <td><?php echo $auction['Description']; ?></td>
                                        <td><?php echo $auction['Location']; ?></td>
                                        <td style="display: flex; margin-top: 10px;">
                                            <a href="editAuction.php?id=<?php echo $auction['AuctionID']; ?>" class="btn btn-primary">Edit</a>
                                            <form method="post" action="deleteAuction.php" style="margin-left: 10px;">
                                                <input type="hidden" name="id" value="<?php echo $auction['AuctionID']; ?>" />
                                                <button type="submit" name="delete_auction" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this auction?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
include('layouts/footer.php');
?>
<script>
    // Automatically hide the alert message after 3 seconds
    setTimeout(function() {
        document.querySelector('.alert').style.display = 'none';
    }, 3000);
</script>