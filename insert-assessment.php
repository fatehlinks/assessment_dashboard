<?php include("auth.php") ?>

<?php

if (isset($_POST['add-assessment-btn'])) {
    // Get the form data
    $assessment_date =  $_POST['assessmt_date'];
    $assessment_grade =  $_POST['assessmt_grade'];
    $teacher_subject =  $_POST['teacher_subject'];
    $assessment_section =  $_POST['assessmt_section'];
    $assessment_group =  $_POST['assessmt_group'];
    $assessment_group_category =  $_POST['assessmt_group_category'];
    $num_of_students = mysqli_real_escape_string($cn, $_POST['assessmt_number_of_students']);
    $total_marks = mysqli_real_escape_string($cn, $_POST['assessmt_total_marks']);

    $assessment_deadline =  $_POST['assessment_deadline'];
    $assessment_status = 1;

    // Insert query
    $insertQuery = "INSERT INTO assessments (assessment_date, assessment_grade, assessment_subject, assessment_section, assessment_group, assessment_group_category, assessment_number_of_students, assessment_total_marks, assessment_deadline , assessment_status) 
                    VALUES ('$assessment_date', '$assessment_grade', '$teacher_subject', '$assessment_section', '$assessment_group', ' $assessment_group_category', '$num_of_students', '$total_marks' , '$assessment_deadline' , '$assessment_status')";

    // Execute the query
    if (mysqli_query($cn, $insertQuery)) {
        // On primary, set session and redirect
        $_SESSION['primary_sweetalert_displayed'] = true;
        header("Location: add-assessment.php");
    } else {
        // On failure, set error message and redirect
        $_SESSION['error_sweetalert_displayed'] = true;
        $_SESSION['error_message'] = 'Error adding assessment. Please try again.';
        header("Location: add-assessment.php");
    }
}
