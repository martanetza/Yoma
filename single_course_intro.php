<?php
$course_id = $_GET['course_id'];

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
          <a href="index.html">Courses</a>
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
  <main class="into-main">
    <form action="add_chosen_course.php" method="POST">
      <h1>
        Course title
      </h1>
      <p>description</p>
      <input type="hidden" name="chosen_course_id" id="chosen_course_id" value="<?= $course_id; ?>">
      <input type="hidden" name="user_id" id="user_id" value="<?= $course_id; ?>">
      <input class="btn" type="submit" name="join_button" id="join_button" value="join" />
    </form>
  </main>
</body>

</html>