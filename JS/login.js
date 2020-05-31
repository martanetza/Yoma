function login_by_email() {
  var email = document.querySelector("#login_email").value;
  var password = document.querySelector("#login_password").value;
  var text;
  if (!email || !password) {
    document.querySelector(".login-validation-message").textContent =
      "Provide you email and password";
  } else {
    (async function () {
      console.log(email);
      var jResponse = await fetch(
        `PHP/login_user.php?email=${email}&password=${password}`
      );
      text = await jResponse.text();
      console.log(text);
      if (text) {
        document.querySelector(".login-validation-message").textContent = text;
      } else {
        document.querySelector(".login-validation-message").textContent = "";
        window.location.href = "http://localhost/YOMA";
      }
    })();
  }
}
