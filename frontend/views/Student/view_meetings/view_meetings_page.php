<?php
session_start();
include '../../../../backend/config/db_connect.php'; // Database connection file
include '../../../../backend/models/meetings_model.php';

// Fetch user ID from session
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must be logged in!";
    header("Location: ../../all_users/login_page/login_page.php");
    exit();
}

$user_id = $_SESSION['user_id']; 

// Fetch upcoming meetings assigned to the student
$meetings_result = getMeetings($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Meetings</title>
    <link rel="stylesheet" href="../../../css/view_meetings_page.css">
</head>
<body>

    <!-- Full-width header section -->
    <div class="header" style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
        <h2>View Meetings</h2>
        <a href="../../../../frontend/views/all_users/login_page/login_page.php">
        <button class="logout-btn">Logout</button>
    </a>
    </div>

    <!-- Main container with sidebar and content -->
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <ul>
                <li class="<?= (isset($_GET['page']) && $_GET['page'] == 'view_meetings') ? 'active' : ''; ?>">
                    <a href="?page=view_meetings">📅 View Meetings</a>
                </li>
            </ul>
        </div>

        <!-- Content Area -->
        <div class="content">
            <div class="meetings-box">
                <h3>Upcoming Meetings</h3>
                
                <?php if ($meetings_result->num_rows > 0): ?>
                    <?php while ($meeting = $meetings_result->fetch_assoc()): ?>
                        <div class="meeting-item">
                            <h4>👨‍🏫 Supervisor: <?php echo htmlspecialchars($meeting['Supervisor_Name']); ?></h4>
                            <p class="date-time">📅 <?php echo date("M d, Y", strtotime($meeting['Date'])); ?> | ⏰ <?php echo date("h:i A", strtotime($meeting['Time'])); ?></p>
                            <p><strong>Meeting Link:</strong> <a href="<?php echo htmlspecialchars($meeting['Meeting_Link']); ?>" target="_blank"><?php echo htmlspecialchars($meeting['Meeting_Link']); ?></a></p>
                            <p><strong>Notes:</strong> <?php echo htmlspecialchars($meeting['Notes']); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No upcoming meetings.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
