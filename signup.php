 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="stylesheet" href="minify-css/users.css" />
   <link rel="stylesheet" href="minify-css/app.css" />
   <link rel="stylesheet" href="minify-css/header.css" />

   <title>Create an account</title>
 </head>

 <body>

   <?php
    require_once('nav.php');
    ?>
   <main>
     <div class="container">
       <h1>Create an account</h1>
       <form id="RegisterUsersForm" method="POST" onsubmit="return false">
         <div class="input-container">
           <input oninput="validate_user()" id="email" type="text" placeholder="Email" name="email" />
           <p id="email-validation-messsage"></p>
         </div>
         <div class="input-container">
           <input type="password" placeholder="Password" name="password" id="password" />
         </div>
         <div class="input-container">
           <input type="password" placeholder="Confirm Password" name="confirm_password" id="confirm_password" />
           <p id="confirm-password-validation-messsage"></p>
         </div>
         <div class="input-container">
           <input onclick="post_user()" class="btn-signup" name="signup-btn" type="submit" value="SIGN UP"></input>
         </div>
       </form>
       <p>
         By creating an account you agree to our <br><a style="color: blue;" href="#">Terms of Service and Privacy
           Policy</a>.</br>
       </p>
     </div>
   </main>
 </body>

 </html>
 <script src="minify-js/signup.js"></script>