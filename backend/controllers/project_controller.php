<?php
session_start();
include '../config/db_connect.php';
include '../models/project_model.php';
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must be logged in!";
    header("Location: ../../frontend/views/all_users/login_page/login_page.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_project'])) {
    $student_id = $_SESSION['user_id'];
    $project_id = $_POST['project_id'];
    
    // File upload logic
    $target_dir = "../../uploads/";
    $file_name = basename($_FILES["project_file"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;
    
    if (move_uploaded_file($_FILES["project_file"]["tmp_name"], $target_file)) {
        $submission_date = date("Y-m-d");

        // Insert into database
        if (submitProject($conn, $project_id, $target_file, $submission_date)) {
            $_SESSION['success'] = "Project submitted successfully!";
        } else {
            $_SESSION['error'] = "Error submitting project.";
        }
    } else {
        $_SESSION['error'] = "File upload failed.";
    }

    header("Location: ../../frontend/views/Student/project_management_page/project_management_page.php?page=view_fyp");
    exit();
}
?>
