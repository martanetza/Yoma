<?php
require_once('../db_conn.php');

try {

    $sql = "CREATE TABLE Chosen_courses (
    course_id INT(6),
    user_email VARCHAR(50),
    start_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    progress INT(6),
    PRIMARY KEY( course_id, user_email) 
    )";

    $conn->exec($sql);
    echo "Table Chosen courses created successfully";
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
