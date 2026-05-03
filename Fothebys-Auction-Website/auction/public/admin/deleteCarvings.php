<?php
session_start();
include('dbconnect.php');

if (isset($_POST['delete_carving'])) {
    $carvingID = $_POST['id'];

    try {
        $stmt = $pdo->prepare('DELETE FROM Carvings WHERE CarvingID = :carvingID');
        $stmt->bindParam(':carvingID', $carvingID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Carving Successfully Deleted!';
            // Redirect to Carvings.php using JavaScript
            echo '<script>window.location.href = "Carvings.php";</script>';
        } else {
            $_SESSION['message'] = 'Error Deleting Carving!';
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}
