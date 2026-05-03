<?php
session_start();
include('dbconnect.php');

if (isset($_POST['delete_auction'])) {
    $AuctionID = $_POST['id'];
    
    try {
        $stmt = $pdo->prepare('DELETE FROM Auctions WHERE AuctionID = :AuctionID');
        $stmt->bindParam(':AuctionID', $AuctionID);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Auction Successfully Deleted!';
            // Redirect to auctions.php using JavaScript
            echo '<script>window.location.href = "auctions.php";</script>';
        } else {
            $_SESSION['message'] = 'Error Deleting Auction!';
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}
