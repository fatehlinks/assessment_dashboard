<?php include('auth.php'); ?>

<?php
// Add add school section
if (isset($_POST['add-school'])) {
    $school_name = mysqli_real_escape_string($cn, $_POST['school_name']);
    $school_status = 1;
    // Check if the school already exists
    $check_school_qry = "SELECT * FROM schools WHERE school_name = '$school_name'";
    $check_school_qry_run = mysqli_query($cn, $check_school_qry);

    if (mysqli_num_rows($check_school_qry_run) > 0) {
        // school already exists
        $_SESSION['error_sweetalert_displayed'] = true;
        $_SESSION['error_message'] = 'This school is already Exist.';
        header("Location:add-school.php");
        exit();
    } else {
        $add_school_qry = "INSERT INTO schools (school_name, school_status) VALUES('$school_name', '$school_status')";
        $add_school_qry_run = mysqli_query($cn, $add_school_qry);
        if ($add_school_qry_run) {
            $_SESSION['primary_sweetalert_displayed'] = true;
            header("Location:add-school.php");
            exit();
        }
    }
}
// End of add school section

?>