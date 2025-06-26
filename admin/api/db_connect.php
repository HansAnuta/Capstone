<?php
// api/db_connect.php

// Set headers for CORS (Cross-Origin Resource Sharing)
// This allows your frontend (running on localhost) to fetch data from this API.
// In a production environment, replace '*' with your specific frontend domain(s) for security.
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Enable error reporting for debugging during development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
// These match your WAMP server's default MySQL settings
$servername = "localhost";
$username = "root";
$password = ""; // No password as per your setup
$dbname = "digital_judging_db"; // Your database name

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    // If connection fails, send a JSON error response and exit
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit(); // Stop script execution
}

// Optionally, set character set to UTF-8 to prevent character encoding issues
$conn->set_charset("utf8");

?>
