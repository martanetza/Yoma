<?php
require_once('db_conn.php');

try {

    // sql to create table
    $sql = "CREATE TABLE Users (
    email VARCHAR(50) PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    surname VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL,
    school VARCHAR(50),
    bio VARCHAR(250),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Table Users created successfully";
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
