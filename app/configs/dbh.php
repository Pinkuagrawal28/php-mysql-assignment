<?php

$host       = 'localhost';
$dbname     = 'example_db';
$dbusername = 'root';
$dbpassword = 'shanti28';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
} catch (PDOException $e) {
    die("Connection Failed:" . $e->getMessage());
}
