<?php

try {
    $dsn = "mysql:host=dataBase;dbname=demo_php;charset=utf8mb4";

    $db = new PDO(
        $dsn,
        'root',
        null,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch(PDOException $error) {
    die("Error: ".$error->getMessage());
}

