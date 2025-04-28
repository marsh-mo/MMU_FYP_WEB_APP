<?php
session_start();
include '../config/db_connect.php';


$user_id = $_SESSION['user_id'];

// Get the status from the form submission (default to 'Pending')
$status = isset($_GET['status']) ? $_GET['status'] : 'Pending';

// Define the pages for each status
$pageMap = [
    'Pending' => '../../frontend/views/Supervisor/manage_proposal_page/pending_proposals_View.php',
    'Approved' => '../../frontend/views/Supervisor/manage_proposal_page/approved_proposals_view.php',
    'Rejected' => '../../frontend/views/Supervisor/manage_proposal_page/rejected_proposals_view.php'
];

// Redirect to the corresponding page if status is valid
if (array_key_exists($status, $pageMap)) {
    header("Location: " . $pageMap[$status]);
    exit(); // Ensure script stops execution after redirection
}

// If invalid status is given, show error
echo "Invalid status selected.";
?>
