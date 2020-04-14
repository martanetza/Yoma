<?php
require_once('../db_conn.php');

try {

    $sql = "CREATE TABLE Courses (
    course_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(30),
    course_desc VARCHAR(250),
    published_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    no_of_paparticipants INT(10),
    author_email VARCHAR(50)
    )";

    $conn->exec($sql);
    echo "Table Courses created successfully";
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
