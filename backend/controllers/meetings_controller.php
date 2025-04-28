<?php
session_start();
include '../config/db_connect.php';
include '../models/meetings_model.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_meeting'])) {
    // Get form inputs
    $supervisor_id =  $_SESSION['user_id']; 
    $project_id = $_POST['project_id'];
    $meeting_link = $_POST['meeting_link'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $notes = $_POST['notes'];

    // Validate input
    if (!empty($project_id) && !empty($meeting_link) && !empty($date) && !empty($time) && !empty($notes)) {
        
        if (addMeeting($conn, $project_id, $supervisor_id, $meeting_link, $date, $time, $notes)) {
            $success_message = "Meeting successfully created!";
            header("Location: ../../frontend/views/Supervisor/meeting_management/meeting_management_page.php");
        } else {
            $error_message = "Error creating meeting. Please try again.";
        }
    } else {
        $error_message = "All fields are required.";
    }
}

?>