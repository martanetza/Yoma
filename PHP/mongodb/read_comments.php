<?php

$item_id = (int) $_GET['id'];
require '../../vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->test->messages;

$result = $collection->find(
    ['item_id' => $item_id],
    ['sort' => ['publish_date' => -1]]
);

$arr = [];
foreach ($result as $entry) {
    array_push($arr, $entry);
}
echo json_encode($arr);
