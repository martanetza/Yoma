<?php
$sModuleTemplate = file_get_contents('module-template.html');
$sLessonTemplate = file_get_contents('lesson-template.html');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="admin.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>

  <title>Document</title>
</head>

<body>
  <header>YOMA</header>
  <main class="main">
    <div class="sidebar-nav">
      <div>
        My profile
      </div>
      <div>
        My courses
      </div>
    </div>
    <div class="content-wrap">
      <form action="save_content.php" method="POST">
        <input id="submit-button" type="submit" value="save" />
        <input id="course_title" name="course_name" type="text" placeholder="Course name" />
        <textarea placeholder="Course description" id="course_description" name="course_description"></textarea>
        <button onclick=" addModule()" class="add-module">add module</button>
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
            <div class="table">
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
  function chanegTitle() {

    event.target.parentElement.parentElement.querySelector(
      ".module-header div"
    ).textContent = event.target.value;
    console.log(event.target.parentElement.parentElement)
  }



  function addModule() {
    event.preventDefault();

    var moduleTemplate = `<?php echo $sModuleTemplate; ?>`
    document
      .querySelector("form")
      .insertAdjacentHTML("beforeend", moduleTemplate);
  }

  function openModule() {
    event.target.parentElement.querySelector(".module-main").classList.toggle("show-block");
  }

  var number_of_module_lessons = 1

  function addLesson() {
    event.preventDefault();
    number_of_module_lessons++
    var lessonTemplate = `<?php echo $sLessonTemplate; ?>`
    event.target.parentElement.querySelector(".number_of_items").value = number_of_module_lessons
    event.target.parentElement.querySelector(".table").insertAdjacentHTML("beforeend", lessonTemplate);
  }
</script>