<?php
include '../../../backend/config/db_connect.php';

$sql = "SELECT User_ID, Full_Name FROM user WHERE Role = 'Supervisor'";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$supervisors = [];

while ($row = $result->fetch_assoc()) {
    $supervisors[] = $row;
}

// Check if supervisors are found
if (empty($supervisors)) {
    echo json_encode(["error" => "No supervisors found"]);
} else {
    echo json_encode($supervisors);
}

$conn->close();

?>
