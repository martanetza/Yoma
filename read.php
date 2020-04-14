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
            <div>
                My profile
            </div>
            <div>
                My courses
            </div>
        </div>
        <?php
        try {
            if ($update === 'true') {
                $name = $_POST['course_name_update'];

                $q_course_update = $conn->prepare('UPDATE courses SET course_name = :course_name WHERE course_id = :id');
                $q_course_update->bindValue(':course_name', $name);
                $q_course_update->bindValue(':id', $course_id);

                $q_course_update->execute();

                echo 'Updated rows:' . $q_course_update->rowCount();
            }
            $q = $conn->prepare('SELECT * FROM courses WHERE course_id=' . $course_id);
            $q->execute();
            $data = $q->fetchAll();

            $q_module = $conn->prepare('SELECT * FROM modules WHERE course_id=' . $course_id);
            $q_module->execute();
            $modules_rows = $q_module->fetchAll();


        ?>
            <div class="content-wrap">
                <form action="read.php?course_id=<?= $course_id; ?>&update=true" method="POST">
                    <input id="submit-button" type="submit" value="save" />
                    <input id="course_title" name="course_name_update" type="text" placeholder="Course name" value="<?= $data[0]->course_name; ?>" />
                    <textarea placeholder="Course description" id="course_description" name="course_description_update"><?= $data[0]->course_desc; ?> </textarea>
                    <button onclick=" addModule()" class="add-module">add module</button>
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
                                <input class="module-title" name="module_title_update" type="text" placeholder="Module title" value="<?= $row->module_name; ?>" oninput="chanegTitle()" />
                                <input type="hidden" class="number_of_items" name="number_of_items_update" value="1">
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
                                            <div class="col-title">
                                                <input class="lesson_title" name="lesson_title_update" type="text" placeholder="Lesson title" value="<?= $row->item_title; ?>" />
                                            </div>
                                            <div class="col-exerpt">
                                                <textarea placeholder="Lesson exerpt" class="lesson_exerpt" name="lesson_exerpt_update"><?= $row->item_excerpt; ?></textarea>
                                            </div>
                                            <div class="col-description">
                                                <textarea placeholder="Lesson description" class="lesson_description" name="lesson_description_update"><?= $row->item_content; ?></textarea>
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

    var number_of_module_lessons = 1

    function addLesson() {
        event.preventDefault();
        number_of_module_lessons++
        var lessonTemplate = `<?php echo $sLessonTemplate; ?>`
        event.target.parentElement.querySelector(".number_of_items").value = number_of_module_lessons
        event.target.parentElement.querySelector(".table").insertAdjacentHTML("beforeend", lessonTemplate);
    }
</script>