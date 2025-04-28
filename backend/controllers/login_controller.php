<?php
session_start();
include '../config/db_connect.php'; // Database connection
include '../models/user_model.php'; // User_model

if (isset($_GET['login'])) {
    // Retrieve data from GET
    $email = trim($_GET['email']);
    $password = $_GET['password'];

    // Validate input
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and Password are required!";
        header("Location: ../../frontend/views/all_users/login_page/login_page.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: ../../frontend/views/all_users/login_page/login_page.php");
        exit();
    }

   
    $user =getUserByEmail($conn, $email);

    // Verify password
    if ($user && password_verify($password, $user['Password'])) {
        // Successful login
        $_SESSION['user_id'] = $user['User_ID'];
        $_SESSION['full_name'] = $user['Full_Name'];
        $_SESSION['email'] = $user['Email'];
        $_SESSION['role'] = $user['Role'];

        // Redirect based on role
        if ($user['Role'] === 'Student') {
            header("Location: ../../frontend/views/Student/student_home_page/student_home_page.php");
        } elseif ($user['Role'] === 'Supervisor') {
            header("Location: ../../frontend/views/Supervisor/manage_proposal_page/approved_proposals_view.php");
        } elseif ($user['Role'] === 'Admin') {
            header("Location: ../../frontend/views/Admin/view_announcements.php");
        }
        exit();
    } else {
        // Incorrect password
        $_SESSION['error'] = "Incorrect email or password!";
        header("Location: ../../frontend/views/all_users/login_page/login_page.php");
        exit();
    }
    
} else {
    // Invalid access to this file
    $_SESSION['error'] = "Invalid request!";
    header("Location: ../../frontend/views/all_users/login_page/login_page.php");
    exit();
}

?>
