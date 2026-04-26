<?php
session_start();
include('dbconnect.php');

if (isset($_POST['delete_sculpture'])) {
    $sculptureID = $_POST['id']; // Assuming the name of the input field is 'id'

    try {
        $stmt = $pdo->prepare('DELETE FROM Sculptures WHERE SculptureID = :SculptureID');
        $stmt->bindParam(':SculptureID', $sculptureID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Sculpture Successfully Deleted!';
            // Redirect to Sculptures.php using JavaScript
            echo '<script>window.location.href = "Sculptures.php";</script>';
            exit(); // Terminate script execution after the redirect
        } else {
            $_SESSION['message'] = 'Error Deleting Sculpture!';
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}
