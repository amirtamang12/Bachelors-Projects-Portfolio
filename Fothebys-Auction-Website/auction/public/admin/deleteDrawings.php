<?php
session_start();
include('dbconnect.php');

if (isset($_POST['delete_drawing'])) {
    $DrawingID = $_POST['id'];

    try {
        $stmt = $pdo->prepare('DELETE FROM Drawings WHERE DrawingID = :DrawingID'); // Correct variable name
        $stmt->bindParam(':DrawingID', $DrawingID);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Drawing Successfully Deleted!';
            // Redirect to drawings.php using JavaScript
            echo '<script>window.location.href = "Drawings.php";</script>';
            exit(); // You should add an exit() statement to terminate script execution after the redirect
        } else {
            $_SESSION['message'] = 'Error Deleting Drawing!';
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}
