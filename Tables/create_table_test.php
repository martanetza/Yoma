<?php
require_once('../db_conn.php');

try {

    $sql = "CREATE TABLE Test (
    test_item_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(100),
    option_a VARCHAR(100),
    option_b VARCHAR(100),
    option_c VARCHAR(100),
    option_d VARCHAR(100),
    module_id INT(6) UNSIGNED NOT NULL,
    CONSTRAINT module_id_ref
    FOREIGN KEY (module_id) REFERENCES modules (module_id)
    ON DELETE CASCADE
    ON UPDATE RESTRICT
    )";

    $conn->exec($sql);
    echo "Table with test items  created successfully";
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
