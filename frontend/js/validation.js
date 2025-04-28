document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("registrationForm")
    .addEventListener("submit", function (event) {
      let fullName = document.getElementById("full_name").value.trim();
      let email = document.getElementById("email").value.trim();
      let password = document.getElementById("password").value;
      let errorMessage = document.getElementById("error-message");

      let nameRegex = /^[A-Za-z\s]+$/;
      let emailRegex = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
      let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).{8,}$/; // No digit required

      let errors = "";

      if (!nameRegex.test(fullName)) {
        errors = "Full Name should only contain letters and spaces.";
      } else if (!emailRegex.test(email)) {
        errors = "Invalid email format.";
      } else if (!passwordRegex.test(password)) {
        errors =
          "Password must be at least 8 characters, contain one uppercase letter, and one special character.";
      }

      if (errors) {
        errorMessage.innerHTML = errors;
        errorMessage.style.display = "block";
        event.preventDefault();
      } else {
        errorMessage.style.display = "none";
      }
    });
});
