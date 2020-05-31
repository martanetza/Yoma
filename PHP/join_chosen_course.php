<?php
require_once('../db_conn.php');
require_once('../has_access.php');

?>

<?php
try {
    $course_id = $_POST['course_id'];
    $user_id = $_POST['user_id'];
    $continue_true_or_false = $_POST['continue'];
    echo $course_id . ' ' . $user_id . ' ' .  $continue_true_or_false;
    if ($continue_true_or_false == 'false') {


        //if don't exist create a record 
        $query_chosen_course = $conn->prepare('INSERT INTO chosen_course VALUES(:course_id, :user_id, null, 0.00)');
        $query_chosen_course->bindValue(':course_id', $course_id);
        $query_chosen_course->bindValue(':user_id', $user_id);

        $query_chosen_course->execute();

        $query_update_course = $conn->prepare('CALL users_plus(:course_id) ');
        $query_update_course->bindValue(':course_id', $course_id);
        $query_update_course->execute();
    } else {
        echo ' row already exist';
    }
    header('Location: ../single_course.php?course_id=' . $course_id);

?>
<?php


} catch (PDOException $e) {
    echo $e;
}

?>

