<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student HomePage</title>
    <link rel="stylesheet" href="../../../css/student_home_page.css">
</head>

<body>
    <header>
        <a href="https://online.mmu.edu.my/">
            <img class="university-logo" src="../../../assets/imgs/MMU-logo.png" alt="Multimedia University Logo">
        </a>
    </header>

    <nav class="navigation-bar">
        <div class="nav-item">
            <a class="nav-link home-page-link" id="Logout-button" href="#">Student Home Page</a>
        </div>
        <div class="nav-item">
            <a class="nav-link logout-link" id="Homepage-button"href="../../../../frontend/views/all_users/login_page/login_page.php"
            >Logout</a>
        </div>
    </nav>

    <main>
        <section class="card">
            <a href="../project_management_page/project_management_page.php">
                <h2>Final Year Project</h2>
                <img src="../../../assets/imgs/proposal.png" alt="Proposal Management">
            </a>
        </section>

        <section class="card">
            <a href="../view_meetings/view_meetings_page.php">
                <h2>Meeting Management</h2>
                <img src="../../../assets/imgs/business.png" alt="Meeting Management">
            </a>
        </section>

        <section class="card">
            <a href="../view_announcements_page/view_announcements_page.php">
                <h2>Announcements</h2>
                <img src="../../../assets/imgs/mail.png" alt="Announcements">
            </a>
        </section>

        <section class="card">
            <a href="../view_profile_page/profile_page.php">
                <h2>Profile Management</h2>
                <img src="../../../assets/imgs/account-manager.png" alt="Profile Management">
            </a>
        </section>
    </main>
</body>

</html>