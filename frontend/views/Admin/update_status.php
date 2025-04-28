<?php
include '../../../backend/config/db_connect.php';// Ensure database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $proposal_id = $_POST['proposal_id'];
    $new_status = $_POST['status'];

    if (!in_array($new_status, ['Approved', 'Rejected'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid status']);
        exit;
    }

    // Update status in database
    $stmt = $conn->prepare("UPDATE proposal SET Status = ? WHERE Proposal_ID = ?");
    $stmt->bind_param("si", $new_status, $proposal_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating status']);
    }

    $stmt->close();
    $conn->close();
}
?>
