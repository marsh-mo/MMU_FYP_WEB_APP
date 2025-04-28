<?php
session_start(); // Start session at the top
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../css/login_page.css?v=<?php echo time(); ?>">
    <script defer src="../../../js/login_validation.js?v=<?php echo time(); ?>"></script> <!-- JavaScript Validation -->
</head>

<body>
    <div class="container">
        <img src="../../../assets/logo/MMU_logo.png" alt="MMU Logo" id="logo">
        <div class="login-box">
            <div class="top-section">
                <h2>Login</h2>
            </div>
            
            <div class="bottom-section">
                <form action="../../../../backend/controllers/login_controller.php" method="GET" class="login_form" id="login_form">
                    <div class="input-group">
                        <input type="email" name="email" id="email" placeholder="Email" required>
                        <span class="icon"><i class="fas fa-envelope"></i></span>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Password" required>
                        <span class="icon"><i class="fas fa-lock"></i></span>
                    </div>
                    <div class="submission-section">
                        <button class="btn" type="submit" name="login">Login</button>
                         <!-- Error Messages -->
                        <div class="error-message" id="error-message">
                            <?php if (isset($_SESSION['error'])): ?>
                                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                            <?php endif; ?>
                        </div>
                        <p class="register-text">dont have an account ? <a href="../../Student/registration_page/registration_page.php">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>



