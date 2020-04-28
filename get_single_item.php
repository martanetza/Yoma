<?php
require_once('db_conn.php');

try {
    $item_id = $_GET['item_id'];


    $q_item = $conn->prepare('SELECT * FROM items WHERE item_id = :item_id');
    $q_item->bindValue(':item_id', $item_id);
    $q_item->execute();
    $item = $q_item->fetchAll();

    echo json_encode($item);
} catch (PDOException $exeption) {
    echo $exeption;
}
