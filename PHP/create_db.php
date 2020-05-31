<?php

try {
    $servername = "localhost";
    $username = "root";
    $password = "";
    // set the PDO error mode to exception
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // allows to use try catch
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ //allows to use json obj
    ];
    $conn = new PDO("mysql:host=$servername", $username, $password, $options); //this functions takes several arguments: connection, user name and password
    $sql = "CREATE DATABASE YOMA";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Database created successfully<br>";
} catch (PDOException $exeption) {
    echo $sql . "<br>" . $exeption->getMessage();
}

$conn = null;
