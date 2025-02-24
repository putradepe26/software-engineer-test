<?php
$host = 'localhost';
$db = 'db_fleet_management';
$user = 'root'; // Change as per your database configuration
$pass = ''; // Change as per your database configuration

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>