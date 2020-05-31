function openModal() {
  document.querySelector(".modal-user-profile").style.display = "block";
}

function save_changes() {
  var password = document.querySelector("#password").value;
  var confirm_password = document.querySelector("#confirm_password").value;
  if (password != confirm_password) {
    document.querySelector(".user-password-validation-message").textContent =
      "The password didn't match. Try again";
  } else {
    (async function () {
      var oForm = document.querySelector("#user-info-edit-form");
      var jConnection = await fetch("PHP/edit_user_profile.php", {
        method: "POST",
        body: new FormData(oForm),
      });
      document.querySelector(".modal-user-profile").style.display = "none";
      window.location.href = "http://localhost/YOMA/user_profile.php";
    })();
  }
}
