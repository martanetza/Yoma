<?php

require_once('db_conn.php');

// calculate the progress

try {
    //check what course the module belonges to and how many modules is in the course

    $course_id = $_GET['course_id'];
    $user_email = 'f@f.com';
    $q_test_modules = $conn->prepare('SELECT * FROM modules WHERE course_id = :course_id');
    $q_test_modules->bindValue(':course_id', $course_id);
    $q_test_modules->execute();
    $count = $q_test_modules->rowCount();
    $percentage = (1 * 100) / $count;
    print_r($percentage);
    //update the progress
    $q_chosen_course_update = $conn->prepare('UPDATE chosen_course SET progress = progress + :add_percentage WHERE course_id = :course_id AND user_email = :user_email');
    $q_chosen_course_update->bindValue(':add_percentage', $percentage);
    $q_chosen_course_update->bindValue(':user_email', $user_email);
    $q_chosen_course_update->bindValue(':course_id', $course_id);

    $q_chosen_course_update->execute();
} catch (PDOException $exeption) {
    echo $exeption;
}
