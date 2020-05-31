<?php
require_once('../db_conn.php');

try {
    $module_id = $_GET['module_id'];


    $q_test_item = $conn->prepare('SELECT * FROM test WHERE module_id = :module_id');
    $q_test_item->bindValue(':module_id', $module_id);
    $q_test_item->execute();
    $item = $q_test_item->fetchAll();

    echo json_encode($item);
} catch (PDOException $exeption) {
    echo $exeption;
}
