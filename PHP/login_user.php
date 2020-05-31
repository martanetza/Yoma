<?php
//Connect to the database
require_once('../db_conn.php');

$email = trim($_GET['email']);
$password = md5(trim($_GET['password']));

try {
    $sql = 'SELECT * FROM users WHERE email = :email';
    $statement = $conn->prepare($sql);
    $statement->bindValue('email', $email);
    $statement->execute();
    $result = $statement->fetchAll();
    if ($result) {
        $hash = $result[0]->password;
        if ($password == $hash) {
            session_start();
            $_SESSION['user_id'] = $result[0]->user_id;

            $q_log = $conn->prepare('CALL p_insert_login_row(:user_id) ');
            $q_log->bindValue(':user_id', $result[0]->user_id);
            $q_log->execute();
            exit();
        } else {
            echo 'The user eamil or password are not correct';
        }
    } else {
        echo 'The user eamil or password are not correct';
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
