<?php
function getProposal($conn, $user_id){
    $proposal_query = $conn->prepare("
        SELECT Proposal_Title, Submission_Date, Proposal_File, Status 
        FROM Proposal 
        WHERE Submitted_By = ?
    ");
    $proposal_query->bind_param("i", $user_id);
    $proposal_query->execute();
    $proposal_result = $proposal_query->get_result();
    return $proposal_result->fetch_assoc() ?? null;
}


function checkIfUserSubmittedProposal($conn, $user_id){
    $check_query = $conn->prepare("SELECT Proposal_ID FROM Proposal WHERE Submitted_By = ?");
    $check_query->bind_param("i", $user_id);
    $check_query->execute();
    $check_result = $check_query->get_result();
    return $check_result->num_rows > 0;
}

function addProposal($conn, $file_destination, $proposal_title, $user_id){
    $stmt = $conn->prepare("INSERT INTO Proposal (Proposal_File, Proposal_Title, Submitted_By, Submission_Date, Status) VALUES (?, ?, ?, NOW(), 'Pending')");
    $stmt->bind_param("ssi", $file_destination, $proposal_title, $user_id);
    return $stmt->execute();
}

function getProposals($conn, $user_id, $search_query, $status){
    $sql = "SELECT * FROM proposal WHERE Submitted_By = $user_id AND Status = '$status'";
    if (!empty($search_query)) {
        $sql .= " AND (Proposal_ID LIKE '%$search_query%' 
        OR Proposal_Title LIKE '%$search_query%')";
    }
    $result = mysqli_query($conn, $sql);

    $proposals = []; // Array to store proposal data
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $proposals[] = $row; // Add each proposal to the array
        }
    } else {
        $error = "Error: " . mysqli_error($conn);
    }

    return $proposals;
}

?>