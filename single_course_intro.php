<?php
require_once('db_conn.php');
require_once('has_access.php');
?>

<?php
$course_id = $_GET['course_id'];
$user_id = $_SESSION['email'];
try {

  $query_chosen_course = $conn->prepare('SELECT * FROM chosen_course WHERE course_id = :course_id AND user_email = :user_email');
  $query_chosen_course->bindValue(':course_id', $course_id);
  $query_chosen_course->bindValue(':user_email', $user_id);

  $query_chosen_course->execute();
  $row_chosen_course = $query_chosen_course->fetchAll();


  $q_courses = $conn->prepare('SELECT * FROM courses WHERE course_id=' . $course_id);
  $q_courses->execute();
  $courses_rows =  $q_courses->fetchAll();
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    <link rel="stylesheet" href="app.css" />

    <title>Document</title>
  </head>

  <body>
    <header>
      <div class="logo-container">
        <img src="img/yoma_logo.png" alt="" />
      </div>
      <?php
      require_once('nav.php');
      ?>
    </header>
    <main class="into-main">
      <form action="join_chosen_course.php" method="POST">
        <h1>
          <?= $courses_rows[0]->course_name; ?>
        </h1>
        <p> <?= $courses_rows[0]->course_desc; ?></p>
        <input type="hidden" name="course_id" id="chosen_course_id" value="<?= $course_id; ?>">
        <input type="hidden" name="user_id" id="user_id" value="<?= $user_id; ?>">
        <input type="hidden" name="continue" id="continue" value="<?= ($row_chosen_course) ? 'true' : 'false'; ?>">
        <input class="btn" type="submit" name="join_button" id="join_button" value="<?= ($row_chosen_course) ? 'continue' : 'join'; ?>" />
      </form>
    </main>
  </body>

  </html>
<?php
} catch (PDOException $e) {
  echo $e;
}

?>