document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("mainForm");
    const uploadForm = document.getElementById("upload-form");
    const overlay = document.getElementById("overlay");
    
    const successMessage = document.createElement("div");
    successMessage.classList.add("success-message");
    successMessage.style.display = "none";
    document.body.insertBefore(successMessage, document.body.firstChild);

    // Handle form submission
    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default page reload

        let formData = new FormData(form);

        fetch("process_adding_announcements.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Announcement submitted successfully!");

                // Hide the form after successful submission
                closeForm();

                // Clear input fields
                form.reset();

                // Reload the page to reflect the new announcement
                location.reload();
            } else {
                alert("Failed to add announcement. Please try again.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred. Please try again.");
        });
    });
});

// Function to open the modal
function toggleForm() {
    document.getElementById("upload-form").style.display = "block";
    document.getElementById("overlay").style.display = "block";
}

// Function to close the modal
function closeForm() {
    document.getElementById("upload-form").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}
