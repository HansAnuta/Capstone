<?php
session_start();

if (!isset($_SESSION['pending_user'])) {
    echo "Session expired. Please <a href='signup.php'>sign up again</a>.";
    exit();
}

$code = $_SESSION['pending_user']['code'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Your Account</title>
    <link rel="stylesheet" href="form-style.css">
</head>
<body>
    <div class="container">
        <h2>Enter the verification code</h2>
        <p>A verification code was generated. (Code for testing: <strong><?php echo $code; ?></strong>)</p>
        <form action="verify_process.php" method="POST">
            <input type="text" name="code" placeholder="Enter code" required>
            <button type="submit">Verify</button>
        </form>
    </div>
</body>
</html>
