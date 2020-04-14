<?php
require_once('../db_conn.php');

try {

    $sql = "CREATE TABLE Modules (
    module_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    module_name VARCHAR(80),
    course_id INT(6)
    )";

    $conn->exec($sql);
    echo "Table Modules created successfully";
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
