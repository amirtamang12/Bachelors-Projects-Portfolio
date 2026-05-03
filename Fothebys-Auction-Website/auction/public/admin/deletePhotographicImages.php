<?php
session_start();
include('dbconnect.php');

if (isset($_POST['delete_photo'])) {
    $photoID = $_POST['id']; // Assuming the name of the input field is 'photoID'

    try {
        $stmt = $pdo->prepare('DELETE FROM PhotographicImages WHERE PhotoID = :PhotoID');
        $stmt->bindParam(':PhotoID', $photoID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Photographic Image Successfully Deleted!';
            // Redirect to PhotographicImages.php using JavaScript
            echo '<script>window.location.href = "PhotographicImages.php";</script>';
            exit(); // Terminate script execution after the redirect
        } else {
            $_SESSION['message'] = 'Error Deleting Photographic Image!';
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}
