<?php

try {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $connect = 'mysql:host=localhost; dbname=YOMA; charset=utf8mb4';
    // set the PDO error mode to exception
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // allows to use try catch
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ //allows to use json obj
        // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC //allows to use assoc array
    ];
    $conn = new PDO($connect, $username, $password, $options);
} catch (PDOException $exeption) {
    echo $exeption;
}
