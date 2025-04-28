<?php
include '../../../backend/config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supervisor_id = $_POST['supervisor_id'];
    $proposal_id = $_POST['proposal_id'];

    // Fetch Student ID linked to the proposal
    $student_id = 13;
    $project_title = null;

    $get_proposal_sql = "SELECT Submitted_By, Proposal_Title FROM proposal WHERE Proposal_ID = ?";
    $get_proposal_stmt = $conn->prepare($get_proposal_sql);
    $get_proposal_stmt->bind_param("i", $proposal_id);
    $get_proposal_stmt->execute();
    $get_proposal_stmt->bind_result($student_id, $project_title);
    $get_proposal_stmt->fetch();
    $get_proposal_stmt->close();

    if ($student_id !== null) {
        // Insert new project assignment
        $insert_sql = "INSERT INTO project (Title, Proposal_ID, Assigned_Student_ID, Supervisor_ID) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("siii", $project_title, $proposal_id, $student_id, $supervisor_id);

        if ($insert_stmt->execute()) {
            // Update proposal status to 'Assigned'
            $update_status_sql = "UPDATE proposal SET Status = 'Assigned' WHERE Proposal_ID = ?";
            $update_stmt = $conn->prepare($update_status_sql);
            $update_stmt->bind_param("i", $proposal_id);
            $update_stmt->execute();
            $update_stmt->close();

            echo "Project assigned successfully";
        } else {
            echo "Error: " . $conn->error;
        }

        $insert_stmt->close();
    } else {
        echo "Error: Student ID not found for the given proposal.";
    }

    $conn->close();
}
?>
