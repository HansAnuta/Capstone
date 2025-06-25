<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Judging System - Sign Up</title>
    <link rel="stylesheet" href="index-style.css">
    <link rel="stylesheet" href="form-style.css">
</head>
<body>
    <div class="container">
        <div class="decorative-shape"></div>
        
        <div class="content">
            <div class="left-section">
                <h1 class="title">Digital Judging System</h1>
                
                <div class="podium-container">
                    <div class="podium-step step-2">
                        <div class="step-number">2</div>
                    </div>
                    <div class="podium-step step-1">
                        <div class="step-number">1</div>
                    </div>
                    <div class="podium-step step-3">
                        <div class="step-number">3</div>
                    </div>
                </div>
            </div>

            <div class="login-container">
                <h2 class="text-2xl font-bold mb-8 text-gray-800 uppercase">SIGN UP</h2><br>
                <form action="signup.php" method="POST">
                    <input type="text" name="username" placeholder="USERNAME" class="input-field" required>
                    <input type="email" name="email" placeholder="EMAIL" class="input-field" required>
                    <input type="password" name="password" placeholder="PASSWORD" class="input-field" required>
                    <input type="password" name="confirm_password" placeholder="CONFIRM PASSWORD" class="input-field" required>
                    <div class="error-message">
                        <?php
                            if (isset($_GET['error'])) {
                                if ($_GET['error'] == 'empty_fields') {
                                    echo "Please fill in all fields.";
                                } elseif ($_GET['error'] == 'invalid_email') {
                                    echo "Invalid email format.";
                                } elseif ($_GET['error'] == 'password_mismatch') {
                                    echo "Passwords do not match.";
                                } elseif ($_GET['error'] == 'username_taken') {
                                    echo "Username is already taken.";
                                } elseif ($_GET['error'] == 'email_taken') {
                                    echo "Email is already registered.";
                                }
                            }
                        ?>
                    </div>
                    <button type="submit" class="login-button">CREATE ACCOUNT</button>
                </form>
                <a href="login.php" class="link-text">Already have an account?</a>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>A Capstone Project of</p><br>
        <p>Hans Matthew L. Anuta</p><br>
        <p>Kezia G. Carillo</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const podiumSteps = document.querySelectorAll('.podium-step');
            
            podiumSteps.forEach(step => {
                step.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05) rotate(2deg)';
                });
                
                step.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1) rotate(0deg)';
                });
            });
        });
    </script>
</body>
</html>