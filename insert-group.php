<?php include('auth.php'); ?>

<?php
// Add add group section
if (isset($_POST['add-group'])) {
    $group_name = mysqli_real_escape_string($cn, $_POST['group_name']);
    $group_status = 1;
    // Check if the group already exists
    $check_group_qry = "SELECT * FROM groups WHERE group_name = '$group_name'";
    $check_group_qry_run = mysqli_query($cn, $check_group_qry);

    if (mysqli_num_rows($check_group_qry_run) > 0) {
        // Group already exists
        $_SESSION['error_sweetalert_displayed'] = true;
        $_SESSION['error_message'] = 'This Group is already Exist.';
        header("Location:add-group.php");
        exit();
    } else {
        $add_group_qry = "INSERT INTO groups (group_name, group_status) VALUES('$group_name', '$group_status')";
        $add_group_qry_run = mysqli_query($cn, $add_group_qry);
        if ($add_group_qry_run) {
            $_SESSION['primary_sweetalert_displayed'] = true;
            header("Location:add-group.php");
            exit();
        }
    }
}
// End of add group section

?>