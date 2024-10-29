<?php include('user-auth.php'); ?>

<?php
if (isset($_GET['id'])) {
    // Get the school_id and the current status from the query string
    $school_id = mysqli_real_escape_string($cn, $_GET['id']);

    $status_qry = "UPDATE schools SET school_status = 1 WHERE school_id = '$school_id'";

    if (mysqli_query($cn, $status_qry)) {
        $_SESSION['primary_sweetalert_displayed'] = true;
        header("location:add-school.php");
        exit();
    } else {
        // Handle error
        echo "Error: " . mysqli_error($cn);
    }
} else {
    // If no ID or status is passed, redirect to the view page
    header("location:add-school.php");
    exit();
}
?>
