document.addEventListener("DOMContentLoaded", () => {
    const popup = document.getElementById("newUser-popup");
    const nameInput = document.getElementById("name-input");
    const emailInput = document.getElementById("email-input");
    const roleInput = document.getElementById("role-input"); 
    const passwordInput = document.getElementById("password-input");
    const submit = document.querySelector("#submit-button");
    const newButton = document.querySelector(".new-user-button"); 
    const closeButton = document.querySelector(".close-button"); 

    function openPopup() {
        popup.style.display = "flex";
    }

    function closePopup() {
        popup.style.display = "none";
    }

    async function submitUser() {
        if (!nameInput.value || !emailInput.value || !roleInput.value || !passwordInput.value) {
            alert("All fields are required.");
            return;
        }

        let formData = new FormData();
        formData.append("full-name", nameInput.value);
        formData.append("email", emailInput.value);
        formData.append("role", roleInput.value); // Gets value from dropdown
        formData.append("password", passwordInput.value);

        try {
            let response = await fetch("add_new_user.php", {
                method: "POST",
                body: formData
            });

            let data = await response.json();

            if (data.success) {
                alert("User added successfully!");
                closePopup();
                location.reload();
            } else {
                alert("Error: " + (data.error || "Failed to add user."));
            }
        } catch (error) {
            console.error("Error:", error);
            alert("An error occurred. Please try again.");
        }
    }

    // Attach event listeners correctly
    if (newButton) newButton.addEventListener("click", openPopup);
    if (submit) submit.addEventListener("click", submitUser);
    if (closeButton) closeButton.addEventListener("click", closePopup);

});
