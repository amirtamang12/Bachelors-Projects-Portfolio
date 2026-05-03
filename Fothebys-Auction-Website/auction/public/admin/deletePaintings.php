<?php
session_start();
include('dbconnect.php');

if (isset($_POST['delete_painting'])) {
    $PaintingId = $_POST['id'];

    try {
        // Make sure to delete the painting from both the Paintings table and Items table
        $pdo->beginTransaction();

        // Delete from Paintings table
        $stmt = $pdo->prepare('DELETE FROM Paintings WHERE PaintingID = :PaintingID');
        $stmt->bindParam(':PaintingID', $PaintingID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Painting Successfully Deleted!';
            // Redirect to Carvings.php using JavaScript
            echo '<script>window.location.href = "Paintings.php";</script>';
        } else {
            $_SESSION['message'] = 'Error Deleting Paintings!';
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}
