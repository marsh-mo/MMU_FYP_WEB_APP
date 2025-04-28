let selectedProposalId = null;
let selectedSupervisorId = null;

function openAssignPopup(proposalId) {
  selectedProposalId = proposalId;
  document.getElementById("assign-popup").style.display = "block";

  fetch("fetch_supervioser.php") // Fixed spelling
    .then((response) => response.json())
    .then((data) => {
      let supervisorList = document.getElementById("supervisors-list");
      supervisorList.innerHTML = "";

      if (data.length === 0) {
        supervisorList.innerHTML =
          "<p>No unassigned supervisors available.</p>";
        return;
      }

      data.forEach((supervisor) => {
        let supervisorElement = document.createElement("div");
        supervisorElement.className = "supervisor-item";
        supervisorElement.innerHTML = `
                    ${supervisor.Full_Name} (ID: ${supervisor.User_ID}) 
                    <button onclick="selectSupervisor(${supervisor.User_ID})">Select</button>`;
        supervisorList.appendChild(supervisorElement);
      });
    })
    .catch((error) => console.error("Error fetching supervisor:", error));
}

function closeAssignPopup() {
  selectedProposalId = null;
  selectedSupervisorId = null;
  document.getElementById("assign-popup").style.display = "none";
  document.getElementById("supervisors-list").innerHTML = "";
}

function selectSupervisor(supervisorId) {
  selectedSupervisorId = supervisorId;
  document.getElementById("confirm-assignment").style.display = "block";
}

document
  .getElementById("confirm-assignment")
  .addEventListener("click", function () {
    if (!selectedProposalId || !selectedSupervisorId) {
      alert("Please select a supervisor first.");
      return;
    }

    fetch("pocess_assign_superviosr.php", {
      // Fixed spelling
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `supervisor_id=${selectedSupervisorId}&proposal_id=${selectedProposalId}`,
    })
      .then((response) => response.text())
      .then((message) => {
        alert(message);
        closeAssignPopup();
        location.reload(); // Refresh page to reflect changes
      })
      .catch((error) => console.error("Error assigning supervisor:", error));
  });
