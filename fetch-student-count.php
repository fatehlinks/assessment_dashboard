<?php
include('auth.php'); // Ensure user authentication

if (isset($_POST['grade']) && isset($_POST['group']) && isset($_POST['group_category']) && isset($_POST['section'])) {
    // Sanitize input to prevent SQL injection
    $grade = mysqli_real_escape_string($cn, $_POST['grade']);
    $group = mysqli_real_escape_string($cn, $_POST['group']);
    $group_category = mysqli_real_escape_string($cn, $_POST['group_category']);
    $section = mysqli_real_escape_string($cn, $_POST['section']);

    // SQL query to count active students with matching criteria
    $query = "SELECT COUNT(*) AS student_count 
              FROM students 
              WHERE student_grade = '$grade' 
              AND student_group = '$group' 
              AND student_group_category = '$group_category' 
              AND student_section = '$section'
              AND student_status = 1";  // Only count active students (status = 1)

    $result = mysqli_query($cn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode(['student_count' => $data['student_count']]); // Return the count as JSON
    } else {
        echo json_encode(['error' => 'Error fetching data: ' . mysqli_error($cn)]);
    }
} else {
    echo json_encode(['error' => 'Missing required parameters']);
}
