<?php
require_once('../db_conn.php');
$email = $_GET['email'];

try {

    $q_user = $conn->prepare('SELECT email FROM users WHERE email = :email');
    $q_user->bindValue(':email', $email);
    $q_user->execute();
    $result = $q_user->rowCount();
    if ($result == 1) {
        echo 'The email already exist';
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
