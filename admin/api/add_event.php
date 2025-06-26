<?php
// api/add_event.php

require_once 'db_connect.php'; // Include the database connection helper

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $input = file_get_contents('php://input');
    $data = json_decode($input, true); // Decode the JSON data

    // Check if event_name and admin_id are provided
    if (isset($data['event_name']) && isset($data['admin_id'])) {
        $eventName = $data['event_name'];
        $adminId = (int)$data['admin_id']; // Cast to integer for safety

        // Get current timestamp for created_at
        $createdAt = date('Y-m-d H:i:s');

        // Prepare the SQL INSERT statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO events (admin_id, event_name, created_at) VALUES (?, ?, ?)");
        
        // Check if statement preparation was successful
        if ($stmt === false) {
            echo json_encode(["success" => false, "error" => "Failed to prepare statement: " . $conn->error]);
            $conn->close();
            exit();
        }

        // Bind parameters: 'i' for integer, 's' for string, 's' for string
        $stmt->bind_param("iss", $adminId, $eventName, $createdAt);

        // Execute the statement
        if ($stmt->execute()) {
            // If insertion is successful, return success message
            echo json_encode(["success" => true, "message" => "Event '{$eventName}' added successfully.", "event_id" => $conn->insert_id]);
        } else {
            // If execution fails, return error message
            echo json_encode(["success" => false, "error" => "Failed to add event: " . $stmt->error]);
        }

        // Close the statement
        $stmt->close();
    } else {
        // If required parameters are missing
        echo json_encode(["success" => false, "error" => "Event name and admin ID are required."]);
    }
} else {
    // If not a POST request
    echo json_encode(["success" => false, "error" => "Invalid request method. Only POST is allowed."]);
}

// Close the database connection
$conn->close();
?>
