<?php
session_start();
require_once 'db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Please fill in both fields.";
    } else {
        $stmt = $conn->prepare("SELECT user_id, username, password_hash, role FROM users WHERE username = ? AND is_active = 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password_hash'])) {
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header("Location: admin/dashboard.html");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Judging System</title>
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
                    <div class="podium-step step-2"><div class="step-number">2</div></div>
                    <div class="podium-step step-1"><div class="step-number">1</div></div>
                    <div class="podium-step step-3"><div class="step-number">3</div></div>
                </div>
            </div>

            <div class="login-container">
                <h2 class="text-2xl font-bold mb-8 text-gray-800 uppercase">LOGIN</h2><br>
                <form action="login.php" method="POST">
                    <input type="text" name="username" placeholder="USERNAME" class="input-field" required>
                    <input type="password" name="password" placeholder="PASSWORD" class="input-field" required>
                    <a href="#">Forgot password?</a>
                    <div class="error-message">
                        <?php if (!empty($error)) echo htmlspecialchars($error); ?>
                    </div>
                    <button type="submit" class="login-button">LOGIN</button>
                </form>
                <a href="signup.php" class="link-text">Don't have an account?</a>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>A Capstone Project of</p><br>
        <p>Hans Matthew L. Anuta</p><br>
        <p>Kezia G. C</p>
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
