<?php include('auth.php'); ?>

<?php
if (isset($_GET['id'])) {
    // Get the subject_id and the current status from the query string
    $subject_id = mysqli_real_escape_string($cn, $_GET['id']);

    $status_qry = "UPDATE subjects SET subject_status = -1 WHERE subject_id = '$subject_id'";

    if (mysqli_query($cn, $status_qry)) {
        $_SESSION['success_sweetalert_displayed'] = true;
        header("location:add-subject.php");
        exit();
    } else {
        // Handle error
        echo "Error: " . mysqli_error($cn);
    }
} else {
    // If no ID or status is passed, redirect to the view page
    header("location:add-subject.php");
    exit();
}
?>
