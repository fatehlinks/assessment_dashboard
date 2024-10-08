<?php include('auth.php'); ?>

<?php
if (isset($_GET['id'])) {

    $subject_id = mysqli_real_escape_string($cn, $_GET['id']);

    $delete_subject_qry = "DELETE FROM subjects WHERE subject_id = '$subject_id'";

    // Run the query
    if (mysqli_query($cn, $delete_subject_qry)) {
        $_SESSION['success_sweetalert_displayed'] = true;
        header("location:view-subjects.php");
        exit();
    } else {
        // Handle error
        echo "Error: " . mysqli_error($cn);
    }
} else {
    header("location:view-subjects.php");
    exit();
}
?>
