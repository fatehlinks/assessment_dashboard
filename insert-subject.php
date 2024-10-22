<?php include('auth.php'); ?>
<?php
// Add add subject section
if (isset($_POST['add-subject'])) {
    $subject_name = mysqli_real_escape_string($cn, $_POST['subject_name']);
    $subject_grade =  $_POST['subject_grade'];
    $subject_status = 1;

    // First, check if a category with the same name and group already exists
    $check_duplicate_qry = "SELECT * FROM subjects WHERE subject_name = '$subject_name' AND subject_grade = '$subject_grade'";
    $check_duplicate_run = mysqli_query($cn, $check_duplicate_qry);

    if (mysqli_num_rows($check_duplicate_run) > 0) {
        // If a category with the same name in the group already exists, show error
        $_SESSION['error_sweetalert_displayed'] = true;
        $_SESSION['error_message'] = 'This Subject name already exists in this grade.';
        header("Location: add-subject.php");
        exit();
    } else {
        $add_subject_qry = "INSERT INTO subjects (subject_name, subject_grade , subject_status) VALUES('$subject_name', '$subject_grade' , '$subject_status')";
        $add_subject_qry_run = mysqli_query($cn, $add_subject_qry);
        if ($add_subject_qry_run) {
            $_SESSION['primary_sweetalert_displayed'] = true;
            header("location:add-subject.php");
            exit();
        }
    }
}
// End of add subject section

?>