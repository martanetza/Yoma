<?php
require_once('db_conn.php');
?>

<?php
try {
    $course_id = $_POST['course_id'];
    $user_id = $_POST['user_id'];
    $continue_true_or_false = $_POST['continue'];
    echo $course_id . ' ' . $user_id . ' ' .  $continue_true_or_false;
    if ($continue_true_or_false == 'false') {


        //if don't exist create a record 
        $query_chosen_course = $conn->prepare('INSERT INTO chosen_courses VALUES(:course_id, :user_email, null, null)');
        $query_chosen_course->bindValue(':course_id', $course_id);
        $query_chosen_course->bindValue(':user_email', $user_id);

        $query_chosen_course->execute();
        echo '123';
    } else {
        echo ' row already exist';
    }
    header('Location: single_course.php?course_id=' . $course_id);

?>
<?php


} catch (PDOException $e) {
    echo $e;
}

?>

