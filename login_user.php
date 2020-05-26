<?php
//Connect to the database
require_once('db_conn.php');

$email = trim($_GET['email']);
$password = trim($_GET['password']);
try {
    // $password = md5($password); //encript password before comparing 
    $sql = 'SELECT * FROM users WHERE email = :email AND password = :password';
    $statement = $conn->prepare($sql);
    $statement->bindValue('email', $email);
    $statement->bindValue('password', $password);
    $statement->execute();
    $result = $statement->fetchAll();
    if (!empty($result)) {
        session_start();
        $_SESSION['user_id'] = $result[0]->user_id;
        // $q_log = $conn->prepare('INSERT INTO login_history VALUES(null, :id, null)');
        // $q_log->bindValue(':email', $result[0]->user_id);
        // $q_log->execute();
        $q_log = $conn->prepare('CALL p_insert_login_row(:user_id) ');
        $q_log->bindValue(':user_id', $result[0]->user_id);
        $q_log->execute();
        exit();
    } else {
        echo 'The user eamil or password are not correct';
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
