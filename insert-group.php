<?php include('auth.php'); ?>
<?php
// Add add group section
if (isset($_POST['add-group'])) {
    $group_name = mysqli_real_escape_string($cn, $_POST['group_name']);
    $group_category = mysqli_real_escape_string($cn, $_POST['group_category']);
    $group_status = 1;

    $add_group_qry = "INSERT INTO groups (group_name, group_category , group_status) VALUES('$group_name', '$group_category' , '$group_status')";
    $add_group_qry_run = mysqli_query($cn, $add_group_qry);
    if ($add_group_qry_run) {
        $_SESSION['primary_sweetalert_displayed'] = true;
        header("location:add-group.php");
        exit();
    }
}
// End of add group section

?>