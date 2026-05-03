<?php
try {
    //Start a new session
    //session_start();
    // Connecting to the database
    $hostname = 'db';
    $username = 'admin';
    $password = 'acution';
    $dbname = 'auction';

    // Connecting to the database
    $pdo = new PDO("mysql:dbname=$dbname;host=$hostname", $username, $password);

    // Rest of your code
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
