<?php
session_start();
include '../config/db_connect.php';
include '../models/proposal_model.php';
header('Content-Type: application/json'); // Set response type to JSON

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit();
}

$user_id = $_SESSION['user_id']; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['proposal_file']) && isset($_POST['Proposal_Title'])) {
    $file = $_FILES['proposal_file'];
    $projectTitle = trim($_POST['Proposal_Title']);

    // Validate project title
    if (empty($projectTitle)) {
        echo json_encode(["status" => "error", "message" => "Project title cannot be empty."]);
        exit();
    }

    // Allowed file types
    $allowedExtensions = ['pdf', 'doc', 'docx'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $maxFileSize = 5 * 1024 * 1024; // 5MB limit

    if (!in_array($fileExtension, $allowedExtensions)) {
        echo json_encode(["status" => "error", "message" => "Invalid file type. Only PDF and Word documents are allowed."]);
        exit();
    }

    if ($file['size'] > $maxFileSize) {
        echo json_encode(["status" => "error", "message" => "File size exceeds the 5MB limit."]);
        exit();
    }

    // Ensure no file upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["status" => "error", "message" => "File upload error."]);
        exit();
    }

    // Ensure upload directory exists
    $uploadDir = '../../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create directory if not exists
    }

    // Generate unique filename to prevent conflicts
    $uniqueFileName = time() . "_" . basename($file['name']);
    $destinationPath = $uploadDir . $uniqueFileName;

    // Move file to upload directory
    if (!move_uploaded_file($file['tmp_name'], $destinationPath)) {
        echo json_encode(["status" => "error", "message" => "Failed to move uploaded file."]);
        exit();
    }

    // Insert into database
    
    
    if (addProposal($conn, $uniqueFileName,  $projectTitle, $user_id)) {
        echo json_encode(["status" => "success", "message" => "File uploaded successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: "]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>
