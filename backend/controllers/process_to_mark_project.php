<?php
include '../config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_id = $_POST['project_id'];
    $marks = $_POST['marks'];
    $comment = $_POST['comment'];

    // Validate marks (Ensure it's numeric and within 0-100)
    if (!is_numeric($marks) || $marks < 0 || $marks > 100) {
        echo json_encode(["status" => "error", "message" => "Invalid marks value."]);
        exit();
    }

    // Check if the project is already marked
    $check_sql = "SELECT Marks FROM submitted_project WHERE Project_ID = ? AND Marks IS NOT NULL";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $project_id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // If marks already exist, return an error
        echo json_encode(["status" => "error", "message" => "Project has already been marked."]);
        exit();
    }
    
    $check_stmt->close();

    // Insert marks into submitted_project table
    $insert_sql = "UPDATE submitted_project SET Marks = ?, Feedback = ?, Status = 'Reviewed' WHERE Project_ID = ?";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("isi", $marks, $comment, $project_id);

    if ($insert_stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Marks assigned successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }

    $insert_stmt->close();
}
?>
