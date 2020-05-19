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
        $_SESSION['email'] = $email;
        $q_log = $conn->prepare('INSERT INTO login_history VALUES(null, :email, null)');
        $q_log->bindValue(':email', $email);
        $q_log->execute();

        exit();
    } else {
        echo 'The user eamil or password are not correct';
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}