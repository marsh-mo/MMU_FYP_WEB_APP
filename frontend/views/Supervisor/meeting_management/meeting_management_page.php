<?php
session_start();
include '../../../../backend/config/db_connect.php'; // Database connection file
include '../../../../backend/models/meetings_model.php';
include '../../../../backend/models/project_model.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

// Fetch supervisor ID from session
$supervisor_id =  $_SESSION['user_id']; 


// Fetch upcoming meetings assigned to the supervisor
$meetings_result =supervisorGetMeetings($conn, $supervisor_id);

// Fetch projects supervised by the logged-in supervisor (for dropdown selection)
$projects_result = getSupervisedProjects($conn, $supervisor_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor - Manage Meetings</title>
    <link rel="stylesheet" href="../../../css/meeting_management.css?v=<?php echo time(); ?>">
</head>
<body>

    <!-- Full-width header section -->
    <div class="header" style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
        <h2>Supervisor Dashboard - Manage Meetings</h2>
    <a href="../../../../frontend/views/all_users/login_page/login_page.php">
        <button class="logout-btn">Logout</button>
    </a>
    </div>

    <!-- Main container with sidebar and content -->
    <div class="container">
        <!-- Sidebar -->
    <aside class="sidebar">
        <a href="../view_profile_page/profile_page.php"><button class="sidebar-btn">Profile</button></a> 
        <a href="../manage_proposal_page/approved_proposals_view.php"><button class="sidebar-btn">My Proposals</button></a>
        <a href="../meeting_management/meeting_management_page.php"><button class="sidebar-btn">Meeting Management</button></a>
        <a href="../project_management_page/project_management_page.php"><button class="sidebar-btn">Project Management</button></a>
    </aside>

        <!-- Content Area -->
        <div class="content">
            <div class="meetings-box">
                <h3>Upcoming Meetings</h3>
                
                <?php if ($meetings_result->num_rows > 0): ?>
                    <?php while ($meeting = $meetings_result->fetch_assoc()): ?>
                        <div class="meeting-item">
                            <h4>👨‍🎓 Student: <?php echo htmlspecialchars($meeting['Student_Name']); ?></h4>
                            <p class="date-time">📅 <?php echo date("M d, Y", strtotime($meeting['Date'])); ?> | ⏰ <?php echo date("h:i A", strtotime($meeting['Time'])); ?></p>
                            <p><strong>Meeting Link:</strong> <a href="<?php echo htmlspecialchars($meeting['Meeting_Link']); ?>" target="_blank"><?php echo htmlspecialchars($meeting['Meeting_Link']); ?></a></p>
                            <p><strong>Notes:</strong> <?php echo htmlspecialchars($meeting['Notes']); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No upcoming meetings.</p>
                <?php endif; ?>
            </div>

            <!-- Meeting Creation Form -->
            <div class="create-meeting-box">
                <h3>Create New Meeting</h3>
                <?php if (isset($success_message)) echo "<p style='color: green;'>$success_message</p>"; ?>
                <?php if (isset($error_message)) echo "<p style='color: red;'>$error_message</p>"; ?>

                <form method="POST" action="../../../../backend/controllers/meetings_controller.php">
                    <label for="project_id">Select Project:</label>
                    <select name="project_id" required>
                        <option value="">-- Select Project --</option>
                        <?php while ($project = $projects_result->fetch_assoc()): ?>
                            <option value="<?php echo $project['Project_ID']; ?>">
                                <?php echo htmlspecialchars($project['Title']) . " - " . htmlspecialchars($project['Student_Name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <label for="meeting_link">Meeting Link:</label>
                    <input type="url" name="meeting_link" required placeholder="Enter meeting link">

                    <label for="date">Date:</label>
                    <input type="date" name="date" required>

                    <label for="time">Time:</label>
                    <input type="time" name="time" required>

                    <label for="notes">Notes:</label>
                    <textarea name="notes" required placeholder="Enter meeting agenda"></textarea>

                    <button type="submit" name="create_meeting">Create Meeting</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
