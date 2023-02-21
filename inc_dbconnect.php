<?php

try {
    $host = "localhost";
    $user = "root";
    $pass = "password";
    $dbname = "ecommerce";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    $con = new PDO("mysql:host=$host;dbname=$dbname;charset-utf8mb4;",$user,$pass,$options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}