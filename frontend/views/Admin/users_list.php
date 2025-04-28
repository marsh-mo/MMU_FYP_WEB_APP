<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="users_list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="view_announcements.css?v=<?php echo time(); ?>">
    <script defer src="remove_user.js?v=<?php echo time(); ?>"></script>
    <script defer src="add_new_user.js?v=<?php echo time(); ?>"></script>
   
</head>
<body>
    <div class="header" style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
        <h2>Manage Users</h2>
        <a href="../all_users/login_page/login_page.php">
        <button class="logout-btn">Logout</button>
    </a>
    </div>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="view_pending_proposals.php">📁 View Pending Proposals</a></li>
                <li><a href="view_approved_proposals.php">✅ View Approved Proposals</a></li>
                <li><a href="view_announcements.php">📢 View Announcements</a></li>
                <li class="active"><a href="users_list.php">👥 Manage Users</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="user-container">
                <div class="header">
                    <h2>User List</h2>
                    <button class="new-user-button">New</button>
                </div>
                <?php
                session_start();
                include '../../../backend/config/db_connect.php';
                $users_query = $conn->prepare("SELECT Full_Name, Role, Email, User_ID FROM user WHERE Role IN ('Student', 'Supervisor')");
                $users_query->execute();
                $query_result = $users_query->get_result();
                ?>
                <?php if ($query_result->num_rows > 0): ?>
                    <?php while ($user = $query_result->fetch_assoc()): ?>
                        <div class="user">
                            <div class="user-info">
                                <span class="user-name"><?php echo htmlspecialchars($user['Full_Name']); ?></span>
                                <span class="user-role"><?php echo htmlspecialchars($user['Role']); ?></span>
                            </div>
                            <span class="user-email"><?php echo htmlspecialchars($user['Email']); ?></span>
                            <div class="user-actions">
                                <button class="delete-button" onclick="deleteUserInfo(<?php echo $user['User_ID']; ?>)">Delete</button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No users available.</p>
                <?php endif; ?>
            </div>
            <div id="newUser-popup" class="popup-overlay">
                <div class="popup-content">
                    <h2>Enter Full Name</h2>
                    <input type="text" id="name-input">
                    <h2>Enter Email</h2>
                    <input type="email" id="email-input">
                    <h2>Select Role</h2>
                    <select id="role-input">
                        <option value="Student">Student</option>
                        <option value="Supervisor">Supervisor</option>
                    </select>
                    <h2>Enter Password</h2>
                    <input type="password" id="password-input">
                    <button id="submit-button">Submit</button>
                    <button class="close-button">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
