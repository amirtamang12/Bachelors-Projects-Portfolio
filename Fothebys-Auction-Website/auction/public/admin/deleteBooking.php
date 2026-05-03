<?php
session_start();
include('dbconnect.php');

if (isset($_POST['delete_booking'])) {
    $bookingId = $_POST['id'];
    
    try {
        $stmt = $pdo->prepare('DELETE FROM bookings WHERE bookingId = :bookingId');
        $stmt->bindParam(':bookingId', $bookingId);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Booking Successfully Deleted!';
            // Redirect to packages.php using JavaScript
            echo '<script>window.location.href = "booking.php";</script>';
        } else {
            $_SESSION['message'] = 'Error Deleting Booking!';
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}
