<?php include('auth.php');  ?>
<?php


if (isset($_POST['group_id'])) {
    $group_id = $_POST['group_id'];

    // Fetch group categories based on the group ID
    $query = "SELECT group_category FROM groups WHERE group_id = ?";
    $stmt = mysqli_prepare($cn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $group_id);
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
    // Handle error if group_id is not set
    echo json_encode(['error' => 'No group_id provided.']);
}
