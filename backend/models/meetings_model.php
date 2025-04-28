<?php
function getMeetings($conn, $user_id){
    $meetings_query = $conn->prepare("
    SELECT Meeting.Meeting_Link, Meeting.Date, Meeting.Time, Meeting.Notes, User.Full_Name AS Supervisor_Name 
    FROM Meeting
    INNER JOIN Project ON Meeting.Project_ID = Project.Project_ID
    INNER JOIN User ON Meeting.Supervisor_ID = User.User_ID
    WHERE Project.Assigned_Student_ID = ? AND Meeting.Date >= CURDATE()
    ORDER BY Meeting.Date ASC
");
$meetings_query->bind_param("i", $user_id);
$meetings_query->execute();
    return $meetings_query->get_result();
}

function addMeeting($conn, $project_id, $supervisor_id, $meeting_link, $date, $time, $notes){
    // Insert meeting into database
    $insert_query = $conn->prepare("
    INSERT INTO Meeting (Project_ID, Supervisor_ID, Meeting_Link, Date, Time, Notes) 
    VALUES (?, ?, ?, ?, ?, ?)
");
$insert_query->bind_param("iissss", $project_id, $supervisor_id, $meeting_link, $date, $time, $notes);
return $insert_query->execute();
}

function supervisorGetMeetings($conn, $supervisor_id){
    $meetings_query = $conn->prepare("
    SELECT Meeting.Meeting_Link, Meeting.Date, Meeting.Time, Meeting.Notes, 
           User.Full_Name AS Student_Name
    FROM Meeting
    JOIN Project ON Meeting.Project_ID = Project.Project_ID
    JOIN User ON Project.Assigned_Student_ID = User.User_ID
    WHERE Meeting.Supervisor_ID = ? 
    AND Meeting.Date >= CURDATE()
    ORDER BY Meeting.Date, Meeting.Time
");

$meetings_query->bind_param("i", $supervisor_id);
$meetings_query->execute();
return $meetings_query->get_result();
}

?>

