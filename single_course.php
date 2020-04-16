<?php
require_once('db_conn.php');

$course_id = $_GET['course_id'];
$q_module = $conn->prepare('SELECT * FROM modules WHERE course_id=' . $course_id);
$q_module->execute();
$modules_rows = $q_module->fetchAll();
?>
<?php

try {
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
            <a href="">Courses</a>
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
    <main class="single-course-main">
      <div class="single-course-list">
        <div class="single-course-list-wrap">
          <?php foreach ($modules_rows as $row) : ?>
            <?php
            $q_items = $conn->prepare('SELECT * FROM items WHERE module_id=' . $row->module_id);
            $q_items->execute();
            $items_rows = $q_items->fetchAll();
            ?>
            <div class="module-list-element">
              <div onclick="openContent()" class="module-list-element-header">
                <div><?= $row->module_name; ?></div>
                <i class="fas fa-angle-right fa-1x"></i>
              </div>
              <div class="module-list-element-content">
                <?php
                foreach ($items_rows as $row) :
                ?>
                  <div class="item-list-element">
                    <div><?= $row->item_title; ?></div>
                    <i class="fas fa-arrow-right"></i>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="modal"></div>
    </main>
  </body>

  </html>
<?php
} catch (PDOException $e) {
  echo $e;
}

?>

<script>
  function openContent() {
    console.log("test")
  }
</script>