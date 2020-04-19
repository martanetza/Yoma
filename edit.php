<?php
require_once('db_conn.php');

$sModuleTemplate = file_get_contents('module-template.html');
$sLessonTemplate = file_get_contents('lesson-template.html');
$course_id = $_GET['course_id'];
$update = $_GET['update'];
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
            <div class="sidebar-nav-element">
                <div>
                    My profile
                </div>
                <div>
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
            <div class="sidebar-nav-element">
                <a href="my_courses.php">
                    My courses
                </a>
                <div>
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
        <?php
        try {
            if ($update === 'true') {
                $course_name_update = $_POST['course_name_update'];
                $course_description_update = $_POST['course_description_update'];

                $q_course_update = $conn->prepare('UPDATE courses SET course_name = :course_name, course_desc= :course_description_update WHERE course_id = :id');
                $q_course_update->bindValue(':course_name', $course_name_update);
                $q_course_update->bindValue(':course_description_update', $course_description_update);
                $q_course_update->bindValue(':id', $course_id);

                $q_course_update->execute();

                // echo 'Course updated rows:' . $q_course_update->rowCount();

                //update module 
                if (isset($_POST['module_id'])) {
                    $aModule_id = $_POST['module_id'];
                    $aModule_title_update = $_POST['module_title_update'];
                    $aNumber_of_items_update = $_POST['number_of_items_update'];
                    $k = 0;
                    $q_module_update = $conn->prepare('UPDATE modules SET module_name = :module_title_update WHERE module_id = :module_id');
                    foreach ($aModule_id as $key => $module_id) {
                        $q_module_update->bindValue(':module_id', $module_id);
                        $q_module_update->bindValue(':module_title_update', $aModule_title_update[$key]);
                        $q_module_update->execute();

                        //add a new lesson to an existing module 

                        for ($k; $k < $aNumber_of_items_update[$key]; $k++) {
                            $aLesson_title = $_POST['lesson_title'];
                            $aLesson_exerpt = $_POST['lesson_exerpt'];
                            $aLesson_description = $_POST['lesson_description'];

                            $query_lesson = $conn->prepare("INSERT INTO items VALUES(null, :lesson_title, :lesson_exerpt, :lesson_description,  $module_id)");
                            $query_lesson->bindValue(':lesson_title', $aLesson_title[$k]);
                            $query_lesson->bindValue(':lesson_exerpt', $aLesson_exerpt[$k]);
                            $query_lesson->bindValue(':lesson_description', $aLesson_description[$k]);
                            $query_lesson->execute();
                        }
                    }
                }
                //update lesson
                $aLesson_id = $_POST['lesson_id'];
                $aLesson_title_update = $_POST['lesson_title_update'];
                $aLesson_excerpt_update = $_POST['lesson_excerpt_update'];
                $aLesson_description_update = $_POST['lesson_description_update'];

                $q_item_update = $conn->prepare('UPDATE items SET item_title = :lesson_title_update, item_excerpt = :lesson_excerpt_update, item_content = :lesson_description_update WHERE item_id = :lesson_id');
                foreach ($aLesson_id as $key => $lesson_id) {
                    $q_item_update->bindValue(':lesson_id', $lesson_id);
                    $q_item_update->bindValue(':lesson_title_update',  $aLesson_title_update[$key]);
                    $q_item_update->bindValue(':lesson_excerpt_update',  $aLesson_excerpt_update[$key]);
                    $q_item_update->bindValue(':lesson_description_update',  $aLesson_description_update[$key]);
                    $q_item_update->execute();
                }
                //create module and lessons
                if (isset($_POST['module_title'])) {
                    $aModule_name = $_POST['module_title'];
                    $aItems_number = $_POST['number_of_items'];
                    $aLesson_title = $_POST['lesson_title'];
                    $aLesson_exerpt = $_POST['lesson_exerpt'];
                    $aLesson_description = $_POST['lesson_description'];


                    // create modules
                    $i = 0;
                    $j = 0;
                    $number_of_items_per_module = 0;
                    for ($i; $i < count($aModule_name); $i++) {
                        $number_of_items_per_module += $aItems_number[$i];
                        print_r($number_of_items_per_module);
                        $query_module = $conn->prepare("INSERT INTO modules VALUES(null, :module_name,  $course_id)");
                        $query_module->bindValue(':module_name', $aModule_name[$i]);
                        $query_module->execute();

                        $last_module_id = $conn->lastInsertId();
                        echo "New record created successfully. Last inserted ID is: " . $last_module_id;
                        //create lessons 
                        for ($j; $j < $number_of_items_per_module; $j++) {
                            $query_lesson = $conn->prepare("INSERT INTO items VALUES(null, :lesson_title, :lesson_exerpt, :lesson_description,  $last_module_id)");
                            $query_lesson->bindValue(':lesson_title', $aLesson_title[$j]);
                            $query_lesson->bindValue(':lesson_exerpt', $aLesson_exerpt[$j]);
                            $query_lesson->bindValue(':lesson_description', $aLesson_description[$j]);
                            $query_lesson->execute();
                        }
                    }
                }
            }

            //read data
            $q = $conn->prepare('SELECT * FROM courses WHERE course_id=' . $course_id);
            $q->execute();
            $data = $q->fetchAll();

            $q_module = $conn->prepare('SELECT * FROM modules WHERE course_id=' . $course_id);
            $q_module->execute();
            $modules_rows = $q_module->fetchAll();

        ?>
            <div class="content-wrap">
                <form action="edit.php?course_id=<?= $course_id; ?>&update=true" method="POST">
                    <input id="submit-button" class="btn" type="submit" value="update" />
                    <input id="course_title" name="course_name_update" type="text" placeholder="Course name" value="<?= $data[0]->course_name; ?>" />
                    <textarea placeholder="Course description" id="course_description" name="course_description_update"><?= $data[0]->course_desc; ?> </textarea>
                    <button onclick=" addModule()" id="add-module" class="add-module">add module</button>
                    <?php
                    foreach ($modules_rows as $row) :
                        $q_items = $conn->prepare('SELECT * FROM items WHERE module_id=' . $row->module_id);
                        $q_items->execute();
                        $items_rows = $q_items->fetchAll();

                    ?>
                        <div class="module-content">
                            <div onclick="openModule()" class="module-header">
                                <div>
                                    <?= $row->module_name; ?>
                                </div>
                                <div>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="module-main">
                                <input class="module-title" name="module_title_update[]" type="text" placeholder="Module title" value="<?= $row->module_name; ?>" oninput="chanegTitle()" />
                                <input type="hidden" class="module_id" name="module_id[]" value="<?= $row->module_id; ?>">
                                <input type="hidden" class="number_of_items" name="number_of_items_update[]" value="0">
                                <div class="table">
                                    <div class="table-row">
                                        <div class="col-title">Title</div>
                                        <div class="col-exerpt">Exerpt</div>
                                        <div class="col-description">Text content</div>
                                        <div class="col-image">Image url</div>
                                    </div>
                                    <?php
                                    foreach ($items_rows as $row) :
                                    ?>
                                        <div class="table-row">
                                            <input type="hidden" class="lesson_id" name="lesson_id[]" value="<?= $row->item_id; ?>">
                                            <div class="col-title">
                                                <input class="lesson_title" name="lesson_title_update[]" type="text" placeholder="Lesson title" value="<?= $row->item_title; ?>" />
                                            </div>
                                            <div class="col-exerpt">
                                                <textarea placeholder="Lesson exerpt" class="lesson_excerpt" name="lesson_excerpt_update[]"><?= $row->item_excerpt; ?></textarea>
                                            </div>
                                            <div class="col-description">
                                                <textarea placeholder="Lesson description" class="lesson_description" name="lesson_description_update[]"><?= $row->item_content; ?></textarea>
                                            </div>
                                            <div class="col-image">Image url</div>
                                        </div>
                                    <?php
                                    endforeach;
                                    ?>
                                </div>
                                <button onclick="addLesson()" id="add_lesson" class="add-lesson">Add lesson</button>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </form>
            </div>
        <?php
        } catch (PDOException $e) {
            echo $e;
        }

        ?>
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

    var number_of_module_lessons = 0

    function addLesson() {
        event.preventDefault();
        number_of_module_lessons++
        var lessonTemplate = `<?php echo $sLessonTemplate; ?>`
        event.target.parentElement.querySelector(".number_of_items").value = number_of_module_lessons
        event.target.parentElement.querySelector(".table").insertAdjacentHTML("beforeend", lessonTemplate);
    }
</script>