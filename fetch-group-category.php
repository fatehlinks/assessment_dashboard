<?php
include('config.php');

if (isset($_POST['group_id'])) {
    $group_id = $_POST['group_id'];

    // Debug: Check the received group_id
    error_log("Received group_id: " . $group_id); // This will log the group_id to your error log

    // Fetch the group category based on group_id
    $query = "SELECT group_category FROM groups WHERE group_id = ?";
    $stmt = $cn->prepare($query);
    $stmt->bind_param("i", $group_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Debug: Check if the query returned a result
    if ($row = $result->fetch_assoc()) {
        echo json_encode(['category' => $row['group_category']]);
    } else {
        echo json_encode(['category' => '']);
        error_log("No category found for group_id: " . $group_id); // Log when no category is found
    }
    $stmt->close();
}
