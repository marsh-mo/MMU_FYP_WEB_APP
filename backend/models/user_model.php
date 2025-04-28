<?php
function registerUser($conn, $full_name, $email, $hashed_password, $role){
    $stmt = $conn->prepare("INSERT INTO User (Full_Name, Email, Password, Role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $email, $hashed_password, $role);
    return $stmt->execute();
}


function checkIfUserAlreadyExists($conn, $email){
    $stmt = $conn->prepare("SELECT email FROM User WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

function getUserByEmail($conn, $email) {
    $stmt = $conn->prepare("SELECT * FROM User WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getSuperVisorDetails($conn, $user_id){
    $supervisor_query = $conn->prepare("
        SELECT User.Full_Name, User.Email 
        FROM User 
        INNER JOIN Project ON User.User_ID = Project.Supervisor_ID 
        WHERE Project.Assigned_Student_ID = ?
    ");
    $supervisor_query->bind_param("i", $user_id);
    $supervisor_query->execute();
    $supervisor_result = $supervisor_query->get_result();
    return $supervisor_result->fetch_assoc();
}
?>
