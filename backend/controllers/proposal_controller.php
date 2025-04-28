<?php
session_start();
include '../config/db_connect.php'; // Include database connection
include '../models/proposal_model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_proposal']) && isset($_FILES['proposal_file'])) {
    //Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] = "You must be logged in to submit a proposal.";
        header("Location: ../../frontend/views/all_users/login_page/login_page.php");
        exit();
    }
    
    $user_id = $_SESSION['user_id'];

    // Validate CSRF Token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid request!";
        header("Location: ../../frontend/views/Student/project_management_page/project_management_page.php?page=manage_proposal");
        exit();
    }

    $proposal_title = trim($_POST['proposal_title']);
    // Check if user already submitted a proposal

    if (checkIfUserSubmittedProposal($conn, $user_id)) {
        $_SESSION['error'] = "You have already submitted a proposal.";
        header("Location: ../../frontend/views/Student/project_management_page/project_management_page.php?page=manage_proposal");
        exit();
    }

    // File upload logic
    $allowed_extensions = ['pdf', 'docx'];
    $file_name = $_FILES['proposal_file']['name'];
    $file_tmp = $_FILES['proposal_file']['tmp_name'];
    $file_size = $_FILES['proposal_file']['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Validate file type
    if (!in_array($file_ext, $allowed_extensions)) {
        $_SESSION['error'] = "Invalid file type. Only PDF and DOCX are allowed.";
        header("Location: ../../frontend/views/Student/project_management_page/project_management_page.php?page=manage_proposal");
        exit();
    }

    // Limit file size (Max: 5MB)
    if ($file_size > 5 * 1024 * 1024) { // 5MB
        $_SESSION['error'] = "File size exceeds the 5MB limit.";
        header("Location: ../../frontend/views/Student/project_management_page/project_management_page.php?page=manage_proposal");
        exit();
    }

    // Rename the file to prevent overwriting & security risks
    $new_file_name = uniqid("proposal_", true) . "." . $file_ext;
    $file_destination = "../../uploads/" . $new_file_name;

    if (move_uploaded_file($file_tmp, $file_destination)) {

        if (addProposal($conn, $new_file_name, $proposal_title, $user_id)) {
            $_SESSION['success'] = "Proposal submitted successfully!";
        } else {
            $_SESSION['error'] = "Error submitting proposal.";
        }
    } else {
        $_SESSION['error'] = "Failed to upload file.";
    }

    header("Location: ../../frontend/views/Student/project_management_page/project_management_page.php?page=manage_proposal");
    exit();
}
?>
