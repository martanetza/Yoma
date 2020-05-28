<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="users.css" />
  <link rel="stylesheet" href="app.css" />
  <title>LOG IN</title>
</head>

<body>

  <?php
  require_once('nav.php');
  ?>
  <main>
    <div class="container-log-in">
      <h1>LOG IN</h1>
      <form class="form-log-in" method="GET" onsubmit="return false">
        <div class="input-container">
          <input type="text" placeholder="Email" name="email" id="login_email" />
        </div>
        <div class="input-container">
          <input type="password" placeholder="Password" name="password" id="login_password" />
          <p class="login-validation-message"></p>
        </div>
        <input onclick="login_by_email()" name="login-btn" class="btn-log-in" type="submit" value="LOG IN"></input>
      </form>
      <p class="paragraph">
        You don't have an account yet?
        <a style="color: blue;" href="./signup.php">Sign up!</a>
      </p>
    </div>
  </main>
</body>

</html>

<script>
  function login_by_email() {
    var email = document.querySelector("#login_email").value;
    var password = document.querySelector("#login_password").value;
    var text;
    (async function() {
      console.log(email);
      var jResponse = await fetch(`login_user.php?email=${email}&password=${password}`);
      text = await jResponse.text();
      console.log(text)
      if (text) {
        document.querySelector(".login-validation-message").textContent = text
      } else {
        document.querySelector(".login-validation-message").textContent = ""
        window.location.href = "http://localhost/YOMA";

      }
    })();
  }
</script>