document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("proposalForm")
    .addEventListener("submit", function (event) {
      let fileInput = document.getElementById("proposalFile");
      let errorMessage = document.getElementById("file-error");

      if (fileInput.files.length === 0) {
        errorMessage.innerText = "Please select a file to upload.";
        errorMessage.style.display = "block";
        event.preventDefault();
        return;
      }

      let allowedExtensions = ["pdf", "docx"];
      let fileName = fileInput.files[0].name;
      let fileSize = fileInput.files[0].size;
      let fileExtension = fileName.split(".").pop().toLowerCase();

      if (!allowedExtensions.includes(fileExtension)) {
        errorMessage.innerText =
          "Invalid file type. Only PDF and DOCX files are allowed.";
        errorMessage.style.display = "block";
        event.preventDefault();
      } else if (fileSize > 5 * 1024 * 1024) {
        // 5MB limit
        errorMessage.innerText = "File size exceeds the 5MB limit.";
        errorMessage.style.display = "block";
        event.preventDefault();
      } else {
        errorMessage.style.display = "none";
      }
    });
});
