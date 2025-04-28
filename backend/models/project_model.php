<?php
function getAssignedProject($conn, $user_id){
    $project_query = $conn->prepare("
        SELECT Project_ID, Title FROM Project WHERE Assigned_Student_ID = ?
    ");
    $project_query->bind_param("i", $user_id);
    $project_query->execute();
    $project_result = $project_query->get_result();

    return $project_result->fetch_assoc() ?? null;

}

function submitProject($conn, $project_id, $target_file, $submission_date){
    $insert_query = $conn->prepare("
            INSERT INTO Submitted_Project (Project_ID, Submission_File, Submission_Date) 
            VALUES (?, ?, ?)
        ");
        $insert_query->bind_param("iss", $project_id, $target_file, $submission_date);
        return $insert_query->execute();
}

function getSupervisedProjects($conn, $supervisor_id){
    // Fetch projects supervised by the logged-in supervisor (for dropdown selection)
$projects_query = $conn->prepare("
SELECT Project.Project_ID, Project.Title, User.Full_Name AS Student_Name
FROM Project
JOIN User ON Project.Assigned_Student_ID = User.User_ID
WHERE Project.Supervisor_ID = ?
");

$projects_query->bind_param("i", $supervisor_id);
$projects_query->execute();
return $projects_query->get_result();
}

function getProjectsForMarking($conn, $user_id, $search_query) {
    $sql = "SELECT sp.Project_ID, p.Title AS Project_Title, sp.Submission_File, 
                   p.Assigned_Student_ID, COALESCE(sp.Marks, 'Not Marked') AS Marks
            FROM submitted_project sp
            INNER JOIN project p ON sp.Project_ID = p.Project_ID
            WHERE p.Supervisor_ID = ?";

    if (!empty($search_query)) {
        $sql .= " AND (sp.Project_ID LIKE ? OR p.Title LIKE ?)";
    }

    $stmt = $conn->prepare($sql);

    if (!empty($search_query)) {
        $search_param = "%" . $search_query . "%";
        $stmt->bind_param("iss", $user_id, $search_param, $search_param);
    } else {
        $stmt->bind_param("i", $user_id);
    }

    $stmt->execute();
    return $stmt->get_result();
}


?>