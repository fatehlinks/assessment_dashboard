<?php
include('config.php');

if (isset($_POST['group_id'])) {
    $group_id = $_POST['group_id'];

    // Fetch all categories for the selected group_id
    $query = "SELECT category_name FROM group_categories WHERE group_id = ?";
    $stmt = $cn->prepare($query);
    $stmt->bind_param("i", $group_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category_name'];
    }

    echo json_encode(['categories' => $categories]);
    $stmt->close();
}
