 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="stylesheet" href="users.css" />
   <title>Create an account</title>
 </head>

 <body>
   <header>
     <img src="./img/logo.png" alt="logo" />
     <?php
      require_once('nav.php');
      ?>
   </header>
   <main>
     <div class="container">
       <h1>Create an account</h1>
       <form id="RegisterUsersForm" method="POST" action="insert_account.php" onsubmit="return false">
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
 <script>
   function validate_user() {
     var email = event.target.value;
     var text
     console.log(email);
     var regEmail = /^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;


     (async function() {
       if (regEmail.test(email) === false) {
         text = "The email is not correct"

       } else {
         var jResponse = await fetch(`validate_user.php?email=${email}`);
         text = await jResponse.text();
       }
       if (text) {
         document.querySelector('#email-validation-messsage').textContent = text
         return false
       } else {
         document.querySelector('#email-validation-messsage').textContent = ''
         return true
       }
     })();
     console.log(text)

   }

   function post_user() {
     var password = document.querySelector('#password').value
     var confirm_password = document.querySelector('#confirm_password').value
     console.log(password, confirm_password)
     if (validate_user() == false) {
       console.log("you can't do it")
     } else if (password !== confirm_password) {
       console.log("The password didn't match. Try again")
       document.querySelector('#email-validation-messsage').textContent = ''
       document.querySelector('#confirm-password-validation-messsage').textContent = "The password didn't match. Try again"
     } else {
       (async function() {
         var oForm = document.querySelector("#RegisterUsersForm");
         var jConnection = await fetch("insert_account.php", {
           method: "POST",
           body: new FormData(oForm)
         });
         var text = await jConnection.text();
         console.log(text)
         document.querySelector('.container').innerHTML =
           `<div class="signup-success-box">
           <img class="success-icon" src="img/success_icon.png" alt="success-icon">
           <p class="signup-success-text" > ${text}  </p>
           </div>`
       })();
     }

   }
 </script>