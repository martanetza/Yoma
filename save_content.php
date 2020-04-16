<?php

require_once('db_conn.php');

try {
    // create course
    $course_name = $_POST['course_name'];
    $course_desc = $_POST['course_description'];
    $no_of_paparticipants = 0;
    $author_email = 'a@a.com';

    $query = $conn->prepare('INSERT INTO courses VALUES(null, :course_name, :course_desc, null, :no_of_paparticipants, :author_email)');
    $query->bindValue(':course_name', $course_name);
    $query->bindValue(':course_desc', $course_desc);
    $query->bindValue(':no_of_paparticipants', $no_of_paparticipants);
    $query->bindValue(':author_email', $author_email);
    $query->execute();
    $last_id = $conn->lastInsertId();
    echo "New record created successfully. Last inserted ID is: " . $last_id;

    $aModule_name = $_POST['module_title'];
    $aItems_number = $_POST['number_of_items'];
    $aLesson_title = $_POST['lesson_title'];
    $aLesson_exerpt = $_POST['lesson_exerpt'];
    $aLesson_description = $_POST['lesson_description'];

    // create modules


    $i = 0;
    $j = 0;
    $number_of_items_per_module = 0;
    print_r(count($aModule_name));
    for ($i; $i < count($aModule_name); $i++) {
        $number_of_items_per_module += $aItems_number[$i];
        print_r($number_of_items_per_module);
        $query_module = $conn->prepare("INSERT INTO modules VALUES(null, :module_name,  $last_id)");
        $query_module->bindValue(':module_name', $aModule_name[$i]);
        $query_module->execute();

        $last_module_id = $conn->lastInsertId();
        echo "New record created successfully. Last inserted ID is: " . $last_id;
        //create lessons 
        for ($j; $j < $number_of_items_per_module; $j++) {
            $query_lesson = $conn->prepare("INSERT INTO items VALUES(null, :lesson_title, :lesson_exerpt, :lesson_description,  $last_module_id)");
            $query_lesson->bindValue(':lesson_title', $aLesson_title[$j]);
            $query_lesson->bindValue(':lesson_exerpt', $aLesson_exerpt[$j]);
            $query_lesson->bindValue(':lesson_description', $aLesson_description[$j]);
            $query_lesson->execute();
        }
    }
} catch (PDOException $e) {
    echo $e;
}

header('Location: read.php?course_id=' . $last_id);
