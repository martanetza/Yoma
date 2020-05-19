<?php
require_once('db_conn.php');

$user_email = $_POST['user_email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$password = $_POST['password'];
$school = $_POST['school'];

try {
    $q_user = $conn->prepare("UPDATE users SET email = :email, first_name = :first_name, last_name = :last_name, password = :password, school = :school WHERE email =  :user_email");
    $q_user->bindValue(':email', $user_email);
    $q_user->bindValue(':first_name', $first_name);
    $q_user->bindValue(':last_name', $last_name);
    $q_user->bindValue(':password', $password);
    $q_user->bindValue(':school', $school);
    $q_user->bindValue(':user_email', $user_email);
    $q_user->execute();
    header('Location: user_profile.php');
} catch (PDOException $e) {
    echo $e;
}
