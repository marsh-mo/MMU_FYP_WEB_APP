<?php
session_start();
include '../config/db_connect.php'; // Database connection
include '../models/user_model.php'; // User_model

if (isset($_POST['register'])) {
    // Get form data
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = "Student";

    // Store input values to repopulate in case of errors
    $_SESSION['full_name'] = $full_name;
    $_SESSION['email'] = $email;

    // Server-side Validation
    if (empty($full_name) || empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: ../../frontend/views/Student/registration_page/registration_page.php");
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format!";
        header("Location: ../../frontend/views/Student/registration_page/registration_page.php");
        exit();
    }

    // Updated password validation (only one special character required)
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).{8,}$/", $password)) {
        $_SESSION['error'] = "Password must be at least 8 characters, contain one uppercase letter, and one special character.";
        header("Location: ../../frontend/views/Student/registration_page/registration_page.php");
        exit();
    }

    // Prevent XSS Attacks
    $full_name = htmlspecialchars($full_name);
    $email = htmlspecialchars($email);

    // Check if email already exists
    if (checkIfUserAlreadyExists($conn, $email)) {
        $_SESSION['error'] = "Email already registered";
        header("Location: ../../frontend/views/Student/registration_page/registration_page.php");
        exit();
    }
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into database

    if (registerUser($conn, $full_name, $email, $hashed_password, $role)) {
        // Clear stored input values
        unset($_SESSION['full_name']);
        unset($_SESSION['email']);
        
        $_SESSION['success'] = "Registration successful! You can now login.";
        header("Location: ../../frontend/views/all_users/login_page/login_page.php");
        exit();
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again.";
        header("Location: ../../frontend/views/Student/registration_page/registration_page.php");
        exit();
    }
}
?>
