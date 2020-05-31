function validate_user() {
  var email = event.target.value;
  var text;
  console.log(email);
  var regEmail = /^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

  (async function () {
    if (regEmail.test(email) === false) {
      text = "The email is not correct";
    } else {
      var jResponse = await fetch(`PHP/validate_user.php?email=${email}`);
      text = await jResponse.text();
    }
    if (text) {
      document.querySelector("#email-validation-messsage").textContent = text;
      return false;
    } else {
      document.querySelector("#email-validation-messsage").textContent = "";
      return true;
    }
  })();
  console.log(text);
}

function post_user() {
  var password = document.querySelector("#password").value;
  var confirm_password = document.querySelector("#confirm_password").value;
  console.log(password, confirm_password);
  if (validate_user() == false) {
    console.log("you can't do it");
  } else if (password !== confirm_password) {
    console.log("The password didn't match. Try again");
    document.querySelector("#email-validation-messsage").textContent = "";
    document.querySelector(
      "#confirm-password-validation-messsage"
    ).textContent = "The password didn't match. Try again";
  } else {
    (async function () {
      var oForm = document.querySelector("#RegisterUsersForm");
      var jConnection = await fetch("PHP/insert_account.php", {
        method: "POST",
        body: new FormData(oForm),
      });
      var text = await jConnection.text();
      console.log(text);
      document.querySelector(
        ".container"
      ).innerHTML = `<div class="signup-success-box">
          <img class="success-icon" src="img/success_icon.png" alt="success-icon">
          <p class="signup-success-text" > ${text}  </p>
          </div>`;
    })();
  }
}
