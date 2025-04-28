
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../css/registration_page.css">
    <link rel="stylesheet" href="../../../js/validation.js">
</head>

<body>
    <div class="container">
        <img src="../../../assets/logo/MMU_logo.png" alt="MMU Logo" id="logo">
        <div class="login-box">
            <div class="top-section">
                <h2>Register Here</h2>
            </div>

            <div class="bottom-section">
                <form action="../../../../backend/controllers/registeration_controller.php" method="POST" class="registration_form" id="registrationForm">

                    <!-- Display Error Messages Here -->
                    <div class="error-message" id="error-message">
                        <?php session_start(); if (isset($_SESSION['error'])): ?>
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <?php endif; ?>
                    </div>

                    <div class="input-group">
                        <input type="text" id="full_name" name="full_name" placeholder="Full Name" required value="<?php echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : ''; ?>">
                        <span class="icon"><i class="fas fa-user"></i></span>
                    </div>
                    <div class="input-group">
                        <input type="email" id="email" name="email" placeholder="Email" required value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>">
                        <span class="icon"><i class="fas fa-envelope"></i></span>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <span class="icon"><i class="fas fa-lock"></i></span>
                    </div>

                    <div class="submission-section">
                        <div class="checkbox-container">
                            <input type="checkbox" id="terms" required>
                            <label for="terms">I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>.</label>
                        </div>
                        <button class="btn" type="submit" name="register">Register</button>
                        <p class="signin-text">Already have an account? <a href="../../all_users/login_page/login_page.php">Sign in</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
