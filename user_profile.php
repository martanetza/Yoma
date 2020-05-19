<?php
require_once('db_conn.php');
require_once('has_access.php');

// $course_id = $_GET['course_id'];
$user_id = $_SESSION['email'];
?>
<?php

try {

  $q_chosen_course = $conn->prepare('SELECT * FROM chosen_course INNER JOIN courses ON chosen_course.course_id = courses.course_id INNER JOIN users ON chosen_course.user_email = users.email  WHERE chosen_course.user_email = :email');
  $q_chosen_course->bindValue(':email', $user_id);
  $q_chosen_course->execute();
  $courses_rows = $q_chosen_course->fetchAll();

  $q_user = $conn->prepare('SELECT * FROM users WHERE email = :email');
  $q_user->bindValue(':email', $user_id);
  $q_user->execute();
  $q_user_response = $q_user->fetchAll();
  $q_user_data =   $q_user_response[0];
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
            <a href="index.php">Courses</a>
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
    <main class="main-profile">
      <div class="user-profile-content">
        <div class="user-profile-content-col">
          <h2>Profile</h2>

          <div class="profile-info">
            <img class="profile-img" src="img/profile.png" alt="profile-img">
            <button class="btn btn-edit"> edit image</button>
            <h4 class="user-name"><?= (!empty($q_user_data->first_name)) ? $q_user_data->first_name : ' ' . ' ' ?> <?= (!empty($q_user_data->last_name)) ? $q_user_data->last_name : ' '; ?></h4>
            <div class="profile-info-item">
              <span>current courses: </span>
              <span>1</span>
            </div>
            <div class="profile-info-item">
              <span>accomplished courses: </span>
              <span>0</span>
            </div>
          </div>
          <div class="profile-info user-details">
            <h4>Personal info:</h4>
            <div class="user-first-name-info user-details-item">
              <span>First name:</span>
              <span> <?= (!empty($q_user_data->first_name)) ?  $q_user_data->first_name : 'edit to add your first name'; ?></span>
            </div>
            <div class="user-last-name-info user-details-item">
              <span>Last name</span>
              <span><?= (!empty($q_user_data->last_name)) ? $q_user_data->last_name : 'edit to add your last name'; ?></span>
            </div>
            <div class="user-school-info user-details-item">
              <span>School:</span>
              <span><?= (!empty($q_user_data->school)) ? $q_user_data->school : 'edit to add your school'; ?></span>
            </div>
            <div class="user-email-info user-details-item">
              <span>Email:</span>
              <span><?= $q_user_data->email; ?></span>
            </div>
            <div class="user-password-info user-details-item">
              <span>Password:</span>
              <span> &#8226 &#8226 &#8226 &#8226 &#8226 &#8226</span>
            </div>
            <button onclick=" openModal()" class="btn btn-edit"> edit info</button>

          </div>
        </div>
        <div class="user-profile-content-col">
          <p class="chosen-courses-header">Chosen courses:</p>
          <div class="user-course-list">
            <?php
            foreach ($courses_rows as $row) :
            ?>
              <div class="user-course-list-item">
                <div class="user-course-list-wrapper">
                  <h4 class="course-name"><?= $row->course_name; ?></h4>
                  <div class="continue-btn">
                    <form action="join_chosen_course.php" method="POST">
                      <input type="hidden" name="course_id" id="chosen_course_id" value="<?= $row->course_id; ?>">
                      <input type="hidden" name="user_id" id="user_id" value="<?= $user_id; ?>">
                      <input type="hidden" name="continue" id="continue" value="<?= ($row_chosen_course) ? 'true' : 'false'; ?>">
                      <input class="btn" type="submit" name="join_button" id="join_button" value="continue" />
                    </form>
                  </div>
                  <div class="progress-bar">
                    <div class="progress" style="width: <?= $row->progress . '%'; ?>"></div>
                  </div>
                </div>
              </div>
            <?php
            endforeach;
            ?>
          </div>
          <div class='feed'>
            <p>The feed:</p>
            <div class="feed-content">
              <?php
              $q_messages = $conn->prepare('SELECT * FROM messages WHERE user_email = :email ORDER BY message_date DESC');
              $q_messages->bindValue(':email', $user_id);
              $q_messages->execute();
              $q_messages_response = $q_messages->fetchAll();
              ?>
              <?php foreach ($q_messages_response as $message) : ?>
                <p class="message_date">
                  <?= $message->message_date ?>
                </p>
                <p class="message_content">
                  <?= $message->message ?>
                </p>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </main>
    <div class="modal-user-profile">
      <div class="modal-content">
        <form id="user-info-edit-form" action="edit_user_profile.php" method="POST">
          <div class="input-container">
            <label for="first_name">First name</label>
            <input type="text" name="first_name" id="first_name" placeholder="First name" value="<?= (!empty($q_user_data->first_name)) ? $q_user_data->first_name : ''; ?>">
          </div>
          <div class="input-container">
            <label for="last_name">Last name</label>
            <input type="text" name="last_name" id="last_name" placeholder="Last name" value="<?= (!empty($q_user_data->last_name)) ? $q_user_data->last_name : ''; ?>">
          </div>
          <div class="input-container">
            <label for="school">School</label>
            <input type="text" name="school" id="school" placeholder="School" value="<?= (!empty($q_user_data->school)) ? $q_user_data->school : ''; ?>">
          </div>
          <div class="input-container">
            <label for="user_email">User email</label>
            <input type="text" name="user_email" id="user_email" placeholder="Email" value="<?= (!empty($q_user_data->email)) ? $q_user_data->email : ''; ?>">
          </div>
          <div class="input-container">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" value="<?= (!empty($q_user_data->password)) ? $q_user_data->password : ''; ?>">
          </div>
          <div class="input-container">
            <label for="confirm_password">Confirm password</label>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" value="<?= (!empty($q_user_data->password)) ? $q_user_data->password : ''; ?>">
          </div>
          <div class="input-container">
            <input class="btn-save" type="submit" value="save">
          </div>
        </form>
      </div>
    </div>
  </body>

  </html>

<?php
} catch (PDOException $e) {
  echo $e;
}
?>

<script>
  function openModal() {
    document.querySelector(".modal-user-profile").style.display = "block"
  }
</script>