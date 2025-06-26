<?php
// api/get_judging_methods.php

require_once 'db_connect.php';

$sql = "SELECT judging_method_id, method_name FROM judging_methods ORDER BY method_name ASC";
$result = $conn->query($sql);

$judgingMethods = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $judgingMethods[] = $row;
    }
}

echo json_encode($judgingMethods);

$conn->close();
?>
