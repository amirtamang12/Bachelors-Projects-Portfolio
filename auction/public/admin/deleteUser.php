<?php
session_start();
include('dbconnect.php');

if (isset($_POST['delete_user'])) {
    $userId = $_POST['id'];

    try {
        $stmt = $pdo->prepare('DELETE FROM User WHERE userId = :userId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'User Successfully Deleted!';
        } else {
            $_SESSION['message'] = 'Error Deleting User!';
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }

    // Redirect to users.php using PHP header function
    header('Location: viewUser.php');
    exit();
}
