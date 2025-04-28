<?php
session_start();
include '../../../backend/config/db_connect.php'; // Database connection file

// Fetch announcements from the database
$announcements_query = $conn->prepare("SELECT Title, Description, Date_Posted FROM announcements ORDER BY Date_Posted DESC");
$announcements_query->execute();
$announcements_result = $announcements_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcements</title>
    <link rel="stylesheet" href="view_announcements.css ?v=<?php echo time();?>">
    <script defer src="uploade_announcement.js ?v=<?php echo time();?>"></script>
    
</head>
<body>

    <!-- Full-width header section -->
    <div class="header" style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
        <h2>View Announcements</h2>
        <a href="../all_users/login_page/login_page.php">
        <button class="logout-btn">Logout</button>
    </a>
    </div>

    <!-- Main container with sidebar and content -->
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <ul>
                <li><a href="view_pending_proposals.php">📁 View Pending Proposals</a></li>
                <li><a href="view_approved_proposals.php">✅ View Approved Proposals</a></li>
                <li><a href="view_announcements.php">📢 View Announcements</a></li>
                <li><a href="users_list.php">👥 Manage Users</a></li>
            </ul>
        </div>

        <!-- Content Area -->
        <div class="content">
        <div class="new">
      <!-- New Announcement Button -->
<button class="New-btn" id="new-button" onclick="toggleForm()">New</button>

<!-- Modal Overlay (clicking outside the form will close it) -->
<div id="overlay" class="overlay" onclick="closeForm()"></div>

<!-- Announcement Submission Form -->
<div id="upload-form" class="upload-form" style="display: none;">
    <h3>Submit New Announcement</h3>
    
    <!-- Form Start -->
    <form method="post" action="process_adding_announcements.php" id="mainForm">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <!-- Button Container -->
        <div class="button-container">
            <button type="submit" class="submit-btn">Submit</button>
            <button type="button" class="cancel-btn" onclick="closeForm()">Cancel</button>
        </div>
    </form>
    <!-- Form End -->
</div>

            <h3>Announcements</h3>
            <main>
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
            </main>
        </div>
    </div>

</body>
</html>
