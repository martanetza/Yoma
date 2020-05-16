<?php
require_once('db_conn.php');
require_once('has_access.php');

// $course_id = $_GET['course_id'];
$user_id = $_SESSION['email'];
?>
<?php

try {

  $q_chosen_course = $conn->prepare('SELECT * FROM chosen_course INNER JOIN courses ON chosen_course.course_id = courses.course_id INNER JOIN users ON chosen_course.user_email = users.email  WHERE chosen_course.user_email = :email');
  $q_chosen_course->bindValue(':email', $user_id);
  $q_chosen_course->execute();
  $courses_rows = $q_chosen_course->fetchAll();

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
      <nav>
        <ul>
          <li>
            <a href="index.php">Courses</a>
          </li>
          <li>
            <a href="">About</a>
          </li>
          <li>
            <a href="">Login</a>
          </li>
        </ul>
      </nav>
    </header>
    <main class="main-profile">
      <h2>Profile</h2>
      <div class="user-profile-content">
        <div class="profile-info">
          <h4><?= $courses_rows[0]->name; ?></h4>
        </div>
        <div class="user-course-list">
          <?php
          foreach ($courses_rows as $row) :
          ?>
            <div class="user-course-list-item">
              <div class="user-course-list-wrapper">
                <h4 class="course-name"><?= $row->course_name; ?></h4>
                <div class="continue-btn">
                  <form action="join_chosen_course.php" method="POST">
                    <input type="hidden" name="course_id" id="chosen_course_id" value="<?= $row->course_id; ?>">
                    <input type="hidden" name="user_id" id="user_id" value="<?= $user_id; ?>">
                    <input type="hidden" name="continue" id="continue" value="<?= ($row_chosen_course) ? 'true' : 'false'; ?>">
                    <input class="btn" type="submit" name="join_button" id="join_button" value="continue" />
                  </form>
                </div>
                <div class="progress-bar">
                  <div class="progress" style="width: <?= $row->progress . '%'; ?>"></div>
                </div>
              </div>
            </div>
          <?php
          endforeach;
          ?>
        </div>
      </div>
    </main>
  </body>

  </html>

<?php
} catch (PDOException $e) {
  echo $e;
}
?>