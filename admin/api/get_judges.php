<?php
// api/get_judges.php

// Include the database connection file
require_once 'db_connect.php';

// SQL query to select judge data
// Uses 'judge_id', 'email', and 'is_active' from the judges table
$sql = "SELECT judge_id, email, is_active FROM judges";

// Execute the query
$result = $conn->query($sql);

$judges = []; // Initialize an empty array to store fetched judges

// Check if there are any rows returned
if ($result && $result->num_rows > 0) {
    // Loop through each row and add it to the $judges array
    while($row = $result->fetch_assoc()) {
        // Convert tinyint(1) 'is_active' to boolean for cleaner JavaScript handling
        $row['is_active'] = (bool)$row['is_active'];
        $judges[] = $row;
    }
}

// Encode the $judges array into a JSON string and output it
echo json_encode($judges);

// Close the database connection
$conn->close();
?>
