<?php

require_once('db_conn.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/minify-js/all.min.js"></script>
  <link rel="stylesheet" href="minify-css/app.css" />
  <link rel="stylesheet" href="minify-css/header.css" />


  <title>Document</title>
</head>
<?php
try {

  $q = $conn->prepare('SELECT * FROM courses');
  $q->execute();
  $data = $q->fetchAll();

?>

  <body>


    <?php
    require_once('nav.php');
    ?>
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