<?php
// api/get_competitions_by_event.php

require_once 'db_connect.php';

// Ensure the event_id is provided in the GET request
if (isset($_GET['event_id']) && is_numeric($_GET['event_id'])) {
    $eventId = (int)$_GET['event_id']; // Cast to integer for security

    // Query to select competitions for a specific event, joining with judging_methods
    // to get the method_name for display.
    $sql = "SELECT
                c.competition_id,
                c.competition_name,
                c.event_id,
                c.judging_method_id,
                jm.method_name AS judging_method_name,
                c.created_at
            FROM
                competitions c
            JOIN
                judging_methods jm ON c.judging_method_id = jm.judging_method_id
            WHERE
                c.event_id = ?
            ORDER BY
                c.created_at DESC";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
        $conn->close();
        exit();
    }

    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();

    $competitions = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $competitions[] = $row;
        }
    }

    echo json_encode($competitions);
    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid or missing event_id parameter."]);
}

$conn->close();
?>
