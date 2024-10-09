<?php
include('auth.php');

if (isset($_POST['group_name'])) {
    $group_name = $_POST['group_name'];

    // Fetch group categories based on the group name (e.g., "Matric" or "Intermediate")
    $query = "SELECT group_category FROM groups WHERE group_name = ?";
    $stmt = mysqli_prepare($cn, $query);
    mysqli_stmt_bind_param($stmt, 's', $group_name); // Use string for group name
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Collect categories in an array
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['group_category'];
    }

    // Return the categories as a JSON response
    echo json_encode(['categories' => $categories]);
} else {
    // Handle error if group_name is not set
    echo json_encode(['error' => 'No group_name provided.']);
}
