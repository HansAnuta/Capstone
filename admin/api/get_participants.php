<?php
// api/get_participants.php

// Include the database connection file
require_once 'db_connect.php';

// SQL query to select participant data
// Uses 'participant_id', 'participant_name', 'competition_id', and 'category_id'
// from the participants table
$sql = "SELECT participant_id, participant_name, competition_id, category_id FROM participants";

// Execute the query
$result = $conn->query($sql);

$participants = []; // Initialize an empty array to store fetched participants

// Check if there are any rows returned
if ($result && $result->num_rows > 0) {
    // Loop through each row and add it to the $participants array
    while($row = $result->fetch_assoc()) {
        $participants[] = $row;
    }
}

// Encode the $participants array into a JSON string and output it
echo json_encode($participants);

// Close the database connection
$conn->close();
?>
