<?php
session_start();
include '../../../../backend/config/db_connect.php';
include '../../../../backend/models/project_model.php';



$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

$search_query = "";
if (isset($_GET['search']) && !empty($_GET['my_search'])) {
    $search_query = trim($_GET['my_search']);
}

// Fetch projects and check if they have been marked

$result = getProjectsForMarking($conn, $user_id, $search_query);

$projects = [];
while ($row = $result->fetch_assoc()) {
    $projects[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Year Project</title>
    <link rel="stylesheet" href="../../../css/supervisor_manage_proposals_page.css ?v=<?php echo time();?>">
    <script defer src="../../../js/mark_project.js ?v=<?php echo time();?>"></script>
</head>
<body>
<header style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
    <h1>FYP Supervisor Portal</h1>
    <a href="../../../../frontend/views/all_users/login_page/login_page.php">
        <button class="logout-btn">Logout</button>
    </a>
</header>
<div class="container">
    <aside class="sidebar">
        <a href="../view_profile_page/profile_page.php"><button class="sidebar-btn">Profile</button></a> 
        <a href="../manage_proposal_page/approved_proposals_view.php"><button class="sidebar-btn">My Proposals</button></a>
        <a href="../meeting_management/meeting_management_page.php"><button class="sidebar-btn">Meeting Management</button></a>
        <a href="../project_management_page/project_management_page.php"><button class="sidebar-btn">Project Management</button></a>
    </aside>
    <div class="content">
    <section class="action-bar">
            <form action="" method="GET" class="searchbar">
                 <input type="text" name="my_search">
                  <input type="submit"name="search" value="Search">                 
             </form>
        </section>
        <main>
        <?php if (!empty($projects)): ?>
    <?php foreach ($projects as $project): ?>
        <div class="proposal-card">
            <p><strong>Project Id:</strong> <?php echo $project['Project_ID']; ?></p>
            <p><strong>Project Title:</strong> <?php echo $project['Project_Title']; ?></p>
            <p><strong>Submission File:</strong> 
                <a href="../../../../backend/helpers/downloadFIles.php?file=<?php echo urlencode($project['Submission_File']); ?>" target="_blank">
                    <?php echo htmlspecialchars(basename($project['Submission_File'])); ?>
                </a>
            </p>
            <p><strong>Assigned Student ID:</strong> 
                <?php echo $project['Assigned_Student_ID']; ?>
            </p>
            <p><strong>Marks:</strong> 
                <?php echo ($project['Marks'] !== 'Not Marked') ? $project['Marks'] : 'Not Marked'; ?>
            </p>
            <!-- Disable button if marks exist -->
            <button class="mark-btn" 
                onclick="openAssignPopup(<?php echo (int)$project['Project_ID']; ?>)" 
                <?php echo ($project['Marks'] !== 'Not Marked') ? 'disabled' : ''; ?>>
                <?php echo ($project['Marks'] !== 'Not Marked') ? 'Marked' : 'Mark'; ?>
            </button>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No submitted projects found.</p>
<?php endif; ?>

        </main>
    </div>
</div>
<div id="assign-popup" class="popup-overlay">
    <div class="popup-content">
        <h2>Enter Grade</h2>
        <input type="number" id="grade-input" placeholder="Enter grade (0-100)" min="0" max="100">
        <h2>Enter Comment</h2>
        <input type="text" id="comment-input">
        <button onclick="submitGrade()">Submit</button>
        <button onclick="closeAssignPopup()">Cancel</button>
    </div>
</div>
</body>
</html>
