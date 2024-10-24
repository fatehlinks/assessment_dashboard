
<?php include("auth.php") ?>
<?php

// Get the posted filter parameters
$filter_assessment_id = $_POST['filter_assessment_id'];
$filter_subject_grade = $_POST['filter_subject_grade'] ?? null;
$filter_assessmt_section = $_POST['filter_assessmt_section'] ?? null;
$filter_assmt_group = $_POST['filter_assmt_group'] ?? null;
$filter_assmt_group_category = $_POST['filter_assmt_group_category'] ?? null;

// Build query based on filters
$query = "SELECT s.student_id, s.student_name, m.marking_obtained_marks, m.marking_total_marks FROM students s
          LEFT JOIN marking m ON s.student_id = m.marking_student_id AND m.marking_assessment_id = '$filter_assessment_id'
          LEFT JOIN assessments a ON a.assessment_id = '$filter_assessment_id'
          WHERE a.assessment_id = '$filter_assessment_id' AND a.assessment_status = 2";

// Apply dynamic filters
if ($filter_subject_grade) {
    $query .= " AND a.assessment_grade = '$filter_subject_grade'";
}
if ($filter_assessmt_section) {
    $query .= " AND a.assessment_section = '$filter_assessmt_section'";
}
if ($filter_assmt_group) {
    $query .= " AND a.assessment_group = '$filter_assmt_group'";
}
if ($filter_assmt_group_category) {
    $query .= " AND a.assessment_group_category = '$filter_assmt_group_category'";
}

$result = mysqli_query($cn, $query);

// Prepare the response
$response = ['success' => false, 'data' => []];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $response['data'][] = [
            'student_id' => $row['student_id'],
            'student_name' => $row['student_name'],
            'obtained_marks' => $row['marking_obtained_marks'] ?? 0,
            'total_marks' => $row['marking_total_marks'] ?? 0
        ];
    }
    $response['success'] = true;
}

// Return the response as JSON
echo json_encode($response);
