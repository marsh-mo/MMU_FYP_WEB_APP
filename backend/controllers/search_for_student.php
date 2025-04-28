<?php
include '../config/db_connect.php';

$sql = "SELECT User.User_ID, User.Full_Name 
        FROM User
        LEFT JOIN project ON User.User_ID = project.Assigned_Student_ID
        WHERE User.Role = 'Student' 
        AND project.Assigned_Student_ID IS NULL";

$result = $conn->query($sql);
$students = [];

while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

echo json_encode($students);

?>
