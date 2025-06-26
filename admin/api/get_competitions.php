<?php
// api/get_competitions.php

// Include the database connection file
require_once 'db_connect.php';

// SQL query to select competition data, joining with the 'events' table
// to get the associated event name.
// Uses 'competition_id', 'competition_name', 'event_id', 'event_name', and 'created_at'
$sql = "SELECT
            c.competition_id,
            c.competition_name,
            c.event_id,
            e.event_name,
            c.created_at
        FROM
            competitions c
        JOIN
            events e ON c.event_id = e.event_id
        ORDER BY
            c.created_at DESC";

// Execute the query
$result = $conn->query($sql);

$competitions = []; // Initialize an empty array to store fetched competitions

// Check if there are any rows returned
if ($result && $result->num_rows > 0) {
    // Loop through each row and add it to the $competitions array
    while($row = $result->fetch_assoc()) {
        $competitions[] = $row;
    }
}

// Encode the $competitions array into a JSON string and output it
echo json_encode($competitions);

// Close the database connection
$conn->close();
?>
