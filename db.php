<?php

// Database connection settings
$host = 'localhost';
$db = 'askuni';
$user = 'root';
$pass = '';

try {
    // Create new PDO instance with DSN (Data Source Name)
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // stop execution and display error message if connection fails
    die("Could not connect to the database: " . $e->getMessage());
}
