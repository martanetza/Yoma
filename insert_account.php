<?php
require_once('db_conn.php');
$email = $_POST['email'];
$password = $_POST['password'];

try {

  $query_insert = $conn->prepare('INSERT INTO  users (email, password) VALUES(:email, :password)');
  $query_insert->bindValue(':email', $email);
  $query_insert->bindValue(':password', $password);
  $query_insert->execute();
  echo "Thank you for joining YOMA ! Your account has been successfully created";
} catch (PDOException $e) {
  echo $e->getMessage();
}
