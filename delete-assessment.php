<?php include('auth.php'); ?>

<?php
if (isset($_GET['id'])) {
    // Get the assessment_id and the current status from the query string
    $assessment_id = mysqli_real_escape_string($cn, $_GET['id']);

    $status_qry = "UPDATE assessments SET assessment_status = -1 WHERE assessment_id = '$assessment_id'";

    if (mysqli_query($cn, $status_qry)) {
        $_SESSION['success_sweetalert_displayed'] = true;
        header("location:view-assessment.php");
        exit();
    } else {
        // Handle error
        echo "Error: " . mysqli_error($cn);
    }
} else {
    // If no ID or status is passed, redirect to the view page
    header("location:view-assessment.php");
    exit();
}
?>
