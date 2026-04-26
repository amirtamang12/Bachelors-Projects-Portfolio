<?php
include 'header.php';
include 'admin/dbconnect.php';

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

<div class="container">
    <div class="properties-listing spacer">
        <h2>Featured Products for Auction</h2>
        <div class="row">
            <?php foreach ($featuredItems as $item) : ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="properties">
                        <?php echo '<img class="card-img-top" src="admin/assets/img/items/' . $item['ImagePath'] . '" alt="Product image">'; ?>
                        <h4><a href="productDetail.php?id=<?php echo $item['ItemID']; ?>">Lot Number: <?php echo $item['LotNumber']; ?></a></h4>
                        <p class="price">Estimated Price: $<?php echo number_format($item['EstimatedPrice'], 2); ?></p>
                        <p>Year Produced: <?php echo $item['YearProduced']; ?></p>
                        <p>General Subject: <?php echo $item['GeneralSubject']; ?></p>
                        <p>Auction Date: <?php echo $item['AuctionDate']; ?></p>
                        <p>Auction Location: <?php echo $item['Location']; ?></p>
                        <a class="btn btn-primary" href="productDetail.php?id=<?php echo $item['ItemID']; ?>">View Details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>