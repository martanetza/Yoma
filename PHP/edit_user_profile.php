<?php
require_once('../db_conn.php');

$user_email = trim($_POST['user_email']);
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$password = trim($_POST['password']);
$school = trim($_POST['school']);

try {
    $q_user = $conn->prepare("UPDATE users SET email = :email, first_name = :first_name, last_name = :last_name, school = :school WHERE email =  :user_email");
    $q_user->bindValue(':email', $user_email);
    $q_user->bindValue(':first_name', $first_name);
    $q_user->bindValue(':last_name', $last_name);
    // $q_user->bindValue(':password', $password);
    $q_user->bindValue(':school', $school);
    $q_user->bindValue(':user_email', $user_email);
    $q_user->execute();

    if ($password) {
        $q_user_for_password = $conn->prepare("UPDATE users SET password = :password");
        $q_user_for_password->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
        $q_user_for_password->execute();
    }
} catch (PDOException $e) {
    echo $e;
}
