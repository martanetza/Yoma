<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="users.css" />
  <title>LOG IN</title>
</head>

<body>
  <header>
    <img src="img/logo.png" alt="logo" />
    <nav>
      <ul>
        <li><a href="#">About</a></li>
        <li><a href="#">Courses</a></li>
        <li><a href="signup.php">Create account</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="container-log-in">
      <h1>LOG IN</h1>
      <form class="form-log-in" action="login-user.php" method="GET">
        <div class="input-container">
          <input type="text" placeholder="Email" name="email" />
        </div>
        <div class="input-container">
          <input type="password" placeholder="Password" name="password" />
        </div>
        <input name="login-btn" class="btn-log-in" type="submit" value="LOG IN"></input>
      </form>
      <p class="paragraph">
        You don't have an account yet?
        <a style="color: blue;" href="./signup.php">Sign up!</a>
      </p>
    </div>
  </main>
</body>

</html>