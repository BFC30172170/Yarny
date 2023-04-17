<?php

// Connect to the local ecommerce database using admin creds from seed.sql

try {
    $host = "localhost";
    $user = "ecommadmin";
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