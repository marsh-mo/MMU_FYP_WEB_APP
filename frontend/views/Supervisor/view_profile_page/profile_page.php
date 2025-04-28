<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../css/profile_page.css ?v=<?php echo time();?>" >
    <link rel="stylesheet" href="../../../css/supervisor_manage_proposals_page.css" ?v=<?php echo time();?>>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Final Year Project</title>
</head>
<body>
    <div class="header" style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;" >
        <h1>FYP Supervisor Portal</h1>
    <a href="../../../../frontend/views/all_users/login_page/login_page.php">
        <button class="logout-btn">Logout</button>
    </a>


    </div>
    <div class="container">
    <aside class="sidebar">
        <a href="../view_profile_page/profile_page.php"><button class="sidebar-btn">Profile</button></a> 
        <a href="../manage_proposal_page/approved_proposals_view.php"><button class="sidebar-btn">My Proposals</button></a>
        <a href="../meeting_management/meeting_management_page.php"><button class="sidebar-btn">Meeting Management</button></a>
        <a href="../project_management_page/project_management_page.php"><button class="sidebar-btn">Project Management</button></a>
    </aside>
        <div class="content">
            <div class="form-container">
                <h2>About me</h2>
                <div class="form-group">
                    
                    <input type="text" id="fullName" value="<?php echo ($_SESSION['full_name']); ?>" disabled>
                </div>
                <div class="form-group">
                    <input type="email" id="email" value="<?php echo ( $_SESSION['email']); ?>" disabled>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
