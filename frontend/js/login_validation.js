document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("login_form")
    .addEventListener("submit", function (event) {
      let errorMessage = document.getElementById("error-message");
      let emailInput = document.getElementById("email");

      let emailRegex = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

      let errors = "";

      if (!emailInput.value.match(emailRegex)) {
        errors = "Invalid email format.";
      }

      if (errors) {
        event.preventDefault();
        errorMessage.innerHTML = errors;
        errorMessage.style.color = "red";
      } else {
        errorMessage.innerHTML = ""; // Clear previous errors if the form is valid
      }
    });
});
