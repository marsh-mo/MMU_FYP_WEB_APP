<?php
session_start();
include '../../../../backend/config/db_connect.php';
include '../../../../backend/models/project_model.php';
include '../../../../backend/models/proposal_model.php'; 
include '../../../../backend/models/user_model.php'; 


// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must be logged in!";
    header("Location: ../../all_users/login_page/login_page.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch proposal 
$proposal = getProposal($conn, $user_id);

// Fetch assigned project
$project = getAssignedProject($conn, $user_id);
$project_title = $project ? htmlspecialchars($project['Title']) : "No project assigned";

// Fetch Supervisor Details
$supervisor = getSuperVisorDetails($conn, $user_id);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Year Project</title>
    <link rel="stylesheet" href="../../../css/project_management_page.css?v=<?php echo time(); ?>">
    <script defer src="../../../js/file_upload_validation.js"></script> <!-- JavaScript Validation -->
</head>
<body>
<div class ="header" style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
    <h2> Final Year Project </h2>
    <a href="../../../../frontend/views/all_users/login_page/login_page.php">
        <button class="logout-btn">Logout</button>
    </a>
</div>
<div class="container">
    <div class="sidebar">
        <ul>
            <li class="<?= (isset($_GET['page']) && $_GET['page'] == 'manage_proposal') ? 'active' : ''; ?>">
                <a href="?page=manage_proposal">📁 Manage Proposal</a>
            </li>
            <li class="<?= (isset($_GET['page']) && $_GET['page'] == 'view_fyp') ? 'active' : ''; ?>">
                <a href="?page=view_fyp">📁 Assigned Project</a>
            </li>
            <li class="<?= (isset($_GET['page']) && $_GET['page'] == 'view_supervisor') ? 'active' : ''; ?>">
                <a href="?page=view_supervisor">👤 View Supervisor Details</a>
            </li>
        </ul>
    </div>

    <div class="content">
        <?php
        if (isset($_GET['page']) && $_GET['page'] == 'manage_proposal') {
            ?>
            <div class="proposal-box">
                <h3>Manage Proposal</h3>
                

                <?php if ($proposal): ?>
                    <p><strong>Submission Status:</strong> Submitted</p>
                    <p><strong>Proposal Title:</strong> <?php echo htmlspecialchars($proposal['Proposal_Title']); ?></p>
                    <p><strong>Submission Date:</strong> <?php echo htmlspecialchars($proposal['Submission_Date']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($proposal['Status']); ?></p>
                    <p><strong>Proposal File:</strong> 
                        <a href="../../../../backend/helpers/downloadFiles.php?file=<?php echo urlencode(basename($proposal['Proposal_File'])); ?>" download>
                            <?php echo htmlspecialchars(basename($proposal['Proposal_File'])); ?>
                        </a>
                    </p>
                <?php else: ?>
                    <p><strong>Submission Status:</strong> Not Submitted</p>
                    <form action="../../../../backend/controllers/proposal_controller.php" method="POST" enctype="multipart/form-data" class="proposal-form">
                        <div class="form-group">
                            <label for="proposal_title"><b>Proposal Title:</b></label>
                            <input type="text" id="proposal_title" name="proposal_title" required>
                        </div>

                        <div class="form-group">
                            <label for="proposal_file"><b>Upload Proposal:</b></label>
                            <input type="file" id="proposal_file" name="proposal_file" required>
                        </div>

                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); ?>">
            
                        <button type="submit" name="submit_proposal" class="submit-btn">Submit Proposal</button>
                    </form>
                <?php endif; ?>
            </div>
            <?php
        } elseif (isset($_GET['page']) && $_GET['page'] == 'view_fyp') {
            ?>
    <!-- Project Box -->
    <div class="fyp-box">
        <h3>Project</h3>
        <?php  if (!$project): ?>
            <p><strong>Project Title:</strong> No project assigned</p>
        <?php else: ?>
            <p><strong>Project Title:</strong> <?php echo $project_title; ?></p>
        <?php endif; ?>
    </div>

    <?php if ($project): // Only show the submission section if a project is assigned ?>
        <!-- Submission Box -->
        <div class="submission-box">
            <h3>Project Submission</h3>
            
            <?php
            // Fetch submitted project details
            $submission_query = $conn->prepare("
                SELECT Submission_File, Submission_Date, Marks, Feedback, Status 
                FROM Submitted_Project 
                WHERE Project_ID = ?
            ");
            $submission_query->bind_param("i", $project['Project_ID']);
            $submission_query->execute();
            $submission_result = $submission_query->get_result();
            $submission = $submission_result->fetch_assoc() ?? null;
            ?>

            <?php if (!$submission): ?>
                <form action="../../../../backend/controllers/project_controller.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); ?>">
                    <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($project['Project_ID']); ?>">
                    <label>Upload Project File:</label>
                    <input type="file" name="project_file" required>
                    <button type="submit" name="submit_project">Submit Project</button>
                </form>
            <?php else: ?>
                <p><strong>Submitted File:</strong> 
                    <a href="../../../../backend/helpers/downloadFile.php?file=<?php echo urlencode(basename($submission['Submission_File'])); ?>" download>
                        <?php echo htmlspecialchars(basename($submission['Submission_File'])); ?>
                    </a>
                </p>
                <p><strong>Submission Date:</strong> <?php echo htmlspecialchars($submission['Submission_Date']); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($submission['Status']); ?></p>
                <p><strong>Feedback:</strong> <?php echo $submission['Feedback'] ? htmlspecialchars($submission['Feedback']) : "No feedback yet"; ?></p>
                <p><strong>Marks:</strong> <?php echo $submission['Marks'] !== null ? htmlspecialchars($submission['Marks']) : "Marks not assigned"; ?></p>
            <?php endif; ?>
        </div>
    <?php endif; // End of submission box condition ?>
    <?php
        } elseif (isset($_GET['page']) && $_GET['page'] == 'view_supervisor') {
            ?>
            <div class="supervisor-box">
                <h3>Supervisor Details</h3>
                <?php if ($supervisor): ?>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($supervisor['Full_Name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($supervisor['Email']); ?></p>
                <?php else: ?>
                    <p>No supervisor assigned.</p>
                <?php endif; ?>
            </div>
            <?php
        } else {
            echo "<p>Select an option from the sidebar.</p>";
        }
        ?>
    </div>
</div>
</body>
</html>
