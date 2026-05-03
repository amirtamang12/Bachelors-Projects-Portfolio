<?php
session_start();
include 'admin/dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['itemId']) && isset($_POST['bidAmount'])) {
        // Get the item ID and bid amount from the form
        $itemId = $_POST['itemId'];
        $bidAmount = $_POST['bidAmount'];

        // Check if the user is logged in and has an allowed user type
        if (isset($_SESSION['userId']) && isset($_SESSION['userType']) &&
            ($_SESSION['userType'] == 'buyer' || $_SESSION['userType'] == 'buyer & seller' || $_SESSION['userType'] == 'admin')) {

            // User is allowed to bid, insert the bid with the logged-in user's ID
            $userId = $_SESSION['userId'];

            // Insert the bid into the Bids table without the username
            try {
                $stmt = $pdo->prepare('INSERT INTO Bids (ItemID, UserID, Amount) VALUES (?, ?, ?)');
                $stmt->execute([$itemId, $userId, $bidAmount]);

                // Redirect back to the item details page
                header('Location: productDetail.php?id=' . $itemId);
                exit();
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
        } else {
            echo 'You must be logged in as a buyer, buyer & seller, or admin to place a bid.';
        }
    } else {
        echo 'Invalid request. Please provide both item ID and bid amount.';
    }
} else {
    echo 'Invalid request method.';
}
