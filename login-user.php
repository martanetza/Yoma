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
        print_r($result);
        session_start();
        $_SESSION['email'] = $email;
        header('Location: index.php');
        exit();
    } else {
        echo 'The user eamil or password are not correct';
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
