<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Check if an admin is logged in
if (isset($_SESSION['userType']) && $_SESSION['userType'] == 'admin') {
    try {
        $stmt = $pdo->prepare('SELECT b.BidID, i.LotNumber, i.GeneralSubject, b.Amount, b.BidTime, u.userName, b.Status
                               FROM Bids b
                               LEFT JOIN Items i ON b.ItemID = i.ItemID
                               LEFT JOIN User u ON b.UserID = u.userId');
        $stmt->execute();
        $bids = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }

    // Handle status update when an admin confirms a bid
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_bid'])) {
        $bidId = $_POST['bid_id'];

        try {
            // Update the bid status to 'Sold'
            $updateStatusStmt = $pdo->prepare('UPDATE Bids SET Status = "Sold" WHERE BidID = ?');
            $updateStatusStmt->execute([$bidId]);

            $_SESSION['message'] = 'Bid has been confirmed as sold.';
            echo '<script>window.location.href = "auctionBid.php";</script>'; // Redirect back to the bids page
            exit();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
} else {
    // If not an admin, display an error message
    echo 'You must be logged in as an admin to access this page.';
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Bids Table</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Bids</li>
                <li class="breadcrumb-item active">Bids Table</li>
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
                        <h5 class="card-title">Bids Table</h5>
                        <p>View and confirm bids.</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Bid ID</th>
                                    <th scope="col">Lot Number</th>
                                    <th scope="col">General Subject</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Bid Time</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($bids as $bid) {
                                    echo '<tr>';
                                    echo '<td>' . $bid['BidID'] . '</td>';
                                    echo '<td>' . $bid['LotNumber'] . '</td>';
                                    echo '<td>' . $bid['GeneralSubject'] . '</td>';
                                    echo '<td>' . $bid['Amount'] . '</td>';
                                    echo '<td>' . $bid['BidTime'] . '</td>';
                                    echo '<td>' . $bid['userName'] . '</td>';
                                    echo '<td>' . $bid['Status'] . '</td>';
                                    echo '<td>';
                                    if ($bid['Status'] == 'Pending') {
                                        echo '<form method="post" action="">
                                                <input type="hidden" name="bid_id" value="' . $bid['BidID'] . '" />
                                                <button type="submit" name="confirm_bid" class="btn btn-success">Confirm</button>
                                            </form>';
                                    }
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
include('layouts/footer.php')
?>
<script>
    // Automatically hide the alert message after 3 seconds
    setTimeout(function() {
        document.querySelector('.alert').style.display = 'none';
    }, 3000);
</script>