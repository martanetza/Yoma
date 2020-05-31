<?php
require_once('../db_conn.php');
require_once('../has_access.php');

// calculate the progress

try {

    $course_id = $_GET['course_id'];
    $test_item_id = $_GET['test_item_id'];
    $user_id = $_SESSION['user_id'];
    //add item to the table with test entries history
    $q_test_entries = $conn->prepare('INSERT INTO test_entries_history VALUES(null, :test_item_id, :user_id, null)');
    $q_test_entries->bindValue(':test_item_id', $test_item_id);
    $q_test_entries->bindValue(':user_id', $user_id);
    $q_test_entries->execute();

    //check what course the module belonges to and how many modules is in the course

    $q_test_modules = $conn->prepare('SELECT * FROM modules WHERE course_id = :course_id');
    $q_test_modules->bindValue(':course_id', $course_id);
    $q_test_modules->execute();
    $count = $q_test_modules->rowCount();
    $percentage = (1 * 100) / $count;
    //update the progress
    $q_chosen_course_update = $conn->prepare('UPDATE chosen_course SET progress = progress + :add_percentage WHERE course_id = :course_id AND user_id = :user_id');
    $q_chosen_course_update->bindValue(':add_percentage', $percentage);
    $q_chosen_course_update->bindValue(':user_id', $user_id);
    $q_chosen_course_update->bindValue(':course_id', $course_id);

    $q_chosen_course_update->execute();
} catch (PDOException $exeption) {
    echo $exeption->getMessage();
}
