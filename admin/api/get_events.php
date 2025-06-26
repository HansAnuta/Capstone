<?php
// api/get_events.php

// Include the database connection file
require_once 'db_connect.php';

// SQL query to select event data
// Uses 'event_id', 'event_name', and 'created_at' as per your Data Dictionary
// Orders results by 'created_at' in descending order (most recent first)
$sql = "SELECT event_id, event_name, created_at FROM events ORDER BY created_at DESC";

// Execute the query
$result = $conn->query($sql);

$events = []; // Initialize an empty array to store fetched events

// Check if there are any rows returned
if ($result && $result->num_rows > 0) {
    // Loop through each row and add it to the $events array
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Encode the $events array into a JSON string and output it
echo json_encode($events);

// Close the database connection
$conn->close();
?>
