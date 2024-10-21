<?php include('auth.php'); ?>
<?php

if (isset($_POST['group_id'])) {
    $group_id = $_POST['group_id'];


    // Query to fetch categories based on group_id
    $query = "SELECT category_id, category_name FROM category WHERE group_id = $group_id AND category_status = 1";
    $result = mysqli_query($cn, $query);

    if ($result) {
        $categories = [];

        // Fetch categories
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = [
                'category_id' => $row['category_id'],
                'category_name' => $row['category_name']
            ];
        }

        header('Content-Type: application/json');
        // Return JSON response
        echo json_encode(['categories' => $categories]);
        exit;
    } else {
        // Return an error message if the query fails
        echo json_encode(['error' => 'Query execution failed: ' . mysqli_error($cn)]);
    }
} else {
    // Return an error if no group_id is provided
    echo json_encode(['error' => 'No group_id provided.']);
}
