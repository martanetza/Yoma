<?php
require_once('db_conn.php');
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
<?php
try {

  $q = $conn->prepare('SELECT * FROM courses');
  $q->execute();
  $data = $q->fetchAll();

?>

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
    <main class="index-main">
      <div class="course-list-wrap">
        <?php
        foreach ($data as $course_row) :
        ?>
          <a href="single_course_intro.php?course_id=<?= $course_row->course_id; ?>" class="course-list-item">
            <div class="item-wrap">
              <div><?= $course_row->course_name; ?></div>
              <i class="fas fa-arrow-right"></i>
            </div>
          </a>
        <?php
        endforeach;
        ?>
      </div>
    </main>
  <?php
} catch (PDOException $e) {
  echo $e;
}

  ?>
  </body>

</html>