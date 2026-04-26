<?php
session_start();
include('dbconnect.php');

if (isset($_POST['delete_item'])) {
    $ItemID = $_POST['id'];

    try {
        $stmt = $pdo->prepare('DELETE FROM Items WHERE ItemID = :ItemID');
        $stmt->bindParam(':ItemID', $ItemID);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Item Successfully Deleted!';
            // Redirect to items.php using JavaScript
            echo '<script>window.location.href = "items.php";</script>';
        } else {
            $_SESSION['message'] = 'Error Deleting Item!';
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}
