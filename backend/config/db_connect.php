<?php
$host = "localhost"; // Change this if your database is on another server
$user = "root"; // Your database username
$pass = ""; // Your database password
$db_name = "data"; // Your database name

$conn = new mysqli($host, $user, $pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
