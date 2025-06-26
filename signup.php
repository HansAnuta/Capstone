<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Use null coalescing operator to avoid undefined index errors
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: signup.php?error=empty_fields");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signup.php?error=invalid_email");
        exit();
    }

    if ($password !== $confirm_password) {
        header("Location: signup.php?error=password_mismatch");
        exit();
    }

    // Connect to DB and check for existing username
    $conn = new mysqli("localhost", "root", "", "digital_judging_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        header("Location: signup.php?error=username_taken");
        exit();
    }
    $stmt->close();
    $conn->close();

    // Generate verification code
    $verification_code = rand(100000, 999999);

    // Store in session
    $_SESSION['pending_user'] = [
        'username' => $username,
        'email' => $email,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        'role' => 'judge',
        'code' => $verification_code,
        'created_at' => date("Y-m-d H:i:s")
    ];

    // Redirect to verification
    header("Location: verify.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
                    <div class="podium-step step-2"><div class="step-number">2</div></div>
                    <div class="podium-step step-1"><div class="step-number">1</div></div>
                    <div class="podium-step step-3"><div class="step-number">3</div></div>
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
                            $errors = [
                                'empty_fields' => "Please fill in all fields.",
                                'invalid_email' => "Invalid email format.",
                                'password_mismatch' => "Passwords do not match.",
                                'username_taken' => "Username is already taken.",
                                'email_taken' => "Email is already registered."
                            ];
                            echo $errors[$_GET['error']] ?? '';
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
                step.addEventListener('mouseenter', () => step.style.transform = 'scale(1.05) rotate(2deg)');
                step.addEventListener('mouseleave', () => step.style.transform = 'scale(1) rotate(0deg)');
            });
        });
    </script>
</body>
</html>
