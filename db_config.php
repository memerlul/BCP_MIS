<?php
$host = 'localhost';  // Database host
$dbname = 'school_mis';  // Database name
$username = 'root';  // Database username
$password = '';  // Database password

try {
    // Create a PDO instance to connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exception
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
