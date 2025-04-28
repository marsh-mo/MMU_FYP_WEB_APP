<?php
session_start();
include '../../../../backend/config/db_connect.php';
include '../../../../backend/models/proposal_model.php';

$user_id = $_SESSION['user_id'];
$status = 'Pending';

$search_query = "";
if (isset($_GET['search']) && !empty($_GET['my_search'])) {
    $search_query = trim($_GET['my_search']);
}

// Fetch proposals for the logged-in user
$proposals = getProposals($conn, $user_id, $search_query, $status);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Year Project</title>
    <script defer src="../../../js/uploade_new_proposal.js ?v=<?php echo time();?>"></script>
    <link rel="stylesheet" href="../../../css/supervisor_manage_proposals_page.css ?v=<?php echo time();?>">
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
       <a href="./approved_proposals_view.php"><button class="sidebar-btn">My Proposals</button></a>
       <a href="../meeting_management/meeting_management_page.php"><button class="sidebar-btn">Meeting Management</button></a>
        <a href="../project_management_page/project_management_page.php"><button class="sidebar-btn">Project Management</button></a>
    </aside>
    <div class="content">
        <section class="action-bar">
        <button class="New-btn" id="new-button">New</button>
        <form method="post" enctype="multipart/form-data" action="process_uploding_proposal.php">
                <div class="main-content">
                    <div id="upload-form" class="upload-form" style="display: none;">
                        <h3>Submit New Proposal</h3>
                        <!-- Add missing Project Title input -->
                        <label for="project-title">Project Title:</label>
                        <input type="text" id="project-title" name="project_title" required>

                        <!-- File upload input -->
                        <input id="file-input" name="proposal_file" type="file" class="hidden" required />

                        <div>
                            <button type="submit" class="submit-btn">Submit</button>
                            <button type="button" class="cancel-btn" id="cancel-button">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
            <form method="GET" action="../../../../backend/controllers/navigate_proposals_status.php" class="form-group">
                <select name="status" class="form-control dropdown" onchange="this.form.submit()">
                    <?php
                   
                    $statuses = ['Pending', 'Rejected', 'Approved'];
                    foreach ($statuses as $option) {
                        $selected = ($option === $status) ? 'selected' : '';
                        echo "<option value='$option' $selected>$option Proposals</option>";
                    }
                    ?>
                </select>
            </form>
             <form action="" method="GET" class="searchbar">
                 <input type="text" name="my_search">
                  <input type="submit"name="search" value="Search">                 
             </form>
        </section>
        <main>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>

            <?php if (!empty($proposals)): ?>
                <?php foreach ($proposals as $proposal): ?>
                    <div id="proposal-list" class="proposal-card">
                        <p><strong>Proposal Id:</strong> <?php echo $proposal['Proposal_ID']; ?></p>
                        <p><strong>Proposal Title:</strong> <?php echo $proposal['Proposal_Title']; ?></p>
                        <p><strong>Submitted on:</strong> <?php echo $proposal['Submission_Date']; ?></p>
                        <p><strong>Status:</strong> <?php echo $proposal['Status']; ?></p>
                        <a href="../../../../backend/helpers/downloadFIles.php?file=<?php echo urlencode($proposal['Proposal_File']); ?>" target="_blank">
                        <?php echo htmlspecialchars($proposal['Proposal_File']); ?>
                        </a>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No proposals found.</p>
            <?php endif; ?>
        </main>
    </div>
</div>
</body>
</html>
