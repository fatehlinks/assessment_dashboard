<?php include('auth.php');  ?>
<?php

if (isset($_POST['grade']) && isset($_POST['group']) && isset($_POST['group_category']) && isset($_POST['section'])) {
    $grade = $_POST['grade'];
    $group = $_POST['group'];
    $group_category = $_POST['group_category'];
    $section = $_POST['section'];

    // Prepare the SQL query to count the students
    $query = "SELECT COUNT(*) AS student_count 
              FROM students 
              WHERE student_grade = '$grade' 
              AND student_group = '$group' 
              AND student_group_category = '$group_category' 
              AND student_section = '$section'
              AND student_status == 1";

    $result = mysqli_query($cn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode(['student_count' => $data['student_count']]);
    } else {
        echo json_encode(['error' => 'Error fetching data']);
    }
}
