<?php
include '../config/db_connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $proposal_id = $_POST['proposal_id'];

    // Check if the proposal is approved
    $check_status_sql = "SELECT Proposal_Title FROM proposal WHERE Proposal_ID = ? AND Status = 'Approved'";
    $status_stmt = $conn->prepare($check_status_sql);
    $status_stmt->bind_param("i", $proposal_id);
    $status_stmt->execute();
    $status_stmt->bind_result($Proposal_Title);
    $status_stmt->fetch();
    $status_stmt->close();
    
    // Fetch Supervisor_ID linked to the proposal
    $supervisor_id = null;
    $get_supervisor_sql = "SELECT Submitted_By FROM proposal WHERE Proposal_ID = ?";
    $get_supervisor_stmt = $conn->prepare($get_supervisor_sql);
    $get_supervisor_stmt->bind_param("i", $proposal_id);
    $get_supervisor_stmt->execute();
    $get_supervisor_stmt->bind_result($supervisor_id);
    $get_supervisor_stmt->fetch();
    $get_supervisor_stmt->close();

    // Insert new project assignment
    $insert_sql = "INSERT INTO project (Title, Proposal_ID, Assigned_Student_ID, Supervisor_ID) VALUES (?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("siii", $Proposal_Title, $proposal_id, $student_id, $supervisor_id);
  
          if ($insert_stmt->execute()) {
            // Update proposal status to 'Assigned' after successful insertion
            $update_status_sql = "UPDATE proposal SET Status = 'Assigned' WHERE Proposal_ID = ?";
            $update_stmt = $conn->prepare($update_status_sql);
            $update_stmt->bind_param("i", $proposal_id);
            $update_stmt->execute();
            $update_stmt->close();

            echo "Project assigned successfully ";
        } else {
            echo "Error: " . $conn->error;
        }

    $insert_stmt->close();
}
?>
