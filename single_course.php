<?php
require_once('db_conn.php');
require_once('has_access.php');

$user_id = $_SESSION['user_id'];
$course_id = $_GET['course_id'];
$test_template = file_get_contents("templates/test-template.html");
$comment_template = file_get_contents("templates/comments-template.html");
?>
<?php

try {
  $q_courses = $conn->prepare('SELECT * FROM courses WHERE course_id=' . $course_id);
  $q_courses->execute();
  $courses_rows =  $q_courses->fetchAll();

  $query_chosen_course = $conn->prepare('SELECT progress FROM chosen_course WHERE course_id = :course_id AND user_id = :user_id');
  $query_chosen_course->bindValue(':course_id', $course_id);
  $query_chosen_course->bindValue(':user_id', $user_id);

  $query_chosen_course->execute();
  $row_chosen_course = $query_chosen_course->fetchAll();
  $progress = $row_chosen_course[0]->progress;

  $q_module = $conn->prepare('SELECT * FROM modules WHERE course_id=' . $course_id);
  $q_module->execute();
  $modules_rows = $q_module->fetchAll();
  $count =  $q_module->rowCount();
  $open_lock_number = round($progress / (100 / $count)) + 1;


  $q_module_join = $conn->prepare('SELECT * FROM items LEFT JOIN modules ON items.module_id = modules.module_id WHERE course_id=' . $course_id);
  $q_module_join->execute();
  $modules_rows_join = $q_module_join->fetchAll();





?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    <link rel="stylesheet" href="CSS/app.css" />
    <link rel="stylesheet" href="minify-css/header.css" />
    <link rel="stylesheet" href="CSS/footer.css" />
    <link rel="stylesheet" href="CSS/additional.css" />



    <title>Document</title>
  </head>

  <body>

    <?php
    require_once('nav.php');
    ?>
    <main class="single-course-main">
      <div class="single-course-list">
        <div class="course-title">
          <a href="all_courses.php">
            <i class="fas fa-chevron-left"></i>
          </a>
          <h1><?= $courses_rows[0]->course_name ?></h1>
        </div>
        <div class="single-course-list-wrap">
          <?php foreach ($modules_rows as $key => $row) : ?>
            <?php
            $q_items = $conn->prepare('SELECT * FROM items WHERE module_id=' . $row->module_id . ' ORDER BY item_id ASC');
            $q_items->execute();
            $items_rows = $q_items->fetchAll();

            ?>
            <div class="module-list-element">
              <?php
              if ($key == 0 || $key <= $open_lock_number - 1) {
                $locked = 0;
                $lock = '<i class="fas fa-lock-open"></i>';
              } else {
                $locked = 1;
                $lock = '<i class="fas fa-lock"></i>';
              }
              ?>
              <div onclick="openContent(<?= $row->module_id . ',' . $locked; ?>)" id="header-module-<?= $row->module_id; ?>" class="module-list-element-header">
                <div class="name-container">
                  <div class="lock"><?= $lock; ?></div>
                  <div><?= $row->module_name; ?></div>
                </div>
                <i class="fas fa-angle-right fa-1x"></i>
              </div>
              <div id="content-module-<?= $row->module_id; ?>" class="module-list-element-content">
                <?php
                foreach ($items_rows as $row) :
                ?>

                  <div onclick="fetchSingleItemContent(<?= $row->item_id; ?>)" class="item-list-element element-<?= $row->item_id; ?>">
                    <div><?= $row->item_title; ?></div>
                    <i class="fas fa-arrow-right"></i>
                  </div>
                <?php endforeach; ?>
                <div onclick="fetchTest(<?= $row->module_id . ',' . $course_id ?> <?= ($key < count($modules_rows) - 1) ? ',' . $modules_rows[$key + 1]->module_id : '' ?>)" class="item-list-element">
                  <div>Test</div>
                  <i class="fas fa-arrow-right"></i>
                </div>
              </div>
              <div>

              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="modal">
        <?php
        $q_item = $conn->prepare('SELECT * FROM items WHERE module_id= :module_id LIMIT 1');
        $q_item->bindValue(':module_id', $modules_rows[0]->module_id);
        $q_item->execute();
        $item = $q_item->fetchAll();
        ?>
        <div class="go-back">
          <i class="fas fa-angle-left fa-2x"></i>
        </div>
        <button onclick="openComments(<?= $item[0]->item_id; ?>)" class="btn comments-btn"><i class="far fa-comments"></i> comments</button>
        <h1>
          <?= $item[0]->item_title; ?>
        </h1>
        <p>
          <?= $item[0]->item_content; ?>
        </p>

      </div>
    </main>
    <?php require_once('footer.php') ?>

  </body>

  </html>
<?php
} catch (PDOException $e) {
  echo $e;
}

?>
<script>
  //script for comments mongodb

  var test_template = `<?= $test_template; ?>`;
  var comment_template = `<?= $comment_template; ?>`;
</script>
<script src="JS/single_course.js"></script>
<script>
  let commentContent =
    `<h2 class="comment-title"> Comments </h2>`


  function openComments(item_id) {
    let insert_comment_form = `
    <form class="comment-form" onsubmit="return false">
    <input type="hidden" name="item_id" value="${item_id}">
    <input type="text" name="comment_title" placeholder="Comment title">
    <textarea name="comment_message" placeholder="Here you can add your comment"></textarea>
    <input onclick="post_comment(${item_id})" class="btn comments-btn" type="submit" value="publish"
    </form>
    `
    document.querySelector(".modal").innerHTML = commentContent
    document.querySelector(".modal").innerHTML += insert_comment_form
    var comment_template_copy = comment_template;
    (async function fetchingData() {
      var jResponse = await fetch(`php/mongodb/read_comments.php?id=${item_id}`);
      var jData = await jResponse.json();
      console.log(jData);
      for (i = 0; i < jData.length; i++) {
        comment_template_title = comment_template.replace(
          "::Title::",
          jData[i].title
        );
        comment_template_message = comment_template_title.replace(
          "::message::",
          jData[i].message
        );
        comment_template_date = comment_template_message.replace(
          "::Date::",
          jData[i].publish_date
        );
        document.querySelector(".modal").innerHTML += comment_template_date;

      }
    })();

  }

  function post_comment(item_id) {
    var oForm = document.querySelector(".comment-form");
    (async function() {
      var id = event.target.dataset.toedit;
      console.log(id);
      var jConnection = await fetch("php/mongodb/insert_comment.php", {
        method: "POST",
        body: new FormData(oForm)
      });
      openComments(item_id)
    })();
  }

  // script applying color
</script>