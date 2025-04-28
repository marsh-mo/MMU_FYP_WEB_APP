let currentProjectId = null;

function openAssignPopup(projectId) {
  currentProjectId = projectId;
  document.getElementById("assign-popup").style.display = "flex";
}

function closeAssignPopup() {
  document.getElementById("assign-popup").style.display = "none";
}

function submitGrade() {
  let grade = document.getElementById("grade-input").value;
  let comment = document.getElementById("comment-input").value;

  if (grade === "" || isNaN(grade) || grade < 0 || grade > 100) {
    alert("Please enter a valid grade between 0 and 100.");
    return;
  }

  fetch("../../../../backend/controllers/process_to_mark_project.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `project_id=${currentProjectId}&marks=${grade}&comment=${comment}`,
  })
    .then((response) => response.json())
    .then((data) => {
      alert(data.message);
      if (data.status === "success") {
        closeAssignPopup();
        location.reload();
      }
    })
    .catch((error) => console.error("Error:", error));
}
