<?php
$sModuleTemplate = file_get_contents('templates/module-template.html');
$sLessonTemplate = file_get_contents('templates/lesson-template.html');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="CSS/admin.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
  <link rel="stylesheet" href="CSS/header.css" />

  <title>Document</title>
</head>

<body>
  <header>YOMA</header>
  <main class="main">
    <div class="sidebar-nav">
      <div class="sidebar-nav-element">
        <div>
          My profile
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </div>
      <div class="sidebar-nav-element">
        <a href="admin.php">
          My courses
        </a>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </div>
    </div>
    <div class="content-wrap">
      <form action="PHP/save_content.php" method="POST">
        <input id="submit-button" class="btn" type="submit" value="save" />
        <input id="course_title" name="course_name" type="text" placeholder="Course name" />
        <textarea placeholder="Course description" id="course_description" name="course_description"></textarea>
        <button onclick=" addModule()" id="add-module" class="add-module">add module</button>
        <div class="module-content">
          <div onclick="openModule()" class="module-header">
            <div>
              Module 1
            </div>
            <div>
              <i class="fas fa-chevron-down"></i>
            </div>
          </div>
          <div class="module-main">
            <input class="module-title" name="module_title[]" type="text" placeholder="Module title" oninput="chanegTitle()" />
            <input type="hidden" class="number_of_items" name="number_of_items[]" value="1">
            <div class="table table-test">
              <div class="table-row">
                <div class="col-question">Question</div>
                <div class="col-option">Option A</div>
                <div class="col-option">Option B</div>
                <div class="col-option">Option C</div>
                <div class="col-option">Option D</div>
                <div class="col-answer">Answer</div>
              </div>
              <div class="table-row">
                <div class="col-question">
                  <input class="question" name="question[]" type="text" placeholder="Question" />
                </div>
                <div class="col-option">
                  <input class="option_a" name="option_a[]" type="text" placeholder="Option A" />
                </div>
                <div class="col-option">
                  <input class="option_b" name="option_b[]" type="text" placeholder="Option B" />
                </div>
                <div class="col-option">
                  <input class="option_c" name="option_c[]" type="text" placeholder="Option C" />
                </div>
                <div class="col-option">
                  <input class="option_d" name="option_d[]" type="text" placeholder="Option D" />
                </div>
                <div class="col-answer">
                  <select name="answer[]" class="answer-select">
                    <option value="">choose</option>
                    <option value="a">a</option>
                    <option value="b">b</option>
                    <option value="c">c</option>
                    <option value="d">d</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="table module-items-template">
              <div class="table-row">
                <div class="col-title">Title</div>
                <div class="col-exerpt">Exerpt</div>
                <div class="col-description">Text content</div>
                <div class="col-image">Image url</div>
              </div>
              <div class="table-row">
                <div class="col-title">
                  <input class="lesson_title" name="lesson_title[]" type="text" placeholder="Lesson title" />
                </div>
                <div class="col-exerpt">
                  <textarea placeholder="Lesson exerpt" class="lesson_exerpt" name="lesson_exerpt[]"></textarea>
                </div>
                <div class="col-description">
                  <textarea placeholder="Lesson description" class="lesson_description" name="lesson_description[]"></textarea>
                </div>
                <div class="col-image">Image url</div>
              </div>
            </div>
            <button onclick="addLesson()" id="add_lesson" class="add-lesson">Add lesson</button>
          </div>
        </div>
      </form>
    </div>
  </main>
</body>

</html>
<script>
  var moduleTemplate = `<?php echo $sModuleTemplate; ?>`;
  var lessonTemplate = `<?php echo $sLessonTemplate; ?>`;
</script>
<script src="JS/add_course.js"></script>