<?php
require_once('../db_conn.php');

try {

    $sql = "CREATE TABLE Items (
    item_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    item_title VARCHAR(80),
    item_excerpt VARCHAR(200),
    item_content VARCHAR(2000),
    module_id INT(6)
    )";

    $conn->exec($sql);
    echo "Table Items created successfully";
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
