<?php include('auth.php'); ?>

<?php
if (isset($_GET['id'])) {
    // Get the teacher_id and the current status from the query string
    $teacher_id = mysqli_real_escape_string($cn, $_GET['id']);

    $status_qry = "UPDATE teachers SET teacher_status = 0 WHERE teacher_id = '$teacher_id'";

    if (mysqli_query($cn, $status_qry)) {
        $_SESSION['success_sweetalert_displayed'] = true;
        header("location:view-teachers.php");
        exit();
    } else {
        // Handle error
        echo "Error: " . mysqli_error($cn);
    }
} else {
    // If no ID or status is passed, redirect to the view page
    header("location:view-teachers.php");
    exit();
}
?>