<?php
require '../../vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->test->messages;
$item_id = $_POST['item_id'];
$title = $_POST['comment_title'];
$message = $_POST['comment_message'];

$collection->insertOne(
    [
        "item_id" => (int) $item_id,
        "title" => $title,
        "message" => $message,
        "publish_date" => date("d/m/Y H:i:s")
    ]
);
