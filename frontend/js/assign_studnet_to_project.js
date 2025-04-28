let selectedProposalId = null;
let selectedStudentId = null;

function openAssignPopup(proposalId) {
  selectedProposalId = proposalId;
  document.getElementById("assign-popup").style.display = "block";

  fetch("../../../../backend/controllers/search_for_student.php")
    .then((response) => response.json())
    .then((data) => {
      let studentList = document.getElementById("student-list");
      studentList.innerHTML = "";

      if (data.length === 0) {
        studentList.innerHTML = "<p>No unassigned students available.</p>";
        return;
      }

      data.forEach((student) => {
        let studentElement = document.createElement("div");
        studentElement.className = "student-item";
        studentElement.innerHTML = `
                    ${student.Full_Name} (ID: ${student.User_ID}) 
                    <button onclick="selectStudent(${student.User_ID})">Select</button>`;
        studentList.appendChild(studentElement);
      });
    })
    .catch((error) => console.error("Error fetching students:", error));
}

function closeAssignPopup() {
  selectedProposalId = null;
  selectedStudentId = null;
  document.getElementById("assign-popup").style.display = "none";

  document.getElementById("student-list").innerHTML = "";
}

function selectStudent(studentId) {
  selectedStudentId = studentId;
  document.getElementById("confirm-assignment").style.display = "block";
}

document
  .getElementById("confirm-assignment")
  .addEventListener("click", function () {
    if (!selectedProposalId || !selectedStudentId) {
      alert("Please select a student first.");
      return;
    }

    fetch(
      "../../../../backend/controllers/process_assign_student_to_project.php",
      {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `student_id=${selectedStudentId}&proposal_id=${selectedProposalId}`,
      }
    )
      .then((response) => response.text())
      .then((message) => {
        alert(message);
        closeAssignPopup();
        location.reload(); // Refresh to reflect the change
      })
      .catch((error) => console.error("Error assigning student:", error));
  });
