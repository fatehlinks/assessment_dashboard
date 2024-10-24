<?php
include("auth.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the assessment ID, student IDs, and obtained marks from the form
    $assessment_ids = $_POST['assessment_id'];
    $student_ids = $_POST['student_id'];
    $obtained_marks = $_POST['obtain_marks'];

    $insert_query = "INSERT INTO marking (marking_assessment_id, marking_student_id, marking_obtained_marks, marking_total_marks, marking_status) VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = mysqli_prepare($cn, $insert_query);
    if (!$stmt) {
        die('SQL Error: ' . mysqli_error($cn));
    }

    $total_marks = $_POST["total_marks"];
    $marking_status = 1; // set status 1 

    // Concatenate student IDs and obtained marks into strings
    $student_ids_string = implode(',', $student_ids);
    $obtained_marks_string = implode(',', $obtained_marks);

    // Bind the parameters for the insert statement
    mysqli_stmt_bind_param($stmt, "isssi", $assessment_ids[0], $student_ids_string, $obtained_marks_string, $total_marks, $marking_status);

    if (mysqli_stmt_execute($stmt)) {
        // On success
        $_SESSION['primary_sweetalert_displayed'] = true;
        header("Location: view-assessment.php");
        exit();
    } else {
        // On failure
        $_SESSION['error_sweetalert_displayed'] = true;
        $_SESSION['error_message'] = 'Error adding assessment. Please try again.';
        header("Location: view-assessment.php");
        exit();
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
