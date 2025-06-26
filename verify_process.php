<?php
session_start();

if (!isset($_SESSION['pending_user'])) {
    echo "Session expired. Please try again.";
    exit();
}

$entered_code = $_POST['code'] ?? '';
$actual_code = $_SESSION['pending_user']['code'];

if ($entered_code != $actual_code) {
    echo "Incorrect code. <a href='verify.php'>Try again</a>";
    exit();
}

// Insert to DB
$data = $_SESSION['pending_user'];
$conn = new mysqli("localhost", "root", "", "digital_judging_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO users (username, password_hash, role, created_at) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $data['username'], $data['password_hash'], $data['role'], $data['created_at']);

if ($stmt->execute()) {
    unset($_SESSION['pending_user']);
    header("Location: login.php?signup=success");
} else {
    echo "Database error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
