<?php
session_start();
include('dbconnect.php');

if (isset($_GET['id'])) {
    $bookingId = $_GET['id'];

    // Update the status to "Approved" in the database
    $stmt = $pdo->prepare('UPDATE bookings SET status = :status WHERE bookingId = :bookingId');
    $status = 'Approved'; // Set status to "Approved"
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Fetch booking details from the database
        $stmt = $pdo->prepare('SELECT bookings.*, packages.packageName, packages.noOfDays, packages.startDate, hotels.hotelName, vehicles.vehicalName, packages.packageDescription FROM bookings
                            LEFT JOIN packages ON bookings.packageId = packages.packageId
                            LEFT JOIN hotels ON bookings.hotelId = hotels.hotelId
                            LEFT JOIN vehicles ON bookings.vehicleId = vehicles.vehicleId
                            WHERE bookings.bookingId = :bookingId');
        $stmt->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
        $stmt->execute();
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($booking) {
            // Extract booking details
            $customerEmail = $booking['customerEmail'];
            $packageName = $booking['packageName'];
            $noOfDays = $booking['noOfDays'];
            $startDate = $booking['startDate'];
            $hotelName = $booking['hotelName'];
            $vehicalName = $booking['vehicalName'];
            $packageDescription = $booking['packageDescription'];
            $totalCost = $booking['totalCost'];

            // Compose email subject and message
            $subject = 'Booking Confirmation Details';
            $message = "Thank you for your booking!\n\n";
            $message .= "Booking ID: $bookingId\n";
            $message .= "Package Name: $packageName\n";
            $message .= "Number of Days: $noOfDays\n";
            $message .= "Start Date: $startDate\n";
            $message .= "Hotel: $hotelName\n";
            $message .= "Vehicle: $vehicalName\n";
            $message .= "Package Description: $packageDescription\n";
            $message .= "Total Cost: $$totalCost\n\n";
            $message .= "Enjoy your trip!\n";

            // Send email to the customer
            $headers = 'From: your_email@example.com' . "\r\n" .
                'Reply-To: your_email@example.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            if (mail($customerEmail, $subject, $message, $headers)) {
                // Email sent successfully
                $_SESSION['message'] = 'Booking confirmation email sent to the customer.';
            } else {
                // Email sending failed
                $_SESSION['message'] = 'Failed to send booking confirmation email.';
            }
        } else {
            $_SESSION['message'] = 'Booking not found.';
        }

        // Fetch the Confirm Booking count
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM bookings WHERE status = :status');
        $status = 'Approved'; // Set status to "Approved"
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();
        $confirmBookingCount = $stmt->fetchColumn();
        
        // Return the Confirm Booking count as JSON response
        echo json_encode(['confirmBookingCount' => $confirmBookingCount]);
    } else {
        $_SESSION['message'] = 'Error updating status to Approved.';
    }

    // Redirect back to the booking table or any appropriate page
    header('Location: bookingTable.php');
    exit();
} else {
    // Handle missing booking ID
    $_SESSION['message'] = 'Invalid booking ID.';
    header('Location: bookingTable.php');
    exit();
}
