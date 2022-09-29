<?php
    $DB_HOST = "127.0.0.1";
    $DB_PORT = "80";
    $DB_USER = "root";
    $DB_PASS = "";
    $DB_DATABASE = "example_workshop";
    $DB_CHARSET = "utf8";

    $connection = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_DATABASE);

    $pdo = new PDO(
        "mysql:host=$DB_HOST;dbname=$DB_DATABASE;charset=$DB_CHARSET", $DB_USER, $DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NAMED
        ]
    );
?>