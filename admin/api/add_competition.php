<?php
// api/add_competition.php

require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Validate and sanitize inputs
    $competitionName = filter_var($data['competition_name'] ?? '', FILTER_SANITIZE_STRING);
    $eventId = filter_var($data['event_id'] ?? '', FILTER_VALIDATE_INT);
    $judgingMethodId = filter_var($data['judging_method_id'] ?? '', FILTER_VALIDATE_INT);

    if (empty($competitionName) || $eventId === false || $judgingMethodId === false) {
        echo json_encode(["success" => false, "error" => "Missing or invalid competition name, event ID, or judging method ID."]);
        $conn->close();
        exit();
    }

    $createdAt = date('Y-m-d H:i:s');

    // Prepare the SQL INSERT statement
    $stmt = $conn->prepare("INSERT INTO competitions (event_id, judging_method_id, competition_name, created_at) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => "Failed to prepare statement: " . $conn->error]);
        $conn->close();
        exit();
    }

    $stmt->bind_param("iiss", $eventId, $judgingMethodId, $competitionName, $createdAt);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Competition '{$competitionName}' added successfully.", "competition_id" => $conn->insert_id]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to add competition: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method. Only POST is allowed."]);
}

$conn->close();
?>
