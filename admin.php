<?php
require_once('db_conn.php');
$sModuleTemplate = file_get_contents('templates/module-template.html');
$sLessonTemplate = file_get_contents('templates/lesson-template.html');

// $author_id = $_GET['author_id'];
$author_id = 1;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="minify-css/admin.css" />
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

            $q = $conn->prepare('SELECT * FROM courses WHERE author_id= :author_id');
            $q->bindValue(':author_id', $author_id);
            $q->execute();
            $data = $q->fetchAll();

        ?>
            <div class="content-wrap my-courses">
                <a class="btn" href="add_course.php">add new</a>
                <div class="table course-list">
                    <div class="table-row">
                        <div class="col-course-id">ID</div>
                        <div class="col-course-name">Course name</div>
                        <div class="col-course-students">Number of students</div>
                        <div class="col-course-date">Publishe date</div>
                        <div class="edit-btn">
                        </div>
                        <div class="delete-btn">
                        </div>
                    </div>
                    <?php
                    foreach ($data as $course_row) :
                    ?>
                        <div class="table-row">
                            <div class="col-course-id"><?= $course_row->course_id ?></div>
                            <div class="col-course-name"><?= $course_row->course_name ?></div>
                            <div class="col-course-students"><?= $course_row->no_of_paparticipants; ?></div>
                            <div class="col-course-date"><?= $course_row->published_date; ?></div>
                            <div class="edit-btn">
                                <a href="edit.php?course_id=<?= $course_row->course_id ?>&update=false"> Edit</a>
                            </div>
                            <div class="delete-btn">
                                <a href="PHP/delete.php?course_id=<?= $course_row->course_id ?>"> Delete</a>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
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
    var moduleTemplate = `<?php echo $sModuleTemplate; ?>`;
    var lessonTemplate = `<?php echo $sLessonTemplate; ?>`;
</script>
<script src="minify-js/admin.js"></script>