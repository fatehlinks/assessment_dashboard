<?php include('auth.php'); ?>

<?php
// Include database connection
include('config.php');

// Check if the form is submitted
if (isset($_POST['add-student-btn'])) {
    // Sanitize and assign input values
    $student_reg_id = mysqli_real_escape_string($cn, $_POST['student_reg_id']);
    $student_cnic = mysqli_real_escape_string($cn, $_POST['student_cnic']);
    $student_mobile = mysqli_real_escape_string($cn, $_POST['student_mobile']);
    $student_name = mysqli_real_escape_string($cn, $_POST['student_name']);
    $student_father_name = mysqli_real_escape_string($cn, $_POST['student_father_name']);
    $student_dob = mysqli_real_escape_string($cn, $_POST['student_dob']);
    $student_gender = mysqli_real_escape_string($cn, $_POST['student_gender']);
    $student_address = mysqli_real_escape_string($cn, $_POST['student_address']);
    $student_grade = $_POST['student_grade'];
    $student_section = mysqli_real_escape_string($cn, $_POST['student_section']);
    $student_group = $_POST['student_group'];
    $student_remarks = mysqli_real_escape_string($cn, $_POST['student_remarks']);
    $student_status = 1;

    // Check if the registration ID already exists
    $check_query = "SELECT COUNT(*) FROM students WHERE student_reg_id = '$student_reg_id'";
    $check_result = mysqli_query($cn, $check_query);
    $count = mysqli_fetch_row($check_result)[0];

    if ($count > 0) {
        // Registration ID already exists
        $_SESSION['error_sweetalert_displayed'] = true;
        $_SESSION['error_message'] = "Registration ID already exists.";
        header("Location: add-student.php"); // Redirect on error
        exit(); // Exit to avoid further execution
    } else {
        // Prepare the SQL INSERT statement
        $insert_query = "INSERT INTO students (student_reg_id, student_cnic, student_mobile, student_name, student_father_name, student_dob, student_gender, student_address, student_grade, student_section, student_group, student_remarks , student_status)
        VALUES ('$student_reg_id', '$student_cnic', '$student_mobile', '$student_name', '$student_father_name', '$student_dob', '$student_gender', '$student_address', $student_grade, '$student_section', $student_group, '$student_remarks' , '$student_status')";

        // Execute the query
        if (mysqli_query($cn, $insert_query)) {
            // Set a session variable to trigger the SweetAlert
            $_SESSION['success_sweetalert_displayed'] = true;
            header("Location: add-student.php"); // Redirect after successful insertion
        } else {
            // Error handling
            $_SESSION['error_sweetalert_displayed'] = true;
            $_SESSION['error_message'] = mysqli_error($cn);
            header("Location: add-student.php"); // Redirect on error
        }
    }
}
