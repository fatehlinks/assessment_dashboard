<?php include('auth.php'); ?>

<?php
if (isset($_GET['id'])) {

    $teacher_id = mysqli_real_escape_string($cn, $_GET['id']);

    $delete_teacher_qry = "DELETE FROM teachers WHERE teacher_id = '$teacher_id'";

    // Run the query
    if (mysqli_query($cn, $delete_teacher_qry)) {
        $_SESSION['success_sweetalert_displayed'] = true;
        header("location:view-teachers.php");
        exit();
    } else {
        // Handle error
        echo "Error: " . mysqli_error($cn);
    }
} else {
    header("location:view-teachers.php");
    exit();
}
?>