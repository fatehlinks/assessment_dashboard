<?php include('auth.php'); ?>

<?php
if (isset($_GET['id'])) {
    // Get the student_id and the current status from the query string
    $student_id = mysqli_real_escape_string($cn, $_GET['id']);

    $status_qry = "UPDATE students SET student_status = 0 WHERE student_id = '$student_id'";

    if (mysqli_query($cn, $status_qry)) {
        $_SESSION['primary_sweetalert_displayed'] = true;
        header("location:view-students.php");
        exit();
    } else {
        // Handle error
        echo "Error: " . mysqli_error($cn);
    }
} else {
    // If no ID or status is passed, redirect to the view page
    header("location:view-students.php");
    exit();
}
?>
