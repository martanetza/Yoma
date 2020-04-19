<?php
require_once('db_conn.php');

try {
    $course_id = $_GET['course_id'];

    //delete items
    $q_module =  $conn->prepare('SELECT * FROM modules  WHERE course_id = :course_id');
    $q_module->bindValue(':course_id', $course_id);
    $q_module->execute();
    $data_module = $q_module->fetchAll();
    print_r($data_module);
    foreach ($data_module as $module) {
        $q_items =  $conn->prepare('DELETE FROM items  WHERE module_id = :module_id');
        $q_items->bindValue(':module_id',  $module->module_id);
        $q_items->execute();
    }
    //delete modules
    $q_modules_delete = $conn->prepare('DELETE FROM modules  WHERE course_id = :course_id');
    $q_modules_delete->bindValue(':course_id', $course_id);
    $q_modules_delete->execute();

    //delete courses
    $q = $conn->prepare('DELETE FROM courses  WHERE course_id = :course_id');
    $q->bindValue(':course_id', $course_id);
    $q->execute();

    echo 'Deleted rows' . $q->rowCount();
} catch (PDOException $e) {
    echo $e;
}

header('Location: my_courses.php');
