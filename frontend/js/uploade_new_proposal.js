const newButton = document.getElementById("new-button");
const uploadForm = document.getElementById("upload-form");
const cancelButton = document.getElementById("cancel-button");
const fileInput = document.getElementById("file-input");
const form = document.querySelector("form");

// Show the upload form
newButton.addEventListener("click", () => {
  uploadForm.style.display = "block";
});

// Hide the upload form
cancelButton.addEventListener("click", () => {
  uploadForm.style.display = "none";
  form.reset(); // Clear form inputs
});

// Prevent default form submission and use AJAX instead
form.addEventListener("submit", function (e) {
  e.preventDefault();

  const projectTitle = document.getElementById("project-title").value.trim();
  const file = fileInput.files[0];

  // Validate file and title before submission
  if (!file) {
    alert("Please upload a file!");
    return;
  }

  if (!projectTitle) {
    alert("Project title cannot be empty!");
    return;
  }

  // Create FormData to send the file and project title
  const formData = new FormData();
  formData.append("proposal_file", file);
  formData.append("Proposal_Title", projectTitle);

  // Send form data via AJAX
  fetch("../../../../backend/controllers/process_uploding_proposal.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json()) // Expect JSON response
    .then((data) => {
      if (data.status === "success") {
        alert("Project submitted successfully!");

        uploadForm.style.display = "none"; // Hide form
        form.reset(); // Reset the form
        location.reload(); // Refresh to reflect the change
      } else {
        alert(data.message); // Show error message
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("An unexpected error occurred. Please try again.");
    });
});
