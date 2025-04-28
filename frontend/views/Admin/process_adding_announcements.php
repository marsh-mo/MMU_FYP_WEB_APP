<?php
session_start();

include '../../../backend/config/db_connect.php'; // Include database connection

header('Content-Type: application/json'); // Set response type to JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $admin_id = $_SESSION['user_id']; // Change dynamically if needed (e.g., from session user ID)

    if (!empty($title) && !empty($description)) {
        $stmt = $conn->prepare("INSERT INTO announcements (Admin_ID, Title, Description, Date_Posted) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $admin_id, $title, $description);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
            exit();
        } else {
            echo json_encode(["success" => false, "error" => $stmt->error]);
            exit();
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "error" => "Missing required fields"]);
        exit();
    }
}
?>
