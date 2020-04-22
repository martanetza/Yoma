<?php
require_once('../db_conn.php');


try {

    $sql = "CREATE TABLE Authors (
    email VARCHAR(50) PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    surname VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL,
    bio VARCHAR(250),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    $conn->exec($sql);
    echo "Table Authors created successfully";
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
