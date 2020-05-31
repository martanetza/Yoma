<?php

require_once('db_conn.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="CSS/style.css" />
  <link rel="stylesheet" href="CSS/header.css" />

  <title>Welcome to YOMA</title>
</head>

<body>


  <?php
  require_once('nav.php');
  ?>

  <main>
    <img class="img-text" src="img/text.png" />
    <img class="intro" src="img/intro.png" />
    <p class="main_p1">
      Are you a beginner web developer who needs some guidelines? Or a student
      who is struggling with the university materials?
    </p>
    <p class="main_p2">
      Join our e-learning platform to get access to our online courses. Get a
      grip on relational databases and SQL programming. Join us today and
      start your journey of learning.
    </p>
    <a class="btn1" href="signup.php"> JOIN YOMA </a>
  </main>

  <section class="section1">
    <h1>How does it work?</h1>
    <img class="red" src="img/red.png" alt="" />
    <img class="blue" src="img/blue.png" alt="" />
  </section>

  <section class="section2">
    <!-- https://www.w3schools.com/howto/howto_js_slideshow.asp -->
    <div class="slides-container">
      <div class="currentSlide">
        <h2>Study</h2>
        <img class="study" src="img/study.png" />
        <div class="text">
          Our structured courses allow participants to follow and focus
          effortlessly. Gaining knowledge and skills was never easier.
          <br /><br />
          Our expert teachers help you with the studying process and prepare
          you well for your studies and career.
        </div>
      </div>

      <div class="currentSlide">
        <h2>Challenge yourself</h2>
        <img class="challenge" src="img/challenge.png" />
        <div class="text">
          The best way to learn is by challenging yourself everyday. Keep
          track on your daily process, plan and form habits.
          <br /><br />
          With YOMA is easy to create a daily routine with your studying and
          make progress with the modules.
        </div>
      </div>

      <div class="currentSlide">
        <h2>Grow</h2>
        <img class="grow" src="img/grow.png" />
        <div class="text">
          Building your knowledge creates confidence that brings result,
          develops skills and achieves success. YOMA is here to help you grow.
        </div>
      </div>
    </div>

    <a class="prev" onclick="plusSlides(-1)"><img src="img/prev.png" /></a>
    <a class="next" onclick="plusSlides(1)"><img src="img/next.png" /></a>

    <div style="text-align: center;">
      <span class="dot" onclick="currentSlide(1)"></span>
      <span class="dot" onclick="currentSlide(2)"></span>
      <span class="dot" onclick="currentSlide(3)"></span>
    </div>
  </section>

  <section class="section3">
    <h1 class="title">Browse our most popular courses</h1>
    <p class="p">
      We are offering over 100 lessons with easy to understand content that
      helps you study smarter
    </p>
    <div class="box">
      <a href="#"><img class="js" src="img/js.png" alt="" /></a>
      <a href="#"> <img class="db" src="img/db.png" alt="" /></a>
      <a href="#"> <img class="php" src="img/php.png" alt="" /></a>
    </div>
    <a href="all_courses.php" class="white-btn">See more</a>
  </section>

  <section class="section4">
    <h1 class="title-aboutUs">About Us</h1>
    <p class="text-aboutUs">
      We are highly motivated web developers who believe that knowledge should
      be shared. YOMA is our first attempt to provide help to students or
      anyone who is constantly curious and wants to know more about the
      programming world.
    </p>
    <div class="boxes-wrapper">
      <div class="box1">
        <p>
          We are offering range of innovative lessons specially created to be
          simple and easy to understand.
        </p>
      </div>
      <div class="box2">
        <p>
          Our focus is on providing a content which is easy to access and to
          follow.
        </p>
      </div>
      <div class="box3">
        <p>Carefully selected team of teachers is our secret of success.</p>
      </div>
      <div class="box4">
        <p>
          In every lesson we deliver broad knowledge and many years of
          experience.
        </p>
      </div>
    </div>
    <a href="signup.php" class="btn3">JOIN YOMA</a>
  </section>

  <footer>
    <div class="footer-boxes">
      <div>
        <h3>Contact us</h3>
        <p>info@yoma.com</p>
        <p>Study help</p>
        <p>About us</p>
      </div>

      <div>
        <h3>Support</h3>
        <p>Teach for us</p>
        <p>Contact support</p>
        <p>FAQ</p>
      </div>

      <div>
        <h3>Follow us</h3>
        <p>Facebook</p>
        <p>Tweeter</p>
        <p>Linkedin</p>
      </div>
    </div>
    <span>© copyright 2020 Yoma.com. All other trademarks and copyrights are the
      property of their respective owners. All rights reserved.</span>
    <img class="img-footer" src="img/footer.png" alt="" />
  </footer>
  <script src="JS/script.js"></script>
</body>

</html>