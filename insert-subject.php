<?php include('auth.php'); ?>
<?php
// Add add subject section
if (isset($_POST['add-subject'])) {
    $subject_name = mysqli_real_escape_string($cn, $_POST['subject_name']);
    $subject_grade =  $_POST['subject_grade'];
    $subject_status = 1;

    $add_subject_qry = "INSERT INTO subjects (subject_name, subject_grade , subject_status) VALUES('$subject_name', '$subject_grade' , '$subject_status')";
    $add_subject_qry_run = mysqli_query($cn, $add_subject_qry);
    if ($add_subject_qry_run) {
        $_SESSION['primary_sweetalert_displayed'] = true;
        header("location:add-subject.php");
        exit();
    }
}
// End of add subject section

?>