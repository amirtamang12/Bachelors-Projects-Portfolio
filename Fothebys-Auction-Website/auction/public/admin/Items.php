<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

try {
    $stmt = $pdo->prepare('SELECT * FROM Items');
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Items Table</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Items</li>
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
                        <h5 class="card-title">Items</h5>
                        <p>List of items. Click "Add" to add a new item.</p>
                        <a href="addItems.php"><button type="button" class="btn btn-success">Add</button></a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Item ID</th>
                                    <th scope="col">Lot Number</th>
                                    <th scope="col">Artist Name</th>
                                    <th scope="col">Year Produced</th>
                                    <th scope="col">General Subject</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Auction ID</th>
                                    <th scope="col">Estimated Price</th>
                                    <th scope="col">Image</th> <!-- Updated column name -->
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item) { ?>
                                    <tr>
                                        <td><?php echo $item['ItemID']; ?></td>
                                        <td><?php echo $item['LotNumber']; ?></td>
                                        <td><?php echo $item['ArtistName']; ?></td>
                                        <td><?php echo $item['YearProduced']; ?></td>
                                        <td><?php echo $item['GeneralSubject']; ?></td>
                                        <td><?php echo $item['Description']; ?></td>
                                        <td><?php echo $item['AuctionID']; ?></td>
                                        <td><?php echo '$' . number_format($item['EstimatedPrice'], 2); ?></td>
                                        <td><img src="assets/img/items/<?php echo $item['ImagePath']; ?>" alt="Item Image" width="100" height="100"></td> <!-- Display the image -->
                                        <td style="display: flex; margin-top: 10px;">
                                            <a href="editItems.php?id=<?php echo $item['ItemID']; ?>" class="btn btn-primary">Edit</a>
                                            <form method="post" action="deleteItems.php" style="margin-left: 10px;">
                                                <input type="hidden" name="id" value="<?php echo $item['ItemID']; ?>" />
                                                <button type="submit" name="delete_item" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
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