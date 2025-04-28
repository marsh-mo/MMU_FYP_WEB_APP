<?php
session_start();
include '../../../backend/config/db_connect.php'; // Database connection file

// Prepare and execute query
$announcements_query = $conn->prepare("SELECT Proposal_ID, Proposal_File, Submission_Date, Status, Proposal_Title FROM proposal WHERE Status = 'Pending'");
$announcements_query->execute();
$proposals = $announcements_query->get_result(); // For MySQLi

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcements</title>
    <link rel="stylesheet" href="view_announcements.css?v=<?php echo time(); ?>">
    <script defer src="update_Status.js?v=<?php echo time(); ?>"></script>
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
                <h3>Pending Proposals</h3>
                <main>
                    <?php if (isset($error)): ?>
                        <p class="error"><?php echo $error; ?></p>
                    <?php endif; ?>

                    <?php if ($proposals->num_rows > 0): ?>
                        <?php while ($proposal = $proposals->fetch_assoc()): ?>
                            <div id="proposal-list" class="proposal-card">
                                <p><strong>Proposal Id:</strong> <?php echo htmlspecialchars($proposal['Proposal_ID']); ?></p>
                                <p><strong>Proposal Title:</strong> <?php echo htmlspecialchars($proposal['Proposal_Title']); ?></p>
                                <p><strong>Submitted on:</strong> <?php echo htmlspecialchars($proposal['Submission_Date']); ?></p>
                                <p><strong>Status:</strong> <?php echo htmlspecialchars($proposal['Status']); ?></p>
                                <a href="downloadFiles.php?file=<?php echo urlencode($proposal['Proposal_File']); ?>" target="_blank">
                                    <?php echo htmlspecialchars($proposal['Proposal_File']); ?>
                                </a>
                                <button class="assign-btn" onclick="updateProposalStatus(<?php echo $proposal['Proposal_ID']; ?>, 'Approved')">Approve</button>
                                <button class="assign-btn" onclick="updateProposalStatus(<?php echo $proposal['Proposal_ID']; ?>, 'Rejected')">Reject</button>

                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No proposals found.</p>
                    <?php endif; ?>
                </main>
            </div>
        </div>
    </div>

</body>
</html>
