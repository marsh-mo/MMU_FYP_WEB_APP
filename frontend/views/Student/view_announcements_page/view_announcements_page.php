<?php
session_start();
include '../../../../backend/config/db_connect.php'; // Database connection file
include '../../../../backend/models/announcements_model.php';

// Fetch announcements from the database
$announcements_result = getAnnouncements($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcements</title>
    <link rel="stylesheet" href="../../../css/view_announcements_page.css">
</head>
<body>

    <!-- Full-width header section -->
    <div class="header" style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
        <h2>View Announcements</h2>
        <a href="../../../../frontend/views/all_users/login_page/login_page.php">
        <button class="logout-btn">Logout</button>
    </a>
    </div>

    <!-- Main container with sidebar and content -->
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <ul>
                <li class="active"><a href="#">📁 View Announcements</a></li>
            </ul>
        </div>

        <!-- Content Area -->
        <div class="content">
            <h3>Announcements</h3>
            
            <?php if ($announcements_result->num_rows > 0): ?>
                <?php while ($announcement = $announcements_result->fetch_assoc()): ?>
                    <div class="announcement">
                        <h4>📢 <?php echo htmlspecialchars($announcement['Title']); ?></h4>
                        <p><?php echo htmlspecialchars($announcement['Description']); ?></p>
                        <span class="date">Posted on: <?php echo date("M d, Y", strtotime($announcement['Date_Posted'])); ?></span>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No announcements available.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
