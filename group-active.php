<?php include('auth.php'); ?>

<?php
if (isset($_GET['id'])) {
    // Get the group_id and the current status from the query string
    $group_id = mysqli_real_escape_string($cn, $_GET['id']);

    $status_qry = "UPDATE groups SET group_status = 1 WHERE group_id = '$group_id'";

    if (mysqli_query($cn, $status_qry)) {
        $_SESSION['success_sweetalert_displayed'] = true;
        header("location:add-group.php");
        exit();
    } else {
        // Handle error
        echo "Error: " . mysqli_error($cn);
    }
} else {
    // If no ID or status is passed, redirect to the view page
    header("location:add-group.php");
    exit();
}
?>
