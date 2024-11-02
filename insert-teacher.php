<?php include('user-auth.php'); ?>

<?php
// Add teacher section
if (isset($_POST['add-teacher-btn'])) {
    $teacher_name = mysqli_real_escape_string($cn, $_POST['teacher_name']);
    $teacher_cnic = mysqli_real_escape_string($cn, $_POST['teacher_cnic']);
    $teacher_joining_date = $_POST['teacher_joining_date'];
    $teacher_dob = $_POST['teacher_dob'];
    $teacher_mobile = mysqli_real_escape_string($cn, $_POST['teacher_mobile']);
    $teacher_subject = $_POST['teacher_subject'];
    $teacher_school = $_POST['teacher_school'];
    $teacher_status = 1;

    // Insert teacher into the database
    $add_teacher_qry = "INSERT INTO teachers (teacher_name, teacher_cnic, teacher_joining_date, teacher_dob ,teacher_mobile, teacher_subject, teacher_school_id , teacher_status) 
                        VALUES ('$teacher_name', '$teacher_cnic', '$teacher_joining_date' , '$teacher_dob' , '$teacher_mobile', '$teacher_subject' ,  '$teacher_school'  , '$teacher_status')";
    $add_teacher_qry_run = mysqli_query($cn, $add_teacher_qry);

    if ($add_teacher_qry_run) {
        $_SESSION['primary_sweetalert_displayed'] = true;
        header("location:add-teacher.php");
        exit();
    } else {
        // Handle error (optional)
        echo "Error: " . mysqli_error($cn);
    }
}
// End of add teacher section
