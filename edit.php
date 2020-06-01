<?php
require_once('db_conn.php');

$sModuleTemplate = file_get_contents('templates/module-template.html');
$sLessonTemplate = file_get_contents('templates/lesson-template.html');
$course_id = $_GET['course_id'];
$update = $_GET['update'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="minify-css/admin.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/minify-js/all.min.js"></script>

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
        <?php
        try {
            $conn->beginTransaction();

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
                //update test
                $aTest_item_id = $_POST['test_item_id'];
                $question = $_POST['question_update'];
                $option_a = $_POST['option_a_update'];
                $option_b = $_POST['option_b_update'];
                $option_c = $_POST['option_c_update'];
                $option_d = $_POST['option_d_update'];
                $answer = $_POST['answer_update'];

                $query_test = $conn->prepare("UPDATE test SET question = :question, option_a = :option_a, option_b = :option_b, option_c = :option_c, option_d = :option_d, answer = :answer  WHERE test_item_id =  :test_item_id");
                foreach ($aTest_item_id as $key => $test_item_id) {
                    $query_test->bindValue(':test_item_id', $test_item_id);
                    $query_test->bindValue(':question', $question[$key]);
                    $query_test->bindValue(':option_a', $option_a[$key]);
                    $query_test->bindValue(':option_b', $option_b[$key]);
                    $query_test->bindValue(':option_c', $option_c[$key]);
                    $query_test->bindValue(':option_d', $option_d[$key]);
                    $query_test->bindValue(':answer', $answer[$key]);
                    $query_test->execute();
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
                        //create test
                        //create test
                        $aQestion = $_POST['question'];
                        $aOption_a = $_POST['option_a'];
                        $aOption_b = $_POST['option_b'];
                        $aOption_c = $_POST['option_c'];
                        $aOption_d = $_POST['option_d'];
                        $aAnswer = $_POST['answer'];

                        $query_test = $conn->prepare("INSERT INTO test VALUES(null, :qestion, :option_a, :option_b, :option_c, :option_d, :answer,  $last_module_id)");
                        $query_test->bindValue(':qestion', $aQestion[$i]);
                        $query_test->bindValue(':option_a', $aOption_a[$i]);
                        $query_test->bindValue(':option_b', $aOption_b[$i]);
                        $query_test->bindValue(':option_c', $aOption_c[$i]);
                        $query_test->bindValue(':option_d', $aOption_d[$i]);
                        $query_test->bindValue(':answer', $aAnswer[$i]);
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
                        $q_items = $conn->prepare('SELECT * FROM items  WHERE module_id=' . $row->module_id . ' ORDER BY item_id ASC');
                        $q_items->execute();
                        $items_rows = $q_items->fetchAll();

                        $q_test = $conn->prepare('SELECT * FROM test WHERE module_id=' . $row->module_id);
                        $q_test->execute();
                        $test_rows = $q_test->fetchAll();

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
                                        <input type="hidden" class="test_item_id" name="test_item_id[]" value="<?= $test_rows[0]->test_item_id ?>">

                                        <div class="col-question">
                                            <input class="question" name="question_update[]" type="text" placeholder="Question" value="<?= $test_rows[0]->question ?>" />
                                        </div>
                                        <div class="col-option">
                                            <input class="option_a" name="option_a_update[]" type="text" placeholder="Option A" value="<?= $test_rows[0]->option_a ?>" />
                                        </div>
                                        <div class="col-option">
                                            <input class="option_b" name="option_b_update[]" type="text" placeholder="Option B" value="<?= $test_rows[0]->option_b ?>" />
                                        </div>
                                        <div class="col-option">
                                            <input class="option_c" name="option_c_update[]" type="text" placeholder="Option C" value="<?= $test_rows[0]->option_c ?>" />
                                        </div>
                                        <div class="col-option">
                                            <input class="option_d" name="option_d_update[]" type="text" placeholder="Option D" value="<?= $test_rows[0]->option_d ?>" />
                                        </div>
                                        <div class="col-answer">
                                            <select name="answer_update[]" class="answer-select">
                                                <option value=""><?= $test_rows[0]->answer ?></option>
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
            $conn->commit();
        } catch (PDOException $e) {
            if ($conn->inTransaction()) {
                $conn->rollback();
            }
            echo $e;
        }

        ?>
    </main>
</body>

</html>
<script>
    var moduleTemplate = `<?php echo $sModuleTemplate; ?>`;
    var lessonTemplate = `<?php echo $sLessonTemplate; ?>`;
</script>
<script src="minify-js/edit.js"></script>