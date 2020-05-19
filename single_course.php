<?php
require_once('db_conn.php');
require_once('has_access.php');

$user_id = $_SESSION['email'];
$course_id = $_GET['course_id'];
$test_template = file_get_contents("test-template.html");
?>
<?php

try {
  $query_chosen_course = $conn->prepare('SELECT progress FROM chosen_course WHERE course_id = :course_id AND user_email = :user_email');
  $query_chosen_course->bindValue(':course_id', $course_id);
  $query_chosen_course->bindValue(':user_email', $user_id);

  $query_chosen_course->execute();
  $row_chosen_course = $query_chosen_course->fetchAll();
  $progress = $row_chosen_course[0]->progress;

  $q_module = $conn->prepare('SELECT * FROM modules WHERE course_id=' . $course_id);
  $q_module->execute();
  $modules_rows = $q_module->fetchAll();
  $count =  $q_module->rowCount();
  $open_lock_number = $progress / (100 / $count);


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
    <main class="single-course-main">
      <div class="single-course-list">
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

                  <div onclick="fetchSingleItemContent(<?= $row->item_id; ?>)" class="item-list-element">
                    <div><?= $row->item_title; ?></div>
                    <i class="fas fa-arrow-right"></i>
                  </div>
                <?php endforeach; ?>
                <div onclick="fetchTest(<?= $row->module_id . ',' . $course_id . ',' . $modules_rows[$key + 1]->module_id; ?>)" class="item-list-element">
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
        <h1>
          <?= $item[0]->item_title ?>
        </h1>
        <p>
          <?= $item[0]->item_content ?>
        </p>

      </div>
    </main>
  </body>

  </html>
<?php
} catch (PDOException $e) {
  echo $e;
}

?>

<script>
  document.querySelector(".module-list-element-content").classList.add("show");

  function openContent(moduleId, locked) {
    console.log(event.target)
    if (locked == 0) {
      document.querySelector("#content-module-" + moduleId).classList.toggle("show");
    }
  }


  function fetchSingleItemContent(itemId) {
    async function fetchingData() {
      var jResponse = await fetch(`get_single_item.php?item_id=${itemId}`);
      var jData = await jResponse.json();
      console.log(jData);
      document.querySelector('.modal').innerHTML = `<h1>${jData[0].item_title}</h1><p>${jData[0].item_content}</p>`

    }
    fetchingData();

  }


  function fetchTest(module_id, course_id, next_module_id) {
    var test_template = `<?= $test_template; ?>`
    var test_template_copy = test_template;
    console.log(module_id)
    async function fetchingDataTest(module_id) {
      var jResponse = await fetch(`get_single_test_item.php?module_id=${module_id}`);
      var jData = await jResponse.json();
      console.log(jData);
      test_template_copy = test_template_copy.replace("::Question::", jData[0].question);
      test_template_copy = test_template_copy.replace("::answer_A::", jData[0].option_a);
      test_template_copy = test_template_copy.replace("::answer_B::", jData[0].option_b);
      test_template_copy = test_template_copy.replace("::answer_C::", jData[0].option_c);
      test_template_copy = test_template_copy.replace("::answer_D::", jData[0].option_d);

      document.querySelector('.modal').innerHTML = test_template_copy;
      controlCheckboxes()
      document.querySelector('.submit-btn').addEventListener('click', () => {
        validateTheAnswer(jData, course_id, next_module_id)
      })
    }
    fetchingDataTest(module_id)
  }


  function controlCheckboxes() {
    var allOptions = document.querySelectorAll('#answer_A, #answer_B, #answer_C, #answer_D')
    allOptions.forEach(e => {
      console.log(e)
      e.addEventListener('input', () => {
        allOptions.forEach(elm => {
          if (e.id !== elm.id) {
            elm.checked = false
          }
        })
      })
    })
  }

  function validateTheAnswer(data, courseID, next_module_id) {
    var allOptions = document.querySelectorAll('#answer_A, #answer_B, #answer_C, #answer_D')
    allOptions.forEach(elm => {
      console.log(elm.value, data[0].answer, elm.checked)
      if (elm.value == data[0].answer && elm.checked) {
        document.querySelector('.modal .test-container').innerHTML = '<div class="message"> <p>Congratualtions your answer was correct you can move now to the next module <p> </div>';
        document.querySelector('#header-module-' + next_module_id).setAttribute('onclick', `openContent(${next_module_id},0)`);
        document.querySelector('#header-module-' + next_module_id + ' .lock').innerHTML = '<i class="fas fa-lock-open"></i>'
        console.log(document.querySelector('#header-module-' + next_module_id))
        save_progress(courseID);
      } else if (elm.value !== data[0].answer && elm.checked) {
        document.querySelector('.modal .test-container').innerHTML = '<div class="message"> <p>Wrong<p> </div>';

      }

    })
  }

  function save_progress(courseID) {
    (async function() {
      var jResponse = await fetch(`save_progress.php?course_id=${courseID}`);

    })();
  }
</script>