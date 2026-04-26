<?php
include 'header.php';
include 'admin/dbconnect.php';

// Check if the user is logged in as a buyer or admin
if (isset($_SESSION['userType']) && ($_SESSION['userType'] == 'buyer' || $_SESSION['userType'] == 'admin')) {
    // User is allowed to bid
    if (isset($_GET['id'])) {
        $itemId = $_GET['id']; // Adjust this based on how you get the item ID

        // Retrieve item details including the image URL and status from bids table
        try {
            $stmt = $pdo->prepare('SELECT i.*, a.AuctionDate, a.Location, b.Status AS ItemStatus
                             FROM Items i 
                             JOIN Auctions a ON i.AuctionID = a.AuctionID 
                             JOIN Bids b ON i.ItemID = b.ItemID
                             WHERE i.ItemID = ?');
            $stmt->execute([$itemId]);
            $item = $stmt->fetch(PDO::FETCH_ASSOC);

            // Display item details
            if ($item) {
                $lotNumber = $item['LotNumber']; // Get the LotNumber from the fetched item details

                echo '<div class="container">';
                echo '<div class="properties-listing spacer">';
                echo '<div class="row">';
                echo '<div class="col-lg-3 col-sm-4 hidden-xs">';
                // Sidebar with hot properties and advertisements
                // Add your hot properties and advertisements here
                echo '</div>';
                echo '<div class="col-lg-9 col-sm-8">';
                echo '<h2>Item Details</h2>';
                echo '<h3>Item Details</h3>';
                // Display the item image
                echo '<img src="' . $item['ImagePath'] . '" alt="Item Image" width="300">';
                echo '<p>Lot Number: ' . $lotNumber . '</p>'; // Use the LotNumber retrieved from the fetched item
                echo '<p>Estimated Price: $' . number_format($item['EstimatedPrice'], 2) . '</p>';
                echo '<p>Year Produced: ' . $item['YearProduced'] . '</p>';
                echo '<p>General Subject: ' . $item['GeneralSubject'] . '</p>';
                echo '<p>Auction Date: ' . $item['AuctionDate'] . '</p>';
                echo '<p>Auction Location: ' . $item['Location'] . '</p>';

                // Display the status
                $status = $item['ItemStatus'];
                if ($status == 'Sold') {
                    echo '<p>Status: Sold</p>';
                } else {
                    echo '<p>Status: ' . $status . '</p>';
                }

                // Display current bids for the item
                $currentBidsStmt = $pdo->prepare('SELECT b.Amount, b.BidTime
                                          FROM Bids b
                                          JOIN Items i ON b.ItemID = i.ItemID
                                          WHERE i.ItemID = ?
                                          ORDER BY b.Amount DESC, b.BidTime ASC');
                $currentBidsStmt->execute([$itemId]);
                $currentBids = $currentBidsStmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($currentBids)) {
                    echo '<h3>Current Bids</h3>';
                    echo '<ul>';
                    foreach ($currentBids as $bid) {
                        echo '<li>Bidder - $' . number_format($bid['Amount'], 2) . ' - ' . $bid['BidTime'] . '</li>';
                    }
                    echo '</ul>';

                    // Get the highest current bid
                    $highestBid = $currentBids[0]['Amount'];
                    
                    // Bidding Form with validation
                    echo '<h3>Place a Bid</h3>';
                    echo '<form method="post" action="placeBid.php">';
                    echo '  <input type="hidden" name="itemId" value="' . $itemId . '">';
                    echo '  <input type="number" name="bidAmount" placeholder="Bid Amount" min="' . ($highestBid + 1) . '">';
                    echo '  <button type="submit">Place Bid</button>';
                    echo '</form>';
                } else {
                    // No bids have been placed for this item yet, set the default bid amount to the estimated price
                    echo '<p>No bids have been placed for this item yet.</p>';
                    echo '<p>Starting Bid Amount: $' . number_format($item['EstimatedPrice'], 2) . '</p>';
                }

                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            } else {
                echo 'Item not found.';
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        echo 'Item ID is missing.';
    }
} else {
    // User is not logged in or not authorized to bid
    echo 'You must be logged in as a buyer or admin to place a bid.';
}

include 'footer.php';
